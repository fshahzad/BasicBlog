@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Congratulations!</h2>
                            <h4>Your registration completed successfully.</h4>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-sm-12">
                            <a href="{{ route('home') }}" class="btn btn-primary">Continue &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
