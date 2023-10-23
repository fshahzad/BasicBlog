@extends('layouts.email')

@section('content')

    <p style="font-weight: bold;">
        Hello there,
        <br><br>Checkout our latest blog posts:
    </p>

    <p><br></p>

    <ul style="list-style: square">
        @foreach($posts as $post)
            <li style="margin-bottom:10px;padding:10px;">
                <a href="{{ route('view-post', ['post' => $post->id, 'slug' => Str::slug($post->title)]) }}"
                   style="border-bottom:1px solid #0b2717; background:#f8f8f8; line-height:20px; text-decoration:none; font-weight:bold" target="_blank">
                    {{ $post->title }}
                </a>
            </li>
        @endforeach
    </ul>

    <p><br></p>

@endsection
