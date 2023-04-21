<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementRequest;
use App\Http\Requests\UpdateManagementRequest;
use App\Http\Services\CashRegisterService;
use App\Http\Services\ManagementService;
use App\Librerias\Libreria;
use App\Models\Payments;
use App\Models\People;
use App\Models\Process;
use App\Models\Room;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ManagementController extends Controller
{
    use CRUDTrait;

    protected ManagementService $service;
    protected CashRegisterService $cashRegisterService;
    protected int $businessId;
    protected int $branchId;
    protected int $cashboxId;
    protected string $folderView;

    public function __construct()
    {
        $this->model = new Process();
        $this->middleware(function ($request, $next) {
            $this->businessId = session()->get('businessId');
            $this->branchId = session()->get('branchId');
            $this->cashboxId = $request->session()->get('cashboxId');
            $this->service = new ManagementService($this->businessId, $this->branchId);
            $this->cashRegisterService = new CashRegisterService($this->businessId, $this->branchId, $this->cashboxId);
            return $next($request);
        });
        $this->folderView = 'control.management.';
        $this->entity = 'rooms';
        $this->routes = [
            'create' => 'management.create',
            'store' => 'management.store',
            'edit' => 'management.edit',
            'update' => 'management.update',
            'destroy' => 'management.destroy',
            'client' => 'people.createFast',
            'back' => 'management',
            'documentType' => 'management.documentNumber',
            'checkout' => 'management.checkout',
            'print'   => 'billinglist.print',
        ];
        $this->idForm = 'formMantenimiento' . $this->entity;
    }

    public function index(Request $request)
    {
        return view($this->folderView . 'index', with([
            'floors' => $this->service->getFloorsWithRooms($request->id),
            'entidad' => $this->entity,
            'id' => $request->id,
            'routes' => $this->routes,
        ]));
    }

    public function update(UpdateManagementRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $process = Process::find($id);
            $billing = null;
            if ($process->status == config('constants.processStatus.PyNC')) {
                $billing = $this->service->createPaymentsAndBilling($process, $request);
            }
            $process->update([
                'notes' => $request->notes,
                'status' => 'C',
            ]);
            $process->room->update(['status' => 'D']);
            DB::commit();
            return response()->json([
                'success' => true,
                'routes' => URL::route($this->routes['back']),
                'url' => isset($billing) ? URL::route($this->routes['print'], ['type' => 'TICKET', 'id' => $billing->id]) : null,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            app('log')->error($th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al crear el registro',
                'room' => $request->room_id,
                'routes' => URL::route($this->routes['back']),
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $process = $this->model->find($request->managementId);
        $room = Room::findOrFail($request->roomId);
        $formData = [
            'route'             => array($this->routes['update'], $request->managementId),
            'method'            => 'PUT',
            'class'             => 'flex flex-col space-y-3 py-2',
            'id'                => $this->idForm,
            'autocomplete'      => 'off',
            'entidad'           => $this->entity,
            'listar'            => $this->getParam($request->input('listagain'), 'NO'),
            'boton'             => 'Registrar',
            'today'             => date('Y-m-d'),
            'number'            => $this->service->generateCheckInNumber(),
        ];
        return view($this->folderView . 'checkout', with([
            'model'             => $process,
            'entidad'           => $this->entity,
            'id'                => $request->managementId,
            'routes'            => $this->routes,
            'cboPeople'         => ['' => 'Seleccione una opción'] + People::PeopleClient()->pluck('name', 'id')->all(),
            'cboCompanies'      => ['' => 'Seleccione una opción'] + People::Companies()->pluck('social_reason', 'id')->all(),
            'cboClients'        => ['' => 'Seleccione una opción'] + People::Companies()->pluck('social_reason', 'id')->all() + People::PeopleClient()->pluck('name', 'id')->all(),
            'formData'          => $formData,
            'room'              => $room,
            'cboPaymentTypes'   => $this->generateCboGeneral(Payments::class, 'name', 'id', 'Seleccione una opción'),
            'cboDocumentTypes'  => ['' => 'Seleccione una opción'] + ['BOLETA' => 'BOLETA', 'FACTURA' => 'FACTURA', 'TICKET' => 'TICKET'],
            'status'            => $process->status,
        ]));
    }

    public function create(Request $request)
    {
        $status = $this->cashRegisterService->getStatus();
        if ($status == 'close') {
            return redirect()->route($this->routes['back'])->withErrors(['error' => 'La caja se encuentra cerrada']);
        }
        if ($request->status == 'Ocupado' || $request->status == 'Mantenimiento') {
            $lastProcessInRommId = $this->service->getLastProcessInRoom($request->id);
            return redirect()->route($this->routes['checkout'], ['managementId' => $lastProcessInRommId, 'roomId' => $request->id]);
        }
        $room = Room::findOrFail($request->id);
        $formData = [
            'route'             => $this->routes['store'],
            'method'            => 'POST',
            'class'             => 'flex flex-col space-y-3 py-2',
            'id'                => $this->idForm,
            'autocomplete'      => 'off',
            'entidad'           => $this->entity,
            'listar'            => $this->getParam($request->input('listagain'), 'NO'),
            'boton'             => 'Registrar',
            'model'             => null,
            'today'             => date('Y-m-d'),
            'number'            => $this->service->generateCheckInNumber(),
        ];
        return view($this->folderView . 'create', with([
            'entidad' => $this->entity,
            'id' => $request->id,
            'routes' => $this->routes,
            'cboPeople' => ['' => 'Seleccione una opción'] + People::PeopleClient()->pluck('name', 'id')->all(),
            'cboCompanies' => ['' => 'Seleccione una opción'] + People::Companies()->pluck('social_reason', 'id')->all(),
            'cboClients' => ['' => 'Seleccione una opción'] + People::Companies()->pluck('social_reason', 'id')->all() + People::PeopleClient()->pluck('name', 'id')->all(),
            'formData' => $formData,
            'room' => $room,
            'cboPaymentTypes' => $this->generateCboGeneral(Payments::class, 'name', 'id', 'Seleccione una opción'),
            'cboDocumentTypes' => ['' => 'Seleccione una opción'] + ['BOLETA' => 'BOLETA', 'FACTURA' => 'FACTURA', 'TICKET' => 'TICKET'],
            'status' => $request->status,
        ]));
    }

    public function store(ManagementRequest $request)
    {
        try {
            DB::beginTransaction();
            $process = Process::create($request->all());
            $billing = null;
            if ($request->billingToggle == 'on') {
                $billing = $this->service->createPaymentsAndBilling($process, $request);
            }
            $process->room->update(['status' => 'O']);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Registro creado correctamente',
                'room' => $request->room_id,
                'routes' => URL::route($this->routes['create'], ['status' => 'Ocupado', 'id' => $request->room_id]),
                'url' => isset($billing) ? URL::route($this->routes['print'], ['type' => 'TICKET', 'id' => $billing->id]) : null,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al crear el registro',
                'room' => $request->room_id,
                'routes' => URL::route($this->routes['back']),
            ]);
        }
    }

    public function documentNumber(Request $request)
    {
        $documentNumber = $this->service->generateDocumentNumber($request->type);
        if ($request->type == 'FACTURA') {
            $cboClients = ['' => 'Seleccione una opción'] + People::Companies()->pluck('social_reason', 'id')->all();
        } else {
            $cboClients = ['' => 'Seleccione una opción'] + People::Companies()->pluck('social_reason', 'id')->all() + People::PeopleClient()->pluck('name', 'id')->all();
        }
        return response()->json(['documentNumber' => $documentNumber, 'cboClients' => $cboClients]);
    }
}