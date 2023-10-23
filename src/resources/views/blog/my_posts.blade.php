@extends('layouts.app')

@section('content')

<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-11 col-lg-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Posts</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    {{ __('My Posts') }}
                    <a href="{{ route('add-post') }}" class="btn btn-warning btn-sm px-4"><i class="fa fa-plus-circle"></i> Add New Post</a>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-hover table-sm">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Total Comments</th>
                            <th>Created</th>
                            <th class="col-3 col-lg-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>@if(!empty($post->post_image))
                                    <img src="{{ url('storage/'. env('POST_IMAGES_PATH') . $post->post_image) }}" class="border rounded-circle mx-1" width="50">
                                    @else
                                    <div class="border rounded-circle p-2 px-3 bg-light d-inline-block mx-1">
                                        <i class="fa fa-unlink text-secondary"></i>
                                    </div>
                                @endif
                                {{ $post->title }}
                                <a href="{{ route('view-post', ['post' => $post->id, 'slug' => Str::slug($post->title)]) }}"
                                   target="_blank" title="View"><i class="fa fa-external-link ms-2"></i>
                                </a>
                            </td>
                            <td>{{ $post->comments->count() }}</td>
                            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('edit-post', ['post' => $post->id]) }}" class="btn btn-info btn-sm me-2">
                                    <i class="fa fa-pencil-square-o"></i> Edit
                                </a>
                                <a href="{{ route('delete-post', ['post' => $post->id]) }}"
                                        onclick="javascript: return confirm('Are you sure to delete this post');"
                                        class="btn btn-danger btn-sm mt-1 mt-lg-0">
                                    <i class="fa fa-times-circle"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--
                <form method="POST" action="{{ route('delete-post', ['post' => $post->id]) }}" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Post Title') }} <span class="text-danger">*</span></label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $post->title }}" required autocomplete="off" autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">{{ __('Edit Post') }} <span class="text-danger">*</span></label>
                            <textarea id="body" rows="15" class="form-control @error('body') is-invalid @enderror" name="body" required>{{ $post->body }}</textarea>
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="">
                                <button type="submit" class="btn btn-primary px-4">{{ __('Update') }}</button>
                                <div class="small mt-2"><span class="text-danger">*</span> indicates a required entry field.</div>
                            </div>
                        </div>
                    </form>
                    --}}
                </div>
            </div>


        </div>
    </div>
</div>

@endsection
