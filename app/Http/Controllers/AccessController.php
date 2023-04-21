<?php

namespace App\Http\Controllers;

use App\Models\MenuGroup;
use App\Models\MenuOption;
use App\Models\UserType;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    private $folder = 'admin.access';
    private $route = 'access.store';


    public function index()
    {
        $tipousuarios = UserType::orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $grupomenus = MenuGroup::with('menuoption')
            ->get()
            ->toArray();
        $opcionmenus = MenuOption::with('usertype')
            ->get()
            ->pluck('usertype', 'id')
            ->toArray();
        $opciones = MenuOption::with('usertype')
            ->get()
            ->toArray();
        return view($this->folder  . '.index', compact('opciones', 'tipousuarios', 'grupomenus', 'opcionmenus'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $tipousuarios = new UserType();
            if ($request->input('estado') == 1) {
                $tipousuarios->find($request->input('usertype_id'))->menuoption()->attach($request->input('menuoption_id'));
                return response()->json(['respuesta' => 'El acceso se asigno correctamente']);
            } else {
                $tipousuarios->find($request->input('usertype_id'))->menuoption()->detach($request->input('menuoption_id'));
                return response()->json(['respuesta' => 'El acceso se elimino correctamente']);
            }
        } else {
            abort(404);
        }
    }
}