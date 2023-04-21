<?php

namespace App\Http\Services;

use App\Models\Floor;
use App\Models\Process;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CashRegisterService
{

    protected int $businessId;
    protected int $branchId;
    protected int $cashboxId;

    public function __construct(int $businessId, int $branchId, int $cashboxId)
    {
        $this->businessId = $businessId;
        $this->branchId = $branchId;
        $this->cashboxId = $cashboxId;
    }

    public function getLastMovementsIncomes(): Collection
    {
        return Process::where('business_id', $this->businessId)
            ->where('branch_id', $this->branchId)
            ->where('cashbox_id', $this->cashboxId)
            ->where('processtype_id', 2)
            ->orderBy('id', 'asc')
            ->where('id', '>=', $this->getLastOpenCashRegisterId())
            ->whereHas('concept', function ($query) {
                return $query->where('type', 'I');
            })
            ->get();
    }

    public function getLastMovementsExpenses(): Collection
    {
        return Process::where('business_id', $this->businessId)
            ->where('branch_id', $this->branchId)
            ->where('cashbox_id', $this->cashboxId)
            ->where('processtype_id', 2)
            ->orderBy('id', 'asc')
            ->where('id', '>=', $this->getLastOpenCashRegisterId())
            ->whereHas('concept', function ($query) {
                return $query->where('type', 'E');
            })
            ->get();
    }

    public function getStatus(): string
    {
        $lastProcess = Process::where('business_id', $this->businessId)
            ->where('branch_id', $this->branchId)
            ->where('cashbox_id', $this->cashboxId)
            ->where('processtype_id', 2) //MOVIMIENTOS DE CAJA
            ->orderBy('id', 'desc')
            ->first();
        if ($lastProcess) {
            $lastConcept = $lastProcess->concept_id;
            if ($lastConcept == 2) {
                return 'close';
            } else {
                return 'open';
            }
        }
        return 'close';
    }

    public function getLastOpenCashRegisterId(): int
    {
        $lastProcess = Process::where('business_id', $this->businessId)
            ->where('branch_id', $this->branchId)
            ->where('cashbox_id', $this->cashboxId)
            ->where('processtype_id', 2) //MOVIMIENTOS DE CAJA
            ->where('concept_id', 1) //APERTURA DE CAJA
            ->orderBy('id', 'desc')
            ->first();
        if ($lastProcess) {
            return $lastProcess->id;
        }
        return 0;
    }

    public function getLastCloseCashRegisterId(): int
    {
        $lastProcess = Process::where('business_id', $this->businessId)
            ->where('branch_id', $this->branchId)
            ->where('cashbox_id', $this->cashboxId)
            ->where('processtype_id', 2) //MOVIMIENTOS DE CAJA
            ->where('concept_id', 2) //CIERRE DE CAJA
            ->orderBy('id', 'desc')
            ->first();
        if ($lastProcess) {
            return $lastProcess->id;
        }
        return 0;
    }

    public function getLastProccessCashRegisterId(): int
    {
        $lastProcess = Process::where('business_id', $this->businessId)
            ->where('branch_id', $this->branchId)
            ->where('cashbox_id', $this->cashboxId)
            ->where('processtype_id', 2) //MOVIMIENTOS DE CAJA
            ->orderBy('id', 'desc')
            ->first();
        if ($lastProcess) {
            return $lastProcess->id;
        }
        return 0;
    }

    public function getCashRegisterNumber(): string
    {
        return Process::NextNumberCashRegister(null, $this->businessId, $this->branchId, $this->cashboxId);
    }

    public function storeCashRegister(Request $request): void
    {
        $process = Process::create([
            'number'            => $request->number,
            'date'              => $request->date,
            'concept_id'        => $request->concept_id,
            'amount'            => $request->amount,
            'client_id'         => $request->client_id ?? null,
            'notes'             => $request->notes,
            'cashbox_id'        => $this->cashboxId,
            'branch_id'         => $this->branchId,
            'business_id'       => $this->businessId,
            'processtype_id'    => 2,
            'status'            => 'C',
            'payment_type'      => 'E',
            'user_id'           => auth()->user()->id,
            'amoutreal'         => $request->amountreal ?? null,
        ]);
        $process->save();
        $process->payments()->attach(1, ['amount' => $request->amount]);
    }

    public function getCashAmountTotal(): float
    {
        return Process::TotalAmountCash($this->getLastOpenCashRegisterId(), $this->branchId, $this->businessId, $this->cashboxId, 'cash');
    }

    public function getTotalIncomes(): float
    {
        return Process::TotalAmountIncomes($this->getLastOpenCashRegisterId(), $this->branchId, $this->businessId, $this->cashboxId);
    }

    public function getTotalExpenses(): float
    {
        return Process::TotalAmountExpenses($this->getLastOpenCashRegisterId(), $this->branchId, $this->businessId, $this->cashboxId);
    }

    public function getTotalCards(string $subType = null): float
    {
        return Process::TotalAmountCards($this->getLastOpenCashRegisterId(), $this->branchId, $this->businessId, $this->cashboxId, 'card', $subType = null);
    }

    public function getTotalDeposits(string $type = null): float
    {
        return Process::TotalAmountDeposits($this->getLastOpenCashRegisterId(), $this->branchId, $this->businessId, $this->cashboxId, 'transfer', $type = null);
    }
}