@extends('layouts.main')
@section('pageTitle','Login')
@push('styles')
    <link rel = "stylesheet" href = "/css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
@endpush
@section('content')
    <div class = "main-content">
        <div class="container">
            <div class="row top-buffer">
                <div class="col-md-4 col-md-offset-3">
                    @component('panels.darkblue')
                        @slot('title')
                            Login
                        @endslot
                        @slot('body')
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="col-md-4 control-label">Username</label>
                                    <div class="col-md-6">
                                        <div class = "input-group">
                                            <div class = "input-group-addon"><i class = "fa fa-user fa-lg"></i></div>
                                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                                        </div>
                                        @if ($errors->has('username'))<span class="help-block"><strong>{{ $errors->first('username') }}</strong></span>@endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <div class = "input-group">
                                            <div class = "input-group-addon"><i class = "fa fa-lock fa-lg"></i></div>
                                            <input id="password" type="password" class="form-control" name="password" required>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>

@endsection
