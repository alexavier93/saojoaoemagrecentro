@extends('layouts.app')
@extends('account.nav')

@section('title', '- Login')

@section('content')

    <div id="login">


        <div class="container">

            <div class="content">

                <div class="row">

                    <div class="col-lg-3">
                        @section('nav_content')
                    </div>

                    <div class="col-lg-9">

                        <h1 class="mb-3 display-6">Endereço</h1>

                        <form action="">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">CEP</label>
                                    <input type="text" id="cepConsulta" class="form-control cep" name="cep" value="{{ $address->cep }}"
                                        placeholder="Digite um CEP" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Logradouro (Ex: Rua, Avenida)</label>
                                    <input type="text" class="form-control" name="logradouro" value="{{ $address->logradouro }}" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Número</label>
                                    <input type="text" class="form-control" name="numero" value="{{ $address->numero }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Complemento</label>
                                    <input type="text" class="form-control" name="complemento" value="{{ $address->complemento }}" required>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Bairro</label>
                                    <input type="text" class="form-control" name="bairro" value="{{ $address->bairro }}" required>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Cidade</label>
                                    <input type="text" class="form-control" name="cidade" value="{{ $address->cidade }}" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">UF</label>
                                    <input type="text" class="form-control" name="uf" value="{{ $address->uf }}" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-secondary">Salvar Informações</button>

                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
