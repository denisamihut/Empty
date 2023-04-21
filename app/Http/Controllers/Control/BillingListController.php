<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Http\Services\BusinessService;
use App\Librerias\Libreria;
use App\Models\Billing;
use App\Models\Branch;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class BillingListController extends Controller
{
    use CRUDTrait;

    protected int $businessId;
    protected int $branchId;
    private BusinessService $businessService;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->businessId = session()->get('businessId');
            $this->branchId = session()->get('branchId');
            return $next($request);
        });

        $this->businessService  = new BusinessService();

        $this->model        = new Billing();
        $this->entity       = 'billings';
        $this->folderview   = 'control.billinglist';
        $this->adminTitle   = __('maintenance.control.billinglist.title');
        $this->routes = [
            'search'  => 'billinglist.search',
            'index'   => 'billinglist.index',
            'print'   => 'billinglist.print',
        ];
        $this->idForm       = 'formMantenimiento' . $this->entity;

        $this->clsLibreria = new Libreria();

        $this->headers = [
            [
                'valor'  => 'Fecha',
                'numero' => '1',
            ],
            [
                'valor'  => 'Tipo',
                'numero' => '1',
            ],
            [
                'valor'  => 'Numeración',
                'numero' => '1',
            ],
            [
                'valor'  => 'Estado',
                'numero' => '1',
            ],
            [
                'valor'  => 'Cliente',
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
            $businessId  = $this->businessId;
            $branchId    = $this->branchId;
            $type        = $this->getParam($request->type);
            $star_date   = $this->getParam($request->star_date);
            $end_date    = $this->getParam($request->end_date);

            $result = $this->model::search($nombre, $type, $star_date, $end_date, $businessId, $branchId);
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

    public function index()
    {
        try {
            $bussines = $this->businessService->getBusinessById($this->businessId);
            return view($this->folderview . '.index')->with([
                'entidad'           => $this->entity,
                'titulo_admin'      => $this->adminTitle . ' de ' . $bussines->name,
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

    public function print(Request $request)
    {
        $billing = $this->model::with('details')->find($request->id);
        $type = $request->type;
        $view = $type == 'A4' ? 'control.billinglist.print.a4' : 'control.billinglist.print.ticket';
        $branch = Branch::find($billing->branch_id);
        $data = [
            'billing' => $billing,
            'details' => $billing->details,
            'type'   => $billing->type,
            'business' => $branch->business,
            'settings' => $branch->settings,
        ];
        $pdf = \PDF::loadView($view, ['data' => $data]);
        $type == 'A4' ? $pdf->setPaper('A4', 'portrait') : $pdf->setPaper([0, 0, 567.00, 283.80], 'landscape');
        return $pdf->stream();
    }
}