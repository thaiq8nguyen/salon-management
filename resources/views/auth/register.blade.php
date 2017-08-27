@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "{{asset('/css/register.css')}}">
@endpush
@section('content')
<div class="container">
    <div class="row top-buffer">
        <div class="col-md-10 mx-auto">
            <div class="card card-form">
                <div class="card-header"><h4 class = "card-title">Register</h4>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('invitation') ? ' has-danger' : '' }} row">
                            <label for="invitation" class="col-md-4 form-control-label text-danger">Invitation Number</label>

                            <div class="col-md-6">
                                <input id="invitation" type="text" class="form-control" name="invitation" value="{{ old('invitation') }}" required autofocus>

                                @if ($errors->has('invitation'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('invitation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} row">
                            <label for="email" class="col-md-4 form-control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} row">
                            <label for="password" class="col-md-4 form-control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 form-control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-md-4">
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                                <a class = "btn btn-secondary" href="/login">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
