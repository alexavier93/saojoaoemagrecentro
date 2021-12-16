@extends('admin.layouts.app')

@section('title', '- Editar Produto')

@section('content')

    <!-- Page Heading -->
    <div class="page-header-content py-3">

        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Produtos</h1>
        </div>

        <ol class="breadcrumb mb-0 mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Produto</li>
        </ol>

    </div>

    @include('flash::message')

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

                    <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="post"
                        enctype="multipart/form-data">

                        @csrf
                        @method("PUT")

                        <div class="form-group row">
                            <div class="col-sm-2">Status</div>
                            <div class="col-sm-10">
                                <label class="switch">
                                    <input type="checkbox" name="status" value="1" {{ $product->status == 1 ? 'checked' : '' }}>
                                    <span class="slider success"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2">Disponível para Avaliação</div>
                            <div class="col-sm-10">
                                <label class="switch">
                                    <input type="checkbox" name="available" value="1" {{ $product->available == 1 ? 'checked' : '' }}>
                                    <span class="slider success"></span>
                                </label>
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tratamentos</label>
                            <div class="col-sm-10">
                                <select name="treatment_id" class="form-control @error('treatment_id') is-invalid @enderror">
                                    <option value="">Selecione uma opção</option>
                                    @foreach ($treatments as $treatment)
                                        <option value="{{ $treatment->id }}" {{ $product->treatment_id == $treatment->id ? 'selected' : '' }}>{{ $treatment->title }}</option>
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
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ $product->title }}">
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
                                <input type="text" name="short_description"
                                    class="form-control @error('short_description') is-invalid @enderror"
                                    value="{{ $product->short_description }}">
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
                                <textarea name="description"
                                    class="form-control summernote @error('description') is-invalid @enderror">{{ $product->description }}</textarea>
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
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input type="text" name="price" class="form-control money @error('price') is-invalid @enderror" value="{{ $product->price }}" placeholder="0,00">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Preço Antigo</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input type="text" name="old_price" class="form-control money" value="{{ $product->old_price }}" placeholder="0,00">

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Preço Novo</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">R$</div>
                                    </div>
                                    <input type="text" name="new_price" class="form-control money" value="{{ $product->new_price }}" placeholder="0,00">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tag Desconto</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $product->discount }}">
                                </div>
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

        <!-- Content Column -->
        <div class="col-xl-12 col-md-12 mb-4">

            <div class="row">

                <div class="col-md-6">

                    <!-- Upload Imagem Thumb -->
                    <div class="col-md-12">

                        <div class="card shadow mb-4">

                            <div class="card-header">
                                <span class="m-0 font-weight-bold text-primary">Imagem Thumb</span>
                                <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#modalThumb">Upload</button>
                            </div>

                            <div class="card-body text-center">

                                @if ($product->image != null)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mx-auto w-50">
                                @endif

                                <div class="text-center">
                                    <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                        <a href="{{ route('admin.products.deleteThumb', ['image' => $product->id]) }}"
                                            class="btn btn-danger">Excluir</a>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalThumb" tabindex="-1" aria-labelledby="modalThumbLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalThumbLabel">Upload Imagem</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="imageUpload" action="{{ route('admin.products.uploadThumb') }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $product->id }}">

                                            <div class="form-group">
                                                <input type="file" class="form-control-file" name="image">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" form="imageUpload" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Upload Imagem Banner -->
                    <div class="col-md-12">
                        
                        <div class="card shadow mb-4">

                            <div class="card-header">
                                <span class="m-0 font-weight-bold text-primary">Imagem Banner</span>
                                <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#modalBanner">Upload</button>
                            </div>

                            <div class="card-body text-center">

                                @if ($product->banner != null)
                                    <img src="{{ asset('storage/' . $product->banner) }}" class="img-fluid mx-auto w-75">
                                @endif

                                <div class="text-center">
                                    <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                        <a href="{{ route('admin.products.deleteBanner', ['banner' => $product->id]) }}"
                                            class="btn btn-danger">Excluir</a>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalBanner" tabindex="-1" aria-labelledby="modalBannerLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalBannerLabel">Upload Banner</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="bannerUpload" action="{{ route('admin.products.uploadBanner') }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $product->id }}">

                                            <div class="form-group">
                                                <input type="file" class="form-control-file" name="banner">
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" form="bannerUpload" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <!-- SEÇÕES -->
                    <div class="col-md-12">

                        <div class="card shadow mb-4">

                            <div class="card-header">
                                <span class="m-0 font-weight-bold text-primary">Seções</span>
                                <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#modalSection">Cadastrar</button>
                            </div>

                            <div class="card-body">

                                <ul class="list-group">

                                    @foreach ($sections as $section)

                                        @foreach ($productSection as $prodSection)

                                            @if ($section->id == $prodSection->section_id)
                                                <li href="#" class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between">

                                                        <p class="mb-1">{{ $section->title }} - <small>R$ {{ $prodSection->price }}</small></p>

                                                        <small class="text-muted">
                                                            <a href="{{ route('admin.products.deleteSection', ['id' => $prodSection->id]) }}" class="close" title="Excluir Sessão">×</a>
                                                        </small>
                                                    </div>
                                                    
                                                </li>
                                            @endif

                                        @endforeach

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalSection" tabindex="-1" aria-labelledby="modalSectionLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalSectionLabel">Inserir Indicação</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="sectionInsert" action="{{ route('admin.products.insertSection') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                                            <div class="form-group">
                                                <label>Seções</label>
                                                <select name="section_id" class="form-control" required>
                                                    <option value="">Selecione uma opção</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}">{{ $section->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Valor</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">R$</div>
                                                    </div>
                                                    <input type="text" class="form-control money" name="price" placeholder="0,00">
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" form="sectionInsert" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- INDICAÇÕES -->       
                    <div class="col-md-12">
                        
                        <div class="card shadow mb-4">

                            <div class="card-header">
                                <span class="m-0 font-weight-bold text-primary">Indicações de Uso</span>
                                <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#modalIndication">Cadastrar</button>
                            </div>

                            <div class="card-body">
                                <ul class="list-group">
                                @foreach ($indications as $indication)
                                    @foreach ($productIndication as $prodIndication)

                                        @if ($indication->id == $prodIndication->indication_id)

                                            
                                                <li href="#" class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{ $indication->title }}</h6>
                                                        <small class="text-muted">
                                                            <a href="{{ route('admin.products.deleteIndication', ['id' => $prodIndication->id]) }}" class="close" title="Excluir Sessão">×</a>
                                                        </small>
                                                    </div>
                                                    <div>{!! $prodIndication->description !!}</div>
                                                </li>
                                            

                                        @endif

                                    @endforeach
                                @endforeach
                            </ul>

                            </div>


                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalIndication" tabindex="-1" aria-labelledby="modalIndicationLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalIndicationLabel">Inserir Indicação</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="progressInsert" action="{{ route('admin.products.insertIndication') }}"
                                            method="post">

                                            @csrf

                                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                                            <div class="form-group">
                                                <label>Indicações</label>
                                                <select name="indication_id" class="form-control">
                                                    @foreach ($indications as $indication)
                                                        <option value="{{ $indication->id }}">{{ $indication->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Descrição</label>
                                                <textarea name="description" class="form-control summernote"></textarea>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" form="progressInsert" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
