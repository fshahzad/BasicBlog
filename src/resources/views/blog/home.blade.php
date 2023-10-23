@extends('layouts.app')

@section('content')

<div class="container px-4 px-lg-5">
    <div class="row">
        <div class="col-sm-8 offset-sm-4 col-lg-4 offset-lg-8">
            <form action="{{ route('home') }}" method="GET">
                <div class="row align-items-center">
                    <div class="col-sm-2">
                        <label for="search" class="col-form-label">Search: </label>
                    </div>
                    <div class="col-sm-10 d-flex">
                        <input type="text" name="search" id="search" class="form-control">
                        <input type="submit" class="btn btn-sm btn-primary ms-1" value="Go">
                </div>
            </form>
        </div>
    </div>
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-11 col-lg-10">
            @foreach($posts as $post)
            <div class="post-preview clearfix">
                <a href="{{ route('view-post', ['post' => $post->id, 'slug' => Str::slug($post->title)]) }}">
                    <h2 class="post-title">{{ $post->title }}</h2>
                </a>
                <p class="post-meta d-flex justify-content-between">
                    <span>
                    Posted by
                    <a href="{{ '#' }}">{{ $post->user->name }}</a>
                    {{ $post->created_at->diffForHumans() }}
                    </span>
                    <span>
                    {{ $post->comments->count() }} Comments
                    </span>
                </p>
                @if(!empty($post->post_image))
                    <img src="{{ url('storage/'. env('POST_IMAGES_PATH') . $post->post_image) }}" class="img-fluid float-end border rounded-circle p-1 m-2" width="100">
                @endif
                <p class="post-subtitle">
                    {{ Str::of($post->body)->words(70) }}
                    <a href="{{ route('view-post', ['post' => $post->id, 'slug' => Str::slug($post->title)]) }}">
                        continue read &raquo;
                    </a>
                </p>
            </div>
            <hr class="my-4" style="color:#CECECE" />
            @endforeach
        </div>
        <div class="col-md-11 col-lg-10 d-flex justify-content-center">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection
