<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuOptionRequest;
use App\Librerias\Libreria;
use App\Models\MenuGroup;
use App\Models\MenuOption;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuOptionController extends Controller
{
    use CRUDTrait;

    public function __construct()
    {
        $this->model       = new MenuOption();

        $this->entity      = 'menu_options';
        $this->folderview  = 'admin.menuoption';
        $this->adminTitle  = __('maintenance.admin.menuoption.title');
        $this->addTitle    = __('maintenance.general.add', ['entity' => $this->adminTitle]);
        $this->updateTitle = __('maintenance.general.edit', ['entity' => $this->adminTitle]);
        $this->deleteTitle = __('maintenance.general.delete', ['entity' => $this->adminTitle]);
        $this->routes = [
            'search'  => 'menuoption.search',
            'index'   => 'menuoption.index',
            'store'   => 'menuoption.store',
            'delete'  => 'menuoption.delete',
            'create'  => 'menuoption.create',
            'edit'    => 'menuoption.edit',
            'update'  => 'menuoption.update',
            'destroy' => 'menuoption.destroy',
        ];
        $this->idForm       = 'formMantenimiento' . $this->entity;
        $this->clsLibreria = new Libreria();
        $this->headers = [
            [
                'valor'  => 'Nombre',
                'numero' => '1',
            ],
            [
                'valor'  => 'Link',
                'numero' => '1',
            ],
            [
                'valor'  => 'Icono',
                'numero' => '1',
            ],
            [
                'valor'  => 'Orden',
                'numero' => '1',
            ],
            [
                'valor'  => 'Grupo de Menú',
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

            $nombre   = $this->getParam($request->nombre);
            $menugroup_id = $this->getParam($request->menugroup_id);
            $result   = $this->model::search($nombre, $menugroup_id);
            $list     = $result->get();

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
            return view($this->folderview . '.list')->with('lista', $list)->with('entidad', $this->entity);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function index()
    {
        try {
            return view($this->folderview . '.index')->with([
                'entidad'           => $this->entity,
                'titulo_admin'      => $this->adminTitle,
                'titulo_eliminar'   => $this->deleteTitle,
                'titulo_modificar'  => $this->updateTitle,
                'titulo_registrar'  => $this->addTitle,
                'ruta'              => $this->routes,
                'cboRangeFilas'     => $this->cboRangeFilas(),
                'cboMenuGroups'     => $this->generateCboGeneral(MenuGroup::class, 'name', 'id', 'Todos'),
            ]);
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function  create(Request $request)
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
                'cboMenuGroups'     => $this->generateCboGeneral(MenuGroup::class, 'name', 'id', 'Seleccione un grupo de menú'),
            ];
            return view($this->folderview . '.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger', $th);
        }
    }

    public function store(MenuOptionRequest $request)
    {
        try {

            $error = DB::transaction(function () use ($request) {
                $model = $this->model->create($request->all());
            });
            return is_null($error) ? "OK" : $error;
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function edit(Request $request, $id)
    {
        try {

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
                'cboMenuGroups'     => $this->generateCboGeneral(MenuGroup::class, 'name', 'id', 'Seleccione un grupo de menú'),
            ];

            return view($this->folderview . '.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function update(MenuOptionRequest $request, $id)
    {
        try {
            $error = DB::transaction(function () use ($request, $id) {
                $this->model->find($id)->update($request->all());
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