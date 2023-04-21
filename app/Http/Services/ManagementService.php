<?php

namespace App\Http\Services;

use App\Events\BillingEvents;
use App\Models\Billing;
use App\Models\Floor;
use App\Models\Payments;
use App\Models\Process;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagementService
{

    protected int $businessId;
    protected int $branchId;
    protected Process $process;
    protected Billing $billing;

    public function __construct(int $businessId, int $branchId)
    {
        $this->businessId = $businessId;
        $this->branchId = $branchId;

        $this->process = new Process();
        $this->billing = new Billing();
    }

    public function getFloorsWithRooms(int $id = null)
    {
        $floors = Floor::with('rooms')
            ->where('business_id', $this->businessId)->where('branch_id', $this->branchId)->orderBy('id', 'asc')->get();
        $data = collect();
        foreach ($floors as $floor) {
            $data->push([
                'id' => $floor->id,
                'name' => $floor->name,
                'rooms' => $floor->rooms,
                'status' => $id && $id == $floor->id ? 'open' : (!$id && $floor->id == $floors->first()->id ? 'open' : 'close'),
            ]);
        }

        return collect($data);
    }

    public function generateCheckInNumber(): string
    {
        return Process::NextNumberCheckIn(null, $this->businessId, $this->branchId);
    }

    public function generateDocumentNumber(string $type): string
    {
        return Billing::NextNumberDocument($type, $this->getSerie(), $this->businessId, $this->branchId);
    }

    public function getSerie(): string
    {
        return Setting::where('business_id', $this->businessId)->where('branch_id', $this->branchId)->first()->serie;
    }

    public function getLastProcessInRoom(int $roomId): int
    {
        return Process::where('room_id', $roomId)->where('business_id', $this->businessId)->where('branch_id', $this->branchId)->orderBy('id', 'desc')->first()->id;
    }

    public function createPaymentsAndBilling(Process $process, Request $request): Billing
    {
        $amounts = $this->getAmounts($request->all());
        $cashregister = $this->createPaymentToCashRegister($process, 4);
        $this->storeAmounts($amounts, $cashregister->id);
        $billing = $this->createBilling($process, $request->clientBilling, $request->documentNumber, $request->document);
        return $billing;
    }

    public function storeAmounts(mixed $amounts, int $processId): void
    {
        foreach ($amounts as $key => $amount) {
            if ($key != 0) {
                DB::table('paymentprocesses')->insert([
                    'process_id' => $processId,
                    'payment_id' => $key,
                    'amount' => $amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function getAmounts(array $data): mixed
    {
        $amounts = collect([]);
        $payment_id = $data['payment_type_id'];
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

    public function createPaymentToCashRegister(Process $process, int $conceptId): Process
    {
        return $process = $this->process->create([
            'date' => date('Y-m-d'),
            'number' => $this->getCashRegisterNumber($process->cashbox_id),
            'processtype_id' => 2,
            'status' => 'C',
            'amount' => $process->amount,
            'payment_type' => $process->payment_type,
            'client_id' => $process->client_id,
            'user_id' => $process->user_id,
            'business_id' => $process->business_id,
            'branch_id' => $process->branch_id,
            'cashbox_id' => $process->cashbox_id,
            'concept_id' => $conceptId,
        ]);
    }

    public function getCashRegisterNumber(int $cashBoxId): string
    {
        return $this->process->NextNumberCashRegister(null, $this->businessId, $this->branchId, $cashBoxId);
    }

    public function createBilling(Process $process, int $client = null, string $number, string $type): Billing
    {
        $amounts = $this->billing->GetBillingAmounts($this->businessId, $this->branchId, (float) $process->amount);
        $billing = $this->billing->create([
            'date' => date('Y-m-d H:i:s'),
            'number' => $number,
            'type' => $type,
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

        $billing->details()->create([
            'process_id' => $process->id,
            'billing_id' => $billing->id,
            'notes' => 'Servicio de Alquiler de ' .  $process->room->roomType->name,
            'amount' => 1,
            'sale_price' => $process->amount,
            'purchase_price' => $process->amount,
            'total' => $process->amount,
            'business_id' => $this->businessId,
            'branch_id' => $this->branchId,
        ]);

        return $billing;
    }
}