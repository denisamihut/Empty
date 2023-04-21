<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\LogoRequest;
use App\Http\Services\BusinessService;
use App\Librerias\Libreria;
use App\Models\Branch;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    use CRUDTrait;

    private BusinessService $businessService;

    private string $usersTitle;
    private string $settingsTitle;

    public function __construct()
    {
        $this->model            = new Branch();
        $this->businessService  = new BusinessService();

        $this->entity       = 'branches';
        $this->folderview   = 'admin.branch';
        $this->adminTitle   = __('maintenance.admin.branch.title');
        $this->addTitle     = __('maintenance.general.add', ['entity' => $this->adminTitle]);
        $this->updateTitle  = __('maintenance.general.edit', ['entity' => $this->adminTitle]);
        $this->deleteTitle  = __('maintenance.general.delete', ['entity' => $this->adminTitle]);
        $this->usersTitle   = __('maintenance.admin.business.branches');
        $this->settingsTitle = __('maintenance.admin.business.settings');
        $this->routes = [
            'search'  => 'branch.search',
            'index'   => 'branch.index',
            'store'   => 'branch.store',
            'delete'  => 'branch.delete',
            'create'  => 'branch.create',
            'edit'    => 'branch.edit',
            'update'  => 'branch.update',
            'destroy' => 'branch.destroy',
            'maintenance' => 'branch.maintenance',
            'back'    => 'business',
            'uploadPhoto' => 'branch.uploadPhoto',
        ];
        $this->idForm       = 'formMantenimiento' . $this->entity;

        $this->clsLibreria = new Libreria();

        $this->headers = [
            [
                'valor'  => 'Nombre',
                'numero' => '1',
            ],
            [
                'valor'  => 'Estado',
                'numero' => '1',
            ],
            [
                'valor'  => 'Email/Teléfono',
                'numero' => '1',
            ],
            [
                'valor'  => 'Dirección',
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

            $result = $this->model::search($nombre, $businessId);
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
                    'usersTitle'        => $this->usersTitle,
                    'settingsTitle'     => $this->settingsTitle,
                ]);
            }
            return view($this->folderview . '.list')->with('lista', $list)->with([
                'entidad'           => $this->entity,
                'usersTitle'        => $this->usersTitle,
                'settingsTitle'     => $this->settingsTitle,
            ]);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function index(int $businessId = null)
    {
        try {
            $bussines = $this->businessService->getBusinessById($businessId);
            return view($this->folderview . '.index')->with([
                'entidad'           => $this->entity,
                'titulo_admin'      => $this->adminTitle . ' de ' . $bussines->name,
                'titulo_eliminar'   => $this->deleteTitle,
                'titulo_modificar'  => $this->updateTitle,
                'titulo_registrar'  => $this->addTitle,
                'ruta'              => $this->routes,
                'cboRangeFilas'     => $this->cboRangeFilas(),
                'businessId'        => $businessId,
            ]);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function create(Request $request)
    {
        try {
            $businessId = $request->params['businessId'];
            $formData = [
                'route'             => $this->routes['store'],
                'method'            => 'POST',
                'class'             => 'flex flex-col space-y-3 py-2',
                'id'                => $this->idForm,
                'autocomplete'      => 'off',
                'entidad'           => $this->entity,
                'listar'            => $this->getParam($request->input('listagain'), 'NO'),
                'boton'             => 'Registrar',
                'cboStatus'         => ['A' => 'Activo', 'I' => 'Inactivo'],
                'businessId'        => $businessId,
            ];
            return view($this->folderview . '.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function store(BranchRequest $request)
    {
        try {
            $error = DB::transaction(function () use ($request) {
                $branch = $this->model::create($request->all());
                $this->model->cashboxes()->insert([
                    'branch_id' => $branch->id,
                    'name' => 'Caja Principal',
                    'phone' => $branch->phone,
                    'business_id' => $branch->business_id,
                ]);
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
                'cboStatus'         => ['A' => 'Activo', 'I' => 'Inactivo'],
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
                switch ($request->action) {
                    case 'SETTINGS':
                        $this->businessService->storeOrUpdateBussinessSettings($request, $id);
                        break;
                    case 'IS_MAIN':
                        $this->businessService->setMainBusinessBranch($request);
                        break;
                    default:
                        $this->model->find($id)->update($request->all());
                        break;
                }
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

    public function maintenance($id, $action, $businessId)
    {
        try {
            $listar = 'SI';
            $formData = [
                'route'         => array($this->routes['update'], $this->model->find($id)),
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
                'branchId'      => $id,
            ];
            switch ($action) {
                case 'LIST':
                    return $this->index($id);
                    break;
                case 'SETTINGS':
                    $formData['model'] = $this->model->find($id)->settings;
                    return view($this->folderview . '.settings')->with(compact('formData'));
                    break;
                case 'PROFILEPHOTO':
                    $formData['model'] = $this->model->find($id)->settings;
                    $formData['route'] = $this->routes['uploadPhoto'];
                    $formData['method'] = 'POST';
                    return view($this->folderview . '.uploadPhoto')->with(compact('formData'));
                    break;
                case 'IS_MAIN':
                    $formData['model'] = $this->model->find($id);
                    return view($this->folderview . '.ismain')->with(compact('formData'));
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
            if ($this->model->find($id)->is_main) {
                return $this->MessageResponse('No se puede eliminar la sucursal principal', 'danger');
            }
            $error = DB::transaction(function () use ($id) {
                $this->model->find($id)->delete();
            });
            return is_null($error) ? "OK" : $error;
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function uploadPhoto(LogoRequest $request)
    {
        try {
            $error = DB::transaction(function () use ($request) {
                $this->businessService->storeOrUpdateBranchProfilePhoto($request);
            });
            return is_null($error) ? "OK" : $error;
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }
}