<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TreatmentRequest;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class TreatmentController extends Controller
{
    
    private $treatment;

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treatments = $this->treatment->paginate(10);

        return view('admin.treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.treatments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TreatmentRequest $request)
    {
        $data = $request->all();

        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        $image = $request->file('image')->store('catalog/treatments', 'public');
        $data['image'] = $image;

        // Redimensionando a imagem
        $image = Image::make(public_path("storage/{$image}"))->fit(1920, 530);
        $image->save();

        $this->treatment->create($data);

        flash('Tratamento criada com sucesso!')->success();
        return redirect()->route('admin.treatments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit($treatment)
    {
        $treatment = $this->treatment->findOrFail($treatment);
        return view('admin.treatments.edit', compact('treatment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(TreatmentRequest $request, $treatment)
    {
        $data = $request->all();

        $treatment = $this->treatment->findOrFail($treatment);

        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {

            if (Storage::exists($treatment->image)) {
                Storage::delete($treatment->image);
            }

            $image = $request->file('image')->store('catalog/treatments', 'public');
            $data['image'] = $image;

            // Redimensionando a imagem
            $image = Image::make(public_path("storage/{$image}"))->fit(1920, 530);
            $image->save();
        }

        $treatment->update($data);

        flash('Tratamento atualizada com sucesso!')->success();
        return redirect()->route('admin.treatments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $treatment = $this->treatment->findOrFail($id);

        if ($treatment->delete() == TRUE) {

            if (Storage::exists($treatment->image)) {
                Storage::delete($treatment->image);
            }

            flash('Tratamento removida com sucesso!')->success();
            return redirect()->route('admin.treatments.index');

        }
        
    }

}
