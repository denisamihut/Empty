<?php

namespace App\Http\Services;

use App\Models\Billing;
use App\Models\Process;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SellService
{

    protected int $businessId;
    protected int $branchId;
    protected string $type;
    protected Product $product;
    protected Service $service;
    protected Process $process;
    protected Billing $billing;
    protected ManagementService $managementService;

    public function __construct(int $businessId, int $branchId, string $type)
    {
        $this->businessId = $businessId;
        $this->branchId = $branchId;
        $this->type = $type;
        $this->product = new Product();
        $this->service = new Service();
        $this->process = new Process();
        $this->billing = new Billing();
        $this->managementService = new ManagementService($businessId, $branchId);
    }

    public function getCarts(): Collection
    {
        $sessionName = 'cart_' . $this->type . '_' . $this->branchId . '_' . $this->businessId;
        $cart = session()->get($sessionName) ?? [];
        $cart = collect($cart);
        if ($cart->count() > 0) {
            $cart = $cart->map(function ($item, $key) {
                $item['total'] = $item['quantity'] * $item['price'];
                return $item;
            });
        }
        return $cart;
    }

    public function removeFromSessionCart(int $productId): array
    {
        $sessionName = 'cart_' . $this->type . '_' . $this->branchId . '_' . $this->businessId;
        $cart = session()->get($sessionName);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put($sessionName, $cart);
            return $this->getCarts()->toArray();
        }
        return session()->get($sessionName);
    }

    public function addToSessionCart(Product|Service $product, Request $request): array
    {
        if ($request->has('quantity')) {
            $quantity = $request->quantity;
        }
        $sessionName = 'cart_' . $this->type . '_' . $this->branchId . '_' . $this->businessId;
        $cart = session()->get($sessionName);
        if (!$cart) {
            $cart = [
                $product->id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->sale_price ?? $product->price,
                ]
            ];
            session()->put($sessionName, $cart);
            return $this->getCarts()->toArray();
        }
        if (isset($cart[$product->id]) && !isset($quantity)) {
            $cart[$product->id]['quantity']++;
            session()->put($sessionName, $cart);
            return $this->getCarts()->toArray();
        } else if (isset($cart[$product->id]) && isset($quantity)) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put($sessionName, $cart);
            return $this->getCarts()->toArray();
        }
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->sale_price ?? $product->price,
        ];
        session()->put($sessionName, $cart);
        return $this->getCarts()->toArray();
    }

    public function clearSessionCart(): void
    {
        $sessionName = 'cart_' . $this->type . '_' . $this->branchId . '_' . $this->businessId;
        session()->forget($sessionName);
    }

    public function store(array $data): array
    {

        return [];
    }

    public function generateNextSellNumber($cashBoxId): string
    {
        return $this->process->NextNumberSell(null, $this->businessId, $this->branchId, $cashBoxId);
    }

    public function formatData(array $data): array
    {
        $productIds = collect($data['productId']);
        $quantities = collect($data['quantity']);
        $prices = collect($data['price']);
        $subtotals = collect($data['subtotal']);

        $data['products'] = $productIds->map(function ($item, $key) use ($quantities, $prices, $subtotals) {
            return [
                'product_id' => $item,
                'quantity' => $quantities[$key],
                'price' => $prices[$key],
                'subtotal' => $subtotals[$key],
            ];
        })->toArray();

        if ($data['payment_type'] == 5) {
            $amounts = $this->getAmounts($data);

            $data['amounts'] = $amounts->map(function ($item, $key) {
                return [
                    'payment_type_id' => $key,
                    'amount' => $item,
                ];
            })->toArray();
        }
        return $this->array_except($data, ['productId', 'quantity', 'price', 'subtotal', 'search']);
    }

    public function createPaymentAndBilling(Process $process, array $data, string $type): Billing
    {
        $amounts = $this->managementService->getAmounts($data);
        $cashRegister = $this->managementService->createPaymentToCashRegister($process, 3);
        $this->managementService->storeAmounts($amounts, $cashRegister->id);
        $this->createProcessDetails($data['products'], $process, $type);
        $billing = $this->createBilling($process, $data['client_id'], $data['documentNumber'], $data['document'], $type, $data['products']);
        //EVENT TO ELECTRONIC BILLING
        return $billing;
    }

    public function createProcessDetails(array $products, Process $process, $type): void
    {
        foreach ($products as $product) {
            DB::table('processdetails')->insert([
                'process_id' => $process->id,
                'product_id' => ($type == 'product') ? $product['product_id'] : null,
                'service_id' => ($type == 'service') ? $product['product_id'] : null,
                'amount' => $product['quantity'],
                'purchase_price' => $product['price'],
                'sale_price' => $product['subtotal'],
                'branch_id' => $this->branchId,
                'business_id' => $this->businessId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function createBilling(Process $process, int $client = null, string $number, string $documentType, string $type, array $products): Billing
    {
        $amounts = $this->billing->GetBillingAmounts($this->businessId, $this->branchId, (float) $process->amount);
        $billing = $this->billing->create([
            'date' => date('Y-m-d H:i:s'),
            'number' => $number,
            'type' => $documentType,
            'status' => 'CREADO',
            'total' => $amounts['total'],
            'igv' => $amounts['igv'],
            'subtotal' => $amounts['subtotal'],
            'client_id' => $client ?? $process->client_id,
            'process_id' => $process->id,
            'user_id' => auth()->user()->id,
            'business_id' => $this->businessId,
            'branch_id' => $this->branchId,
        ]);

        foreach ($products as $product) {
            $billing->details()->create([
                'product_id' => ($type == 'product') ? $product['product_id'] : null,
                'service_id' => ($type == 'service') ? $product['product_id'] : null,
                'amount' => $product['quantity'],
                'purchase_price' => $product['price'],
                'sale_price' => $product['subtotal'],
                'business_id' => $this->businessId,
                'branch_id' => $this->branchId,
            ]);
        }
        return $billing;
    }

    public function getAmounts(array $data): mixed
    {
        $amounts = collect([]);
        $payment_id = $data['payment_type'];
        foreach ($data as $key => $value) {
            if (strpos($key, 'amounts') !== false) {
                $id = explode('_', $key)[1];
                if (!$id) {
                    $id = $payment_id;
                }
                $amounts->put($id, $value);
            }
        }
        return $amounts;
    }

    public function array_except(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }
}