@extends('layouts.main')
@section('pageTitle','Salon Management')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('/css/home.css') }}">
    <link rel = "stylesheet"  href = "{{ asset('css/navbar-shortcut.css') }}">
    <link rel ="stylesheet" href = "{{ url('https://fonts.googleapis.com/css?family=Roboto') }}" >
@endpush
@section('content')
    @component('partials.header')
        <h1>Salon Management</h1>
    @endcomponent
    <div class = "main-content">
        <div class="container-fluid">
            <div class="row top-buffer">
                <div class = "col-md-1">
                    <ul class = "nav nab-pills nav-stacked shortcut">
                        <li role = "presentation"><a href = "/technician-sale/date/{{ \Carbon\Carbon::now()->toDateString() }}/technician/Annie">
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <i class = "fa fa-plus fa-3x"></i>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-12">
                                        Add Sale
                                    </div>
                                </div>
                                 </a></li>
                        <li role = "presentation"><a href = "{{ route('payday') }}">
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <i class = "fa fa-dollar fa-3x"></i>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-12">
                                        Pay Day
                                    </div>
                                </div>
                            </a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-md-offset-3">
                    @component('panels.default')
                        @slot('title')
                            News
                        @endslot
                        @slot('body')
                            <ul>
                                <h3>Available Features</h3>
                                <li>Add, edit technician sales</li>
                                <li>Pay technician and generate pay reports</li>
                                <li> Create new technician book record</li>
                            </ul>
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>

@endsection
