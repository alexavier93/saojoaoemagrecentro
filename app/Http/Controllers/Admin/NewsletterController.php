<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    
    private $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletters = $this->newsletter->simplePaginate(10);

        return view('admin.newsletters.index', compact('newsletters'));
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

        $newsletter = $this->newsletter->findOrFail($id);
	    $newsletter->delete();

	    flash('Mensagem excluída com sucesso!')->success();
	    return redirect()->route('admin.newsletters.index');
    }
}
