<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCupon;
use Illuminate\Http\Request;

class GiftCuponController extends Controller
{
    
    private $giftCupon;

    public function __construct(GiftCupon $giftCupon)
    {
        $this->giftCupon = $giftCupon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $giftCupons = $this->giftCupon->paginate(10);

        return view('admin.giftcupon.index', compact('giftCupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.giftcupon.create');
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
        $data['value'] = str_replace(',', '.', $request->value);

        $this->giftCupon->create($data);

        flash('Cupom criado com sucesso!')->success();
        return redirect()->route('admin.giftcupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GiftCupon  $giftCupon
     * @return \Illuminate\Http\Response
     */
    public function show(GiftCupon $giftCupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GiftCupon  $giftCupon
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftCupon $giftcupon)
    {
        $giftCupon = $giftcupon;

        return view('admin.giftcupon.edit', compact('giftCupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GiftCupon  $giftCupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $giftcupon)
    {
        $data = $request->all();
        $data['value'] = str_replace(',', '.', $request->value);

        $giftCupon = $this->giftCupon->findOrFail($giftcupon);
        $giftCupon->update($data);

        flash('Cupom atualizado com sucesso!')->success();
        return redirect()->route('admin.giftcupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $giftCupon = $this->giftCupon->findOrFail($id);

        if ($giftCupon->delete() == TRUE) {

            flash('Cupom removido com sucesso!')->success();
            return redirect()->route('admin.giftcupon.index');

        }
        
    }
}
