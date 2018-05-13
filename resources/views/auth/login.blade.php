@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <a class="btn btn-block btn-social btn-twitter"  href="/auth/login/twitter">
                        <span class="fa fa-twitter"></span> Sign in with Twitter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
