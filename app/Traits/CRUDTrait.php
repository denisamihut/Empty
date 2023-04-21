<?php

namespace App\Traits;

use App\Librerias\Libreria;
use Validator;


trait CRUDTrait
{
    private $folderview;
    private $adminTitle;
    private $addTitle;
    private $updateTitle;
    private $deleteTitle;
    private $routes;
    private $headers;
    private $entity;
    private $clsLibreria;
    private $idForm;
    private $autocomplete;
    private $model;
    protected array $paginateData;


    public function MessageResponse($message, $class): String
    {
        if ($class == 'error' || $class == 'danger') {
            app('log')->error($message);
        }
        return json_encode([
            'message' => [$message],
        ]);
    }

    public function verifyRegister($id, $entity)
    {
        $existe = Libreria::verificarExistencia($id, $entity);
        if ($existe !== true) {
            return $existe;
        }
    }

    public function setPaginateData(array $paramPaginate, object $list): array
    {
        return [
            'lista'             => $list,
            'cabecera'          => $this->headers,
            'titulo_admin'      => $this->adminTitle,
            'titulo_eliminar'   => $this->deleteTitle,
            'titulo_modificar'  => $this->updateTitle,
            'paginacion'        => $paramPaginate['cadenapaginacion'],
            'inicio'            => $paramPaginate['inicio'],
            'fin'               => $paramPaginate['fin'],
            'ruta'              => $this->routes,
            'entidad'           => $this->entity,
        ];
    }

    public function getParam($valor, $defecto = NULL)
    {
        return (!is_null($valor) && trim($valor) !== '') ? $valor : $defecto;
    }

    public function cboRangeFilas(): array
    {
        return ['10' => '10', '20' => '20', '50' => '50', '100' => '100', '500' => '500', '1000' => '1000'];
    }

    public function generateCboGeneral($model, $colum, $id, $default): array
    {
        $cbo = ['' => $default] + $model::get()->pluck($colum, $id)->all();
        return $cbo;
    }

    public function verificarExistencia(int $id, string $tabla)
    {
        $reglas = array(
            'id' => 'required|integer|exists:' . $tabla . ',id,deleted_at,NULL'
        );
        $validacion = Validator::make(array('id' => $id), $reglas);
        if ($validacion->fails()) {
            $cadena = '<blockquote><p class="text-danger">Registro no existe en la base de datos. No manipular ID</p></blockquote>';
            $cadena .= '<button class="btn btn-warning btn-sm" id="btnCerrarexiste"><i class="fa fa-times fa-lg"></i> Cerrar</button>';
            $cadena .= "<script type=\"text/javascript\">
							$(document).ready(function() {
								$('#btnCerrarexiste').attr('onclick','cerrarModal(' + (contadorModal - 1) + ');').unbind('click');
							});
						</script>";
            return $cadena;
        } else {
            return true;
        }
    }
}