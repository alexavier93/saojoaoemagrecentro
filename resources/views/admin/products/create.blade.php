@extends('admin.layouts.app')

@section('title', '- Novo Produto')

@section('content')

    <!-- Page Heading -->
    <div class="page-header-content py-3">

        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Produtos</h1>
        </div>

        <ol class="breadcrumb mb-0 mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo Produto</li>
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

                    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tratamentos</label>
                            <div class="col-sm-10">
                                <select name="treatment_id" class="form-control @error('treatment_id') is-invalid @enderror">
                                    <option value="">Selecione uma opção</option>
                                    @foreach ($treatments as $treatment)
                                        <option value="{{ $treatment->id }}">{{ $treatment->title }}</option>
                                    @endforeach
                                </select>
                                @error('treatment_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Categorias</label>
                            <div class="col-sm-10">
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"></select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Público</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="female" name="female" value="1">
                                    <label class="form-check-label" for="female">Feminino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="male" name="male" value="1">
                                    <label class="form-check-label" for="male">Masculino</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Breve Descrição</label>
                            <div class="col-sm-10">
                                <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description') }}">
                                @error('short_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Descrição</label>
                            <div class="col-md-10">
                                <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label">Preço Regular</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control money @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="R$ 0,00">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label">Preço Antigo</label>
                            <div class="col-sm-10">
                                <input type="text" name="old_price" class="form-control money" value="{{ old('old_price') }}" placeholder="R$ 0,00">
                            </div>

                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label">Preço Novo</label>
                            <div class="col-sm-10">
                                <input type="text" name="new_price" class="form-control money" value="{{ old('new_price') }}" placeholder="R$ 0,00">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label">Tag Desconto</label>
                            <div class="col-sm-10">
                                <input type="text" name="discount" class="form-control numero" value="{{ old('discount') }}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-2">Imagem <small>(Ex: 350x350)</small></div>
                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2">Banner <small>(Ex: 1920x530)</small></div>
                            <div class="col-sm-10">
                                <input type="file" name="banner" class="form-control @error('banner') is-invalid @enderror">
                                @error('banner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
