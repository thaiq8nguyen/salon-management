@extends('layouts.main')
@section('pageTitle','Login')
@push('styles')
    <link rel = "stylesheet" href = {{ asset('/css/login.css') }}>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
@endpush
@push('scripts')
    <script src = "{{ asset('js/refresh.js') }}"></script>
@endpush
@section('content')
    <div class = "main-content" id = "root">
        <div class="container">
            <div class="row top-buffer">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class = "card login-card">
                        <div class = "card-header">
                            <h4 class = "card-title">
                                Login
                            </h4>
                        </div>
                        <div class = "card-body">
                            <form role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }} row">
                                    <label for="username" class="col-md-4 control-label">Username</label>
                                    <div class="col-md-8">
                                        <div class = "input-group">
                                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                                        </div>
                                        @if ($errors->has('username'))<span class="text-danger"><strong>{{ $errors->first('username') }}</strong></span>@endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-8">
                                        <div class = "input-group">
                                            <input id="password" type="password" class="form-control" name="password" required>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class = "col-md-4"></div>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>
                                        <a href = "{{route('register')}}" class="btn btn-secondary">
                                            Register
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
