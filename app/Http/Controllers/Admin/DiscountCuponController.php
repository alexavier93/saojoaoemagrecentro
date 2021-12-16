<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCupon;
use Illuminate\Http\Request;

class DiscountCuponController extends Controller
{

    private $discountCupon;

    public function __construct(DiscountCupon $discountCupon)
    {
        $this->discountCupon = $discountCupon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discountCupons = $this->discountCupon->paginate(10);

        return view('admin.discountcupon.index', compact('discountCupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discountcupon.create');
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

        $this->discountCupon->create($data);

        flash('Cupom criado com sucesso!')->success();
        return redirect()->route('admin.discountcupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiscountCupon  $discountCupon
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountCupon $discountCupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiscountCupon  $discountCupon
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountCupon $discountcupon)
    {
        $discountCupon = $discountcupon;

        return view('admin.discountcupon.edit', compact('discountCupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiscountCupon  $discountCupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $discountcupon)
    {
        $data = $request->all();

        $discountCupon = $this->discountCupon->findOrFail($discountcupon);
        $discountCupon->update($data);

        flash('Cupom atualizado com sucesso!')->success();
        return redirect()->route('admin.discountcupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiscountCupon  $discountCupon
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $discountCupon = $this->discountCupon->findOrFail($id);

        if ($discountCupon->delete() == TRUE) {

            flash('Cupom removido com sucesso!')->success();
            return redirect()->route('admin.discountcupon.index');

        }
        
    }
}
