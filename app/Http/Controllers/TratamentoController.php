<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Indication;
use App\Models\Product;
use App\Models\ProductIndication;
use App\Models\ProductSection;
use App\Models\Section;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TratamentoController extends Controller
{

    public function treatment($treatment)
    {

        $treatment = Treatment::where('slug', $treatment)->firstOrFail();

        $categories = Category::all();

        $products = Product::where('treatment_id', $treatment->id)->where('status', 1)->orderBy('id', 'desc')->paginate(12);
   
        $sections = Section::all();
        $productSection = ProductSection::orderBy('section_id', 'asc')->get();

        return view('tratamentos.treatment', compact('treatment', 'categories', 'products', 'sections', 'productSection'));
    }


    public function category($treatment = null, $category)
    {

        $category = Category::where('slug', $category)->firstOrFail();

        $treatment = Treatment::where('id', $category->treatment_id)->first();

        $products = $category->products()->orderBy('id', 'desc')->paginate(12);

        $sections = Section::all();
        $productSection = ProductSection::orderBy('section_id', 'asc')->get();

        return view('tratamentos.category', compact('treatment', 'category', 'products', 'sections', 'productSection'));
    }


    public function product($treatment = null, $category = null, $product)
    {

        $product = Product::where('slug', $product)->firstOrFail();

        $sections = Section::all();
        $productSection = ProductSection::where('product_id', $product->id)->orderBy('section_id', 'asc')->get();

        $indications = Indication::all();
        $productIndication = ProductIndication::where('product_id', $product->id)->get();

        return view('tratamentos.product',  compact('product', 'sections', 'productSection', 'indications', 'productIndication'));
    }


    public function getPrice(Request $request)
    {
        $product = $request->product_id;

        $productSection = ProductSection::where('id', $request->id)->firstOrFail();

        if($product == $productSection->product_id){

            $response = array(
                'exists'    => true,
                'price'     => $productSection->price,
                'priceView' => number_format($productSection->price, 2, ',', ' ')
            );

        }else{
            $response = array(
                'exists'    => false
            );
        }

        return response()->json($response);

    }
}
