<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\User;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designs = Design::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->get();
        return view('users.index', compact('designs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('designs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $design = Design::create($request->all());
        $design->save();
        $id = $design->id;
        return redirect()->route('design.edit', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $design = Design::find($id);
        return view('designs.edit', ['design' => $design]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $design = Design::where('id',$request->id)->first();
        if($design){
            $design->update($request->all());
            return redirect()->back()->with('success', 'Actualización completada satisfactoriamente.');
        }
        return redirect()->back()->with('error', 'Los datos no se pudieron actualizar, datos incorrectos.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $design = Design::find($id);
        if ($design) {
            $design->delete();
            return redirect()->back()->with('success', 'Se ha eliminado el diseño: '.$design->title.'.');
        }
        return redirect()->back()->with('error', 'No fue posible eliminar el diseño.');
    }
}
