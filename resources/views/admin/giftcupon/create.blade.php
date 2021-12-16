@extends('admin.layouts.app')

@section('title', '- Novo Sessão')

@section('content')

    <!-- Page Heading -->
    <div class="page-header-content py-3">

        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Cupom de Presente</h1>
        </div>

        <ol class="breadcrumb mb-0 mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.giftcupon.index') }}">Cupom de Presente</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo Cupom</li>
        </ol>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-xl-12 col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">

                <div class="card-header">
                    <span class="m-0 font-weight-bold text-primary">Informações</span>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.giftcupon.store') }}" method="post">

                        @csrf
                    
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Valor</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input type="text" name="value" class="form-control money" placeholder="0,00" value="{{ old('value') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Código</label>
                            <div class="col-sm-10">
                                <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Quantidade</label>
                            <div class="col-sm-10">
                                <input type="text" name="quantity" class="form-control numero" value="{{ old('quantity') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>

                    </form>


                </div>

            </div>

        </div>

    </div>


@endsection
