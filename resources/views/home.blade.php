@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (is_null($account))
                        <a class="btn btn-block btn-social btn-soundcloud"  href="/auth/login/gitlab">
                            <span class="fa fa-gitlab"></span> Sign in with GitLab
                        </a>
                    @else
                        Already connected.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
