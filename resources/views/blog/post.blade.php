@extends('layouts.app')

@section('title', '- ' . $post->title)

@section('content')

    <div class="blog-post">

        <div class="container">

            <div class="content py-5">

                <div class="row">


                    <div class="col-md-6 offset-md-1">
                        <div class="image mb-5">
                            <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="">
                        </div>

                        <h1 class="title">{{ $post->title }}</h1>

                        <div class="text">{!! $post->description !!}</div>

                    </div>

                    <div class="col-md-4 offset-md-1">

                        <div class="lasts-posts">

                            <h3>Últimas do blog</h3>

                            <ul>
                                @foreach ($posts as $item)
                                    <li><a href="{{ route('blog.posts', ['post' => $item->slug]) }}">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>

                        </div>

                        
                    </div>

                </div>



            </div>

        </div>

    </div>

@endsection
