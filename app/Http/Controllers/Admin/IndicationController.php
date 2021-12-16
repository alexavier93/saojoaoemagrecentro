<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indication;
use Illuminate\Http\Request;

class IndicationController extends Controller
{
    
    private $indication;

    public function __construct(Indication $indication)
    {
        $this->indication = $indication;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indications = $this->indication->paginate(10);

        return view('admin.indications.index', compact('indications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.indications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->indication->create($data);

        flash('Indicação criada com sucesso!')->success();
        return redirect()->route('admin.indications.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indication  $indication
     * @return \Illuminate\Http\Response
     */
    public function show(Indication $indication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Indication  $indication
     * @return \Illuminate\Http\Response
     */
    public function edit($indication)
    {
        $indication = $this->indication->findOrFail($indication);

        return view('admin.indications.edit', compact('indication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Indication  $indication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $indication)
    {
        $data = $request->all();

        $indication = $this->indication->findOrFail($indication);
        $indication->update($data);

        flash('Indicação atualizada com sucesso!')->success();
        return redirect()->route('admin.indications.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indication  $indication
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $indication = $this->indication->findOrFail($id);

        if ($indication->delete() == TRUE) {

            flash('Indicação removida com sucesso!')->success();
            return redirect()->route('admin.indications.index');

        }
        
    }
}
