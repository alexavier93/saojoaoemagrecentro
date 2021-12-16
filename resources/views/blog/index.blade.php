@extends('layouts.app')

@section('title', '- Blog')

@section('content')

    <div id="blog" class="p-5">

        <div class="container">

            <div class="content">

                <div class="titulo">
                    <h2 class="titulo_principal">Blog</h2>
                </div>

                <div class="posts">

                    <div class="row">

                        @foreach ($posts as $post)

                        <a class="item col-md-3" href="{{ route('blog.posts', ['post' => $post->slug]) }}">
                            <div class="blog-image">
                                <img class="img-fluid mx-auto d-block my-3" src="{{ asset('storage/' . $post->image) }}"
                                    alt="">
                            </div>

                            <div class="blog-content">
                                <h2 class="title">{{ $post->title }}</h2>
                            </div>

                            <button type="button" class="btn btn-blog">Saiba Mais</button>
                        </a>

                        @endforeach

                        {{ $posts->links() }}

                    </div>

                </div>



            </div>

        </div>

    </div>

@endsection
