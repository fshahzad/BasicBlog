@extends('layouts.app')

@section('content')

<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-11 col-lg-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('my-posts') }}">My Posts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Post</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ __('Add New Post') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('save-post') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Post Title') }} <span class="text-danger">*</span></label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="off" autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="post_image" class="form-label">{{ __('Post Image') }} <span class="text-secondary small">(Optional)</span></label>
                            <input id="post_image" type="file" class="form-control @error('post_image') is-invalid @enderror" name="post_image">
                            <div class="small text-info">Please upload jpg or png file type only. Maximum size 2MB</div>
                            @error('post_image')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">{{ __('Post Text') }} <span class="text-danger">*</span></label>
                            <textarea id="body" rows="15" class="form-control @error('body') is-invalid @enderror" name="body" required>{{ old('body') }}</textarea>
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="">
                                <button type="submit" class="btn btn-primary px-4">{{ __('Submit') }}</button>
                                <div class="small mt-2"><span class="text-danger">*</span> indicates a required entry field.</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection
