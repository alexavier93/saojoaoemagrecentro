<?php

namespace App\Http\Controllers;

use App\Mail\ContatoMail;
use App\Mail\NewAccountMail;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{

    private $contato;

    public function __construct(Message $contato)
    {
        $this->contato = $contato;
    }

    public function index()
    {
 
        return view('contato.index');
  
    }


    public function email(){

        $data['firstname'] = 'Alexandre';
        $data['email'] = 'alexandre.xavier@outlook.com';
        $data['order_code'] = '123456789';
        $data['firstname'] = 'Alexandre';
        $data['produtos'] = ['Camisa', 'Shorts', 'Blusa'];
        $data['total'] = 150;

        return new NewAccountMail($data);

    }


    public function enviaEmail(Request $request)
    {

        $data = $request->all();
        $data['status'] = 0;

        //Mail::to('alexandre.xavier@outlook.com')->send(new ContatoMail($data));
        
        $this->contato->create($data);

        flash('Contato enviado com sucesso!')->success();
        return redirect()->route('contato.index');
  
    }

}
