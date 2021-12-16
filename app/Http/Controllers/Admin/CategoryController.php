<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = DB::table('categories')
            ->join('treatments', 'treatments.id', '=', 'categories.treatment_id')
            ->select('categories.*', 'treatments.title as treatmentTitle')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $treatments = Treatment::all();
        return view('admin.categories.create', compact('treatments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        
        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {

            $image = $request->file('image')->store('catalog/categories', 'public');
            $data['image'] = $image;

            // Redimensionando a imagem
            $image = Image::make(public_path("storage/{$image}"))->fit(500, 325);
            $image->save();

        }
        
        $this->category->create($data);

        flash('Categoria criada com sucesso!')->success();
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        $treatments = Treatment::all();

        $category = $this->category->findOrFail($category);

        return view('admin.categories.edit', compact('category', 'treatments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $category)
    {
        $data = $request->all();

        $category = $this->category->findOrFail($category);

        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {

            if (Storage::exists($category->image)) {
                Storage::delete($category->image);
            }

            $image = $request->file('image')->store('catalog/categories', 'public');
            $data['image'] = $image;

            // Redimensionando a imagem
            $image = Image::make(public_path("storage/{$image}"))->fit(500, 325);
            $image->save();
        }

        $category->update($data);

        flash('Categoria atualizada com sucesso!')->success();
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $category = $this->category->findOrFail($id);

        if ($category->delete() == TRUE) {

            if (Storage::exists($category->image)) {
                Storage::delete($category->image);
            }

            flash('Categoria removida com sucesso!')->success();
            return redirect()->route('admin.categories.index');

        }
        
    }
}
