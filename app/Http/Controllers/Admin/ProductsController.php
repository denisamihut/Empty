<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Librerias\Libreria;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    use CRUDTrait;

    public function __construct()
    {
        $this->model       = new Product();

        $this->entity      = 'products';
        $this->folderview  = 'admin.product';
        $this->adminTitle  = __('maintenance.admin.product.title');
        $this->addTitle    = __('maintenance.general.add', ['entity' => $this->adminTitle]);
        $this->updateTitle = __('maintenance.general.edit', ['entity' => $this->adminTitle]);
        $this->deleteTitle = __('maintenance.general.delete', ['entity' => $this->adminTitle]);
        $this->routes = [
            'search'  => 'product.search',
            'index'   => 'product.index',
            'store'   => 'product.store',
            'delete'  => 'product.delete',
            'create'  => 'product.create',
            'edit'    => 'product.edit',
            'update'  => 'product.update',
            'destroy' => 'product.destroy',
        ];
        $this->idForm       = 'formMantenimiento' . $this->entity;
        $this->clsLibreria = new Libreria();
        $this->headers = [
            [
                'valor'  => 'Nombre',
                'numero' => '1',
            ],
            [
                'valor'  => 'Precio de venta',
                'numero' => '1',
            ],
            [
                'valor'  => 'Precio de compra',
                'numero' => '1',
            ],
            [
                'valor'  => 'Unidades',
                'numero' => '1',
            ],
            [
                'valor'  => 'Categoría',
                'numero' => '1',
            ],
            [
                'valor'  => 'Sucursal',
                'numero' => '1',
            ],
            [
                'valor'  => 'Empresa',
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
            $businessId = auth()->user()->business_id;
            $branchId = $this->getParam($request->branch_id);
            if ($branchId == null && auth()->user()->usertype_id != 1) {
                $branchId = auth()->user()->branch_id;
            }
            $result   = $this->model::search($nombre, $branchId, $businessId);
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
                'cboBranch'         => $this->generateCboGeneral(Branch::class, 'name', 'id', 'Seleccione una sucursal'),
                'cboCategory'       => $this->generateCboGeneral(Category::class, 'name', 'id', 'Seleccione una categoría'),
                'cboUnit'           => $this->generateCboGeneral(Unit::class, 'name', 'id', 'Seleccione una unidad'),
            ];
            return view($this->folderview . '.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger', $th);
        }
    }

    public function store(ProductRequest $request)
    {
        try {

            $error = DB::transaction(function () use ($request) {
                $model = $this->model->create([
                    'name'          => $this->getParam($request->input('name')),
                    'sale_price'    => $this->getParam($request->input('sale_price')),
                    'purchase_price' => $this->getParam($request->input('purchase_price')),
                    'unit_id'       => $this->getParam($request->input('unit_id')),
                    'category_id'   => $this->getParam($request->input('category_id')),
                    'branch_id'     => $this->getParam($request->input('branch_id')),
                    'business_id'   => auth()->user()->business_id,
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
                'cboBranch'         => $this->generateCboGeneral(Branch::class, 'name', 'id', 'Seleccione una sucursal'),
                'cboCategory'       => $this->generateCboGeneral(Category::class, 'name', 'id', 'Seleccione una categoría'),
                'cboUnit'           => $this->generateCboGeneral(Unit::class, 'name', 'id', 'Seleccione una unidad'),
            ];

            return view($this->folderview . '.create')->with(compact('formData'));
        } catch (\Throwable $th) {
            return $this->MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $error = DB::transaction(function () use ($request, $id) {
                $this->model->find($id)->update([
                    'name'          => $this->getParam($request->input('name')),
                    'sale_price'    => $this->getParam($request->input('sale_price')),
                    'purchase_price' => $this->getParam($request->input('purchase_price')),
                    'unit_id'       => $this->getParam($request->input('unit_id')),
                    'category_id'   => $this->getParam($request->input('category_id')),
                    'branch_id'     => $this->getParam($request->input('branch_id')),
                    'business_id'   => auth()->user()->business_id,
                ]);
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