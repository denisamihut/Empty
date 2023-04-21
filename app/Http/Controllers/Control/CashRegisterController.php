<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashRegisterRequest;
use App\Http\Services\CashRegisterService;
use App\Librerias\Libreria;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Concept;
use App\Models\People;
use App\Models\Process;
use App\Traits\CRUDTrait;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashRegisterController extends Controller
{
    use CRUDTrait;
    protected CashRegisterService $cashRegisterService;
    protected int $businessId;
    protected int $branchId;
    protected int $cashboxId;
    protected string $newCashRegisterTitle;
    protected string $openCashRegisterTitle;
    protected string $closeCashRegisterTitle;
    protected string $editCashRegisterTitle;
    protected string $deleteCashRegisterTitle;
    protected array $titles;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->businessId = $request->session()->get('businessId');
            $this->branchId = $request->session()->get('branchId');
            $this->cashboxId = $request->session()->get('cashboxId');
            $this->cashRegisterService  = new CashRegisterService($this->businessId, $this->branchId, $this->cashboxId);
            return $next($request);
        });

        $this->model = new Process();

        $this->newCashRegisterTitle     = __('maintenance.control.new');
        $this->openCashRegisterTitle    = __('maintenance.control.open');
        $this->closeCashRegisterTitle   = __('maintenance.control.close');
        $this->editCashRegisterTitle    = __('maintenance.control.edit');
        $this->deleteCashRegisterTitle  = __('maintenance.control.delete');

        $this->titles = [
            'new'   => $this->newCashRegisterTitle,
            'open'  => $this->openCashRegisterTitle,
            'close' => $this->closeCashRegisterTitle,
            'edit'  => $this->editCashRegisterTitle,
            'delete' => $this->deleteCashRegisterTitle,
        ];

        $this->adminTitle   = __('maintenance.admin.cashregister.title');
        $this->routes = [
            'search'  => 'cashregister.search',
            'index'   => 'cashregister.index',
            'store'   => 'cashregister.store',
            'delete'  => 'cashregister.delete',
            'create'  => 'cashregister.create',
            'edit'    => 'cashregister.edit',
            'update'  => 'cashregister.update',
            'destroy' => 'cashregister.destroy',
            'maintenance' => 'cashregister.maintenance',
            'print' => 'cashregister.print',
            'details' => 'cashregister.details',
        ];
        $this->idForm       = 'formMantenimiento' . $this->entity;

        $this->clsLibreria = new Libreria();

        $this->headers = [
            [
                'valor'  => 'Fecha',
                'numero' => '1',
            ],
            [
                'valor'  => 'Número',
                'numero' => '1',
            ],
            [
                'valor'  => 'Concepto',
                'numero' => '1',
            ],
            [
                'valor'  => 'Total',
                'numero' => '1',
            ],
            [
                'valor'  => 'Cliente',
                'numero' => '1',
            ],
            [
                'valor'  => 'Observación',
                'numero' => '1',
            ],
            // [
            //     'valor'  => 'Acciones',
            //     'numero' => '1',
            // ],
        ];
    }

    public function search(Request $request)
    {
        try {
            $paginas = $request->page;
            $filas = $request->filas;
            $name = $this->getParam($request->name);
            $businessId  = $this->getParam($request->businessId);
            $branchId = $this->getParam($request->branch_id);
            $processTypeId = 2; //ID MOVIMIENTO DE CAJA
            $lastOpenCashRegister = $this->cashRegisterService->getLastOpenCashRegisterId();
            $lastCloseCashRegister = $this->cashRegisterService->getLastCloseCashRegisterId();
            $lastCashRegisterId = $this->cashRegisterService->getLastProccessCashRegisterId();
            $result = $this->model::search($name, $branchId, $businessId, null, $this->cashboxId, $processTypeId, $lastOpenCashRegister, null);
            $list   = $result->get();
            $resumeData = [
                'incomes' => $this->cashRegisterService->getTotalIncomes(),
                'expenses' => $this->cashRegisterService->getTotalExpenses(),
                'cash' => $this->cashRegisterService->getCashAmountTotal(),
                'cards' => $this->cashRegisterService->getTotalCards(),
                'deposits' => $this->cashRegisterService->getTotalDeposits(),
            ];
            if (count($list) > 0) {
                $paramPaginacion = $this->clsLibreria->generarPaginacion($list, $paginas, $filas, $this->entity);
                $list = $result->paginate($filas);
                $request->replace(array('page' => $paramPaginacion['nuevapagina']));
                return view('control.cashregister.list')->with([
                    'lista'             => $list,
                    'cabecera'          => $this->headers,
                    'titulo_admin'      => $this->adminTitle,
                    'titulo_eliminar'   => $this->deleteTitle,
                    'titulo_modificar'  => $this->updateTitle,
                    'paginacion'        => $paramPaginacion['cadenapaginacion'],
                    'inicio'            => $paramPaginacion['inicio'],
                    'fin'               => $paramPaginacion['fin'],
                    'ruta'              => $this->routes,
                    'entidad'           => $this->entity,
                    'titles'            => $this->titles,
                    'status'            => $this->cashRegisterService->getStatus(),
                    'resumeData'        => $resumeData,
                ]);
            }
            return view('control.cashregister.list')->with('lista', $list)->with([
                'entidad'           => $this->entity,
                'resumeData'        => $resumeData,
                'ruta'              => $this->routes,
                'status'            => $this->cashRegisterService->getStatus(),
                'titles'            => $this->titles,
            ]);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function index()
    {
        try {
            return view('control.cashregister.index')->with([
                'entidad'           => $this->entity,
                'titulo_admin'      => $this->adminTitle,
                'titulo_eliminar'   => $this->deleteTitle,
                'titulo_modificar'  => $this->updateTitle,
                'titulo_registrar'  => $this->addTitle,
                'ruta'              => $this->routes,
                'titles'            => $this->titles,
                'cboRangeFilas'     => $this->cboRangeFilas(),
                'status'            => $this->cashRegisterService->getStatus(),
                'cboTypes'          => ['' => 'Todos', 'I' => 'Ingreso', 'E' => 'Egreso'],
            ]);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function create(Request $request)
    {
        try {
            $formData = [
                'route'             => $this->routes['store'],
                'method'            => 'POST',
                'class'             => 'flex flex-col space-y-3 py-2',
                'id'                => $this->idForm,
                'autocomplete'      => 'off',
                'entidad'           => $this->entity,
                'listar'            => $this->getParam($request->input('listagain'), 'NO'),
                'boton'             => 'Registrar',
                'cboConcepts'       => $this->generateCboGeneral(Concept::class, 'name', 'id', 'Seleccione una opción'),
                'cboClients'        => $this->generateCboGeneral(People::class, 'name', 'id', 'Seleccione una opción'),
                'number'            => $this->cashRegisterService->getCashRegisterNumber(),
                'today'             => date('Y-m-d'),
            ];
            return view('control.cashregister.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function store(CashRegisterRequest $request)
    {
        try {
            $error = DB::transaction(function () use ($request) {
                $this->cashRegisterService->storeCashRegister($request);
            });
            return is_null($error) ? "OK" : $error;
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $businessId = $request->params['businessId'];
            $exist = $this->verificarExistencia($id, $this->entity);
            if ($exist !== true) {
                return $exist;
            }
            $formData = [
                'route'             => array($this->routes['update'], $id),
                'method'            => 'PUT',
                'class'             => 'form-horizontal',
                'id'                => $this->idForm,
                'autocomplete'      => 'off',
                'model'             => $this->model->find($id),
                'listar'            => $this->getParam($request->input('listar'), 'NO'),
                'boton'             => 'Modificar',
                'entidad'           => $this->entity,
                'cboBranches'       => Branch::where('business_id', $businessId)->get()->pluck('name', 'id')->all(),
                'businessId'        => $businessId,
            ];
            return view($this->folderview . '.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $error = DB::transaction(function () use ($request, $id) {
                $user = $this->model->find($id);
                $user->update($request->all());
            });
            return is_null($error) ? "OK" : $error;
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function delete($id, $listagain)
    {
        try {
            $exist = $this->verificarExistencia($id, $this->entity);
            if ($exist !== true) {
                return $exist;
            }
            $listar = 'NO';
            if (!is_null($this->getParam($listagain))) {
                $listar = $listagain;
            }
            $formData = [
                'route'         => array($this->routes['destroy'], $this->model->find($id)),
                'method'        => 'DELETE',
                'class'         => 'form-horizontal',
                'id'            => $this->idForm,
                'autocomplete'  => 'off',
                'boton'         => 'Eliminar',
                'entidad'       => $this->entity,
                'listar'        => $listar,
                'modelo'        => $this->model->find($id),
            ];
            return view('utils.comfirndelete')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function maintenance(Request $request)
    {
        try {
            $action = $request->action;
            $listar = 'SI';
            $formData = [
                'route'         => $this->routes['store'],
                'method'        => 'POST',
                'class'         => 'form-horizontal',
                'id'            => $this->idForm,
                'autocomplete'  => 'off',
                'boton'         => 'Guardar',
                'entidad'       => $this->entity,
                'listar'        => $listar,
                'model'         => null,
                'action'        => $action,
                'number'        => $this->cashRegisterService->getCashRegisterNumber(),
                'today'         => date('Y-m-d'),
                'amountreal'    => $this->cashRegisterService->getCashAmountTotal(),
            ];
            if ($action == 'OPEN') {
                return view('control.cashregister.open')->with(compact('formData'));
            }
            return view('control.cashregister.close')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function destroy($id)
    {
        try {
            $error = DB::transaction(function () use ($id) {
                $this->model->find($id)->delete();
            });
            return is_null($error) ? "OK" : $error;
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function print(Request $request)
    {
        $type = $request->type;
        $view = $type == 'A4' ? 'control.cashregister.print.a4' : 'control.cashregister.print.ticket';
        $data = [
            'business' => Business::find($this->businessId),
            'date' => date('Y-m-d H:i:s'),
            'user' => auth()->user(),
            'incomes' => $this->cashRegisterService->getLastMovementsIncomes(),
            'expenses' => $this->cashRegisterService->getLastMovementsExpenses(),
            'cash' => $this->cashRegisterService->getCashAmountTotal(),
            'cards' => $this->cashRegisterService->getTotalCards(),
            'deposits' => $this->cashRegisterService->getTotalDeposits(),
        ];
        $pdf = \PDF::loadView($view, ['data' => $data]);
        $type == 'A4' ? $pdf->setPaper('A4', 'portrait') : $pdf->setPaper([0, 0, 567.00, 283.80], 'landscape');
        return $pdf->stream();
    }

    public function details(Request $request)
    {
        $type = $request->type;
        dd('TO DO');
        switch ($type) {
            case 'expenses':
                # code...
                break;
            case 'incomes':
                # code...
                break;
            case 'cash':
                # code...
                break;
            case 'cards':
                # code...
                break;
            case 'deposits':
                # code...
                break;

            default:
                # code...
                break;
        }
    }
}