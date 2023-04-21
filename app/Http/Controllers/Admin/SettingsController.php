<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use CRUDTrait;

    public function __construct()
    {
        $this->model        = new Setting();

        $this->entity       = 'settings';
        $this->folderview   = 'admin.setting';
        $this->adminTitle   = __('maintenance.admin.setting.title');
        $this->addTitle     = __('maintenance.general.add', ['entity' => $this->adminTitle]);
        $this->updateTitle  = __('maintenance.general.edit', ['entity' => $this->adminTitle]);
        $this->deleteTitle  = __('maintenance.general.delete', ['entity' => $this->adminTitle]);
        $this->routes = [
            'search'  => 'setting.search',
            'index'   => 'setting.index',
            'store'   => 'setting.store',
            'delete'  => 'setting.delete',
            'create'  => 'setting.create',
            'edit'    => 'setting.edit',
            'update'  => 'setting.update',
            'destroy' => 'setting.destroy',
        ];
        $this->idForm       = 'formMantenimiento' . $this->entity;
        $this->headers = [
            [
                'valor'  => 'Nombre',
                'numero' => '1',
            ],
            [
                'valor'  => 'Email',
                'numero' => '1',
            ],
            [
                'valor'  => 'Tipo de Usuario',
                'numero' => '1',
            ],
            [
                'valor'  => 'Persona',
                'numero' => '1',
            ],
            [
                'valor'  => 'Acciones',
                'numero' => '1',
            ],
        ];
    }
}