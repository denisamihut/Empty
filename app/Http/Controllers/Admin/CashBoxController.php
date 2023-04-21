<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashBoxRequest;
use App\Http\Services\BusinessService;
use App\Librerias\Libreria;
use App\Models\Branch;
use App\Models\CashBox;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashBoxController extends Controller
{
    use CRUDTrait;

    private BusinessService $businessService;

    private string $usersTitle;
    private string $settingsTitle;

    public function __construct()
    {
        $this->model            = new CashBox();
        $this->businessService  = new BusinessService();

        $this->entity       = 'cashboxes';
        $this->folderview   = 'admin.cashbox';
        $this->adminTitle   = __('maintenance.admin.cashbox.title');
        $this->addTitle     = __('maintenance.general.add', ['entity' => $this->adminTitle]);
        $this->updateTitle  = __('maintenance.general.edit', ['entity' => $this->adminTitle]);
        $this->deleteTitle  = __('maintenance.general.delete', ['entity' => $this->adminTitle]);
        $this->routes = [
            'search'  => 'cashbox.search',
            'index'   => 'cashbox.index',
            'store'   => 'cashbox.store',
            'delete'  => 'cashbox.delete',
            'create'  => 'cashbox.create',
            'edit'    => 'cashbox.edit',
            'update'  => 'cashbox.update',
            'destroy' => 'cashbox.destroy',
            'maintenance' => 'cashbox.maintenance',
            'back'    => 'business',
            'uploadPhoto' => 'cashbox.uploadPhoto',
        ];
        $this->idForm       = 'formMantenimiento' . $this->entity;

        $this->clsLibreria = new Libreria();

        $this->headers = [
            [
                'valor'  => 'Nombre',
                'numero' => '1',
            ],
            [
                'valor'  => 'Teléfono',
                'numero' => '1',
            ],
            [
                'valor'  => 'Observación',
                'numero' => '1',
            ],
            [
                'valor'  => 'Sucursal',
                'numero' => '1',
            ],
            [
                'valor'  => 'Acciones',
                'numero' => '1',
            ],
        ];
    }

    public function search(Request $request)
    {
        try {
            $paginas = $request->page;
            $filas = $request->filas;
            $nombre      = $this->getParam($request->nombre);
            $businessId  = $this->getParam($request->businessId);
            $branchId = $this->getParam($request->branch_id);
            if ($branchId == null && auth()->user()->usertype_id != 1) {
                $branchId = auth()->user()->branch_id;
            }

            $result = $this->model::search($nombre, $branchId, $businessId);
            $list   = $result->get();
            if (count($list) > 0) {
                $paramPaginacion = $this->clsLibreria->generarPaginacion($list, $paginas, $filas, $this->entity);
                $list = $result->paginate($filas);
                $request->replace(array('page' => $paramPaginacion['nuevapagina']));
                return view($this->folderview . '.list')->with([
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
                ]);
            }
            return view($this->folderview . '.list')->with('lista', $list)->with([
                'entidad'           => $this->entity,
            ]);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function index(int $businessId = null)
    {
        try {
            $id = $businessId ? $businessId : auth()->user()->business_id;
            $bussines = $this->businessService->getBusinessById($id);
            return view($this->folderview . '.index')->with([
                'entidad'           => $this->entity,
                'titulo_admin'      => $this->adminTitle . ' de ' . $bussines->name,
                'titulo_eliminar'   => $this->deleteTitle,
                'titulo_modificar'  => $this->updateTitle,
                'titulo_registrar'  => $this->addTitle,
                'ruta'              => $this->routes,
                'cboRangeFilas'     => $this->cboRangeFilas(),
                'businessId'        => $businessId,
                'showBackBtn'       => $businessId ? true : false,
            ]);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function create(Request $request)
    {
        try {
            $businessId = $request->businessId ?? auth()->user()->business_id;
            $formData = [
                'route'             => $this->routes['store'],
                'method'            => 'POST',
                'class'             => 'flex flex-col space-y-3 py-2',
                'id'                => $this->idForm,
                'autocomplete'      => 'off',
                'entidad'           => $this->entity,
                'listar'            => $this->getParam($request->input('listagain'), 'NO'),
                'boton'             => 'Registrar',
                'cboBranches'       => Branch::where('business_id', $businessId)->get()->pluck('name', 'id')->all(),
                'businessId'        => $businessId,
            ];
            return view($this->folderview . '.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function store(CashBoxRequest $request)
    {
        try {
            $error = DB::transaction(function () use ($request) {
                $this->model::create($request->all());
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

    public function update(CashBoxRequest $request, $id)
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

    public function maintenance($action, $businessId, $userId = null)
    {
        try {
            $listar = 'SI';
            $formData = [
                'route'         => array($this->routes['update'], $this->model->find($businessId)),
                'method'        => 'PUT',
                'class'         => 'form-horizontal',
                'id'            => $this->idForm,
                'autocomplete'  => 'off',
                'boton'         => 'Guardar',
                'entidad'       => $this->entity,
                'listar'        => $listar,
                'model'         => $this->model,
                'action'        => $action,
                'businessId'    => $businessId,
            ];
            switch ($action) {
                case 'LIST':
                    return $this->index($businessId);
                    break;
                default:
                    return view('utils.comfirndelete')->with(compact('formData'));
                    break;
            }
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
}