<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{

    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = $this->post->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * validação do post 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
     * 
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        $image = $request->file('image')->store('posts', 'public');
        $data['image'] = $image;

        // Redimensionando a imagem
        $image = Image::make(public_path("storage/{$image}"))->fit(650, 433);
        $image->save();

        $this->post->create($data);

        flash('Post Criado com Sucesso!')->success();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post)
    {
        $post = $this->post->findOrFail($post);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post)
    {
        $data = $request->all();
        
        $post = $this->post->find($post);

        $slug = Str::slug($request->title, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {

            if (Storage::exists($post->image)) {
                Storage::delete($post->image);
            }

            $image = $request->file('image')->store('posts', 'public');
            $data['image'] = $image;

            // Redimensionando a imagem
            $image = Image::make(public_path("storage/{$image}"))->fit(650, 433);
            $image->save();
        }

        $post->update($data);

        flash('Post Atualizado com Sucesso!')->success();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $post = $this->post->find($id);

        if ($post->delete() == TRUE) {

            if (Storage::exists($post->image)) {
                Storage::delete($post->image);
            }

            flash('Post removido com sucesso!')->success();
            return redirect()->route('admin.posts.index');

        }
        
    }

}
