@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "/css/post-register.css">
@endpush
@section('content')
    <div class = "container">
        <div class = "row top-buffer">
            <div class="col-md-6 mx-auto">
                <div class="card notification">
                    @if(session('error'))
                        <div class = "card-header bg-danger">
                            <h3>Errors</h3>
                        </div>
                        <div class = "card-body">
                            <div class = "text-danger">
                                {{ session('error') }}
                            </div>
                        </div>
                        <div class = "card-footer">
                            <a class = "btn btn-primary" href="/login">Login</a>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class = "card-header bg-success">
                            <h3>Registration Completed</h3>
                        </div>
                        <div class = "card-body">
                            <div class = "text-success">
                                {{ session('success') }}
                            </div>
                        </div>
                        <div class = "footer">
                            <a class = "btn btn-primary" href="/technician">Home</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection