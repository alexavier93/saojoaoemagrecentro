<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSection;
use App\Models\Section;
use App\Models\Treatment;
use App\Models\Banner;
use App\Models\Newsletter;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {

        $banners = Banner::all();

        $products = Product::where('status', 1)->orderBy('id', 'asc')->limit(8)->get();

        $lastsProducts = Product::where('status', 1)->orderBy('id', 'desc')->limit(4)->get();

        $categories = Category::all();
        $treatments = Treatment::all();
        $sections = Section::all();
        $productSection = ProductSection::orderBy('section_id', 'asc')->get();

        $posts = Post::orderBy('id', 'desc')->limit(10)->get();

        return view('home.index', compact('banners', 'products', 'lastsProducts', 'sections', 'productSection', 'categories', 'treatments', 'posts'));

    }


    public function insertNews(Request $request)
    {
        $data = $request->all();

        if(Newsletter::create($data)){
            $response = array('success' => 'Newsletter cadastrada com sucesso!');
        }else{
            $response = array('erro' => 'Ocorreu um erro, tente novamente.');
        }

        echo json_encode($response);
  
    }

    
}
