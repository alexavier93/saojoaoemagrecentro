<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Indication;
use App\Models\Product;
use App\Models\ProductIndication;
use App\Models\ProductSection;
use App\Models\Section;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = DB::table('products')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->select('products.*', 'categories.title as categoryTitle')
        ->orderBy('categories.id', 'ASC')
        ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $treatments = Treatment::all();
        $sections = Section::all();

        return view('admin.products.create', compact('treatments', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        // Upload Imagem Thumb
        $image = $request->file('image')->store('catalog/products', 'public');
        $data['image'] = $image;
        $image = Image::make(public_path("storage/{$image}"))->fit(350, 350);
        $image->save();

        // Upload Banner
        $banner = $request->file('banner')->store('catalog/products', 'public');
        $data['banner'] = $banner;
        $banner = Image::make(public_path("storage/{$banner}"))->fit(1920, 530);
        $banner->save();

        $data['price'] = str_replace(',', '.', $request->price);

        if($request->filled('new_price')) {
            $data['old_price'] = str_replace(',', '.', $request->old_price);
        }
        if($request->filled('new_price')) {
            $data['new_price'] = str_replace(',', '.', $request->new_price);
        }
        
        $data['status'] = '1';

        $product = $this->product->create($data);

        if($product){
            flash('Produto criada com sucesso!')->success();
            return redirect()->route('admin.products.edit', ['product' => $product->id]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {

        $product = $this->product->findOrFail($product);

        $treatments = Treatment::all();
        $categories = Category::all();
        $sections = Section::all();
        $productSection = ProductSection::where('product_id', $product->id)->get();
        $indications = Indication::all();
        $productIndication = ProductIndication::where('product_id', $product->id)->get();

        return view('admin.products.edit', compact('product', 'treatments', 'categories', 'sections', 'productSection', 'indications', 'productIndication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $product)
    {
        $data = $request->all();

        $product = $this->product->findOrFail($product);

        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        // Upload Imagem Thumb
        if ($request->hasFile('image')) {

            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }

            $image = $request->file('image')->store('catalog/products', 'public');
            $data['image'] = $image;
            $image = Image::make(public_path("storage/{$image}"))->fit(350, 350);
            $image->save();
        }

        // Upload Banner
        if ($request->hasFile('banner')) {

            if (Storage::exists($product->banner)) {
                Storage::delete($product->banner);
            }

            $banner = $request->file('banner')->store('catalog/products', 'public');
            $data['banner'] = $banner;
            $banner = Image::make(public_path("storage/{$banner}"))->fit(1920, 530);
            $banner->save();
        }

        $data['price'] = str_replace(',', '.', $request->price);

        if($request->filled('new_price')) {
            $data['old_price'] = str_replace(',', '.', $request->old_price);
        }
        if($request->filled('new_price')) {
            $data['new_price'] = str_replace(',', '.', $request->new_price);
        }

        if ($request->available == 1) {
            $data['available'] = 1;
        } else {
            $data['available'] = 0;
        }

        if ($request->status == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $product->update($data);

        flash('Produto atualizado com sucesso!')->success();
        return redirect()->route('admin.products.edit', ['product' => $product->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $product = $this->product->findOrFail($id);

        if ($product->delete() == TRUE) {

            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            if (Storage::exists($product->banner)) {
                Storage::delete($product->banner);
            }

            flash('Produto removido com sucesso!')->success();
            return redirect()->route('admin.products.index');

        }
        
    }

    /**
     * Resgatar categoria
     */
    public function getCategory(Request $request)
    {

        if (isset($_POST["treatment"])) {

            $treatment = $request->treatment;

            $categories = Category::where('treatment_id', $treatment)->orderBy('id','DESC')->get();

            if ($categories->count() > 0) {

                foreach($categories as $category){
                    echo '<option value="' . $category->id . '">' . $category->title . '</option>';
                }

            } else {

                echo '<option value="0">Não há registros</option>';

            }

        }
        
    }

    /**
     * Inserir Seções
     */
    public function insertSection(Request $request)
    {

        $data = $request->all();

        $product_id = $request->product_id;

        $data['price'] = str_replace(',', '.', str_replace('.', '', $request->price));

        ProductSection::create($data);

        flash('Progresso cadastrado com sucesso!')->success();
        return redirect()->route('admin.products.edit', ['product' => $product_id]);
        
    }

    /**
     * Deletar Seções
     */
    public function deleteSection($id)
    {

        $section = ProductSection::find($id);
        $product = $section->product_id;

        if ($section->delete() == TRUE) {

            flash('Progresso removido com sucesso!')->success();
            return redirect()->route('admin.products.edit', ['product' => $product]);

        }

    }

    public function insertIndication(Request $request)
    {

        $data = $request->all();

        $product_id = $request->product_id;

        ProductIndication::create($data);

        flash('Indicação cadastrada com sucesso!')->success();
        return redirect()->route('admin.products.edit', ['product' => $product_id]);
        
    }

    public function deleteIndication($id)
    {

        $indication = ProductIndication::find($id);
        $product = $indication->product_id;

        if ($indication->delete() == TRUE) {

            flash('Indicação removida com sucesso!')->success();
            return redirect()->route('admin.products.edit', ['product' => $product]);

        }

    }

    public function uploadThumb(Request $request)
    {
        $data = $request->all();

        $product_id = $request->id;
        $product = $this->product->findOrFail($product_id);
        $productDir = $product->id;

        if($request->hasFile('image'))
        {

            $image = $request->file('image');

            $image = $image->store('products/'.$productDir, 'public');
            $data['image'] = $image;

            $product->where('id', $product_id)->update(['image' => $image]);
                
        }

        flash('Upload realizado com sucesso!')->success();
        return redirect()->route('admin.products.edit', ['product' => $product_id]);
        
    }

    public function deleteThumb($image)
    {

        $product = $this->product->find($image);
        $id = $product->id;
        $image = $product->image;

        $update = $product->where('id', $id)->update(['image' => null]);

        if ($update == TRUE) {

            if (Storage::exists($image)) {
                Storage::delete($image);
            }

            flash('Logo removido com sucesso!')->success();
            return redirect()->route('admin.products.edit', ['product' => $id]);

        }

    }

    public function uploadBanner(Request $request)
    {

        $product_id = $request->id;
        $product = $this->product->findOrFail($product_id);
        $productDir = $product->id;

        if($request->hasFile('banner'))
        {

            $banner = $request->file('banner');

            $banner = $banner->store('products/'.$productDir, 'public');
            $data['banner'] = $banner;

            $product->where('id', $product_id)->update(['banner' => $banner]);

        
                
        }

        flash('Upload realizado com sucesso!')->success();
        return redirect()->route('admin.products.edit', ['product' => $product_id]);
        
    }

    public function deleteBanner($banner)
    {

        $product = $this->product->find($banner);
        $id = $product->id;
        $banner = $product->banner;

        $update = $product->where('id', $id)->update(['banner' => null]);

        if ($update == TRUE) {

            if (Storage::exists($banner)) {
                Storage::delete($banner);
            }

            flash('Logo removido com sucesso!')->success();
            return redirect()->route('admin.products.edit', ['product' => $id]);

        }

    }

}
