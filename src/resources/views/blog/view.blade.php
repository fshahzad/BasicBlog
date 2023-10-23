@extends('layouts.app')

@section('content')

<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-11 col-lg-10">

            <div class="post-preview clearfix">
                <h1 class="post-title text-primary">{{ $post->title }}</h1>
                <p class="post-meta d-flex justify-content-between">
                    <span>
                    Posted by
                    <a href="{{ '#' }}">{{ $post->user->name }}</a>
                    {{ $post->created_at->diffForHumans() }}
                    </span>
                    <span class="me-3">
                    <a href="#comments">{{ $post->comments->count() }} Comments</a>
                    </span>
                </p>
                @auth
                    @if($user && $post->user_id == $user->id)
                        <div class="my-4">
                            <a href="{{ route('edit-post', ['post' => $post->id]) }}">
                                <i class="fa fa-pencil-square-o"></i> Edit
                            </a>
                        </div>
                    @endif
                @endauth
                @if(!empty($post->post_image))
                    <img src="{{ url('storage/'. env('POST_IMAGES_PATH') . $post->post_image) }}" class="img-fluid float-end border rounded-circle p-1 m-2" width="250">
                @endif
                <p class="post-subtitle fs-5" style="line-height: 1.5rem">
                    {!! nl2br(e($post->body)) !!}
                </p>
            </div>

            <hr class="my-4" style="color:#CECECE" />

            <div class="row">
                <div class="col-sm-12 col-md-9">
                    <a id="comments"></a>
                    <h4 class="post-comments mb-4 text-primary">{{ $post->comments->count() }} Comments</h4>

                    <div class="post-preview  mx-3">
                        @foreach($post->comments as $comm)
                        <p class="post-meta">
                            <div class="fst-italic">
                            <strong># On {{ $comm->created_at->format('M d, Y') }} by {{ $comm->user->name }}</strong>
                            </div>
                        </p>
                        <p class="post-subtitle">
                            {!! nl2br(e($comm->body)) !!}
                        </p>
                        @if($user && $comm->user_id == $user->id)
                            <div class="me-4">
                                <a href="{{ route('delete-comment', ['post' => $post->id,'comment' => $comm->id]) }}" class="text-danger"
                                    onclick="javascript: return confirm('Are you sure to delete?');">
                                    <i class="fa fa-times-circle"></i> Delete
                                </a>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="post-preview mt-4 border-top pt-4">
                        <h4>Write your comment:</h4>
                        @auth
                        <form method="post" action="{{ route('add-post-comment', ['post' => $post->id]) }}">
                            @csrf()
                            <div class="row mb-3">
                                <div class="col-sm-11 col-md-10 col-lg-8">
                                    <textarea rows="5" class="form-control w-100" name="commentText" id="commentText"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </form>
                    @else
                        <p class="text-secondary fst-italic">You must be logged in to write a comment.</p>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login now &raquo;</a>
                    @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
