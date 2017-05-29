@extends('layouts.main')
@section('pageTitle','Technician Book')
@push('styles')
<link rel = "stylesheet" href = "{{ asset('/css/technician-book.css')}}">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    @component('partials.header')
        <h1>Technician Book</h1>
        <p>Maintain technician sales and payments</p>
    @endcomponent
    <div class = "main-content">
        <div class = "container-fluid">
            <section class =  "row panels-container">
                <div class = "col-md-3">
                    @component('panels.orange')
                        @slot('title')
                            <div class = "row">
                                <div class = "col-md-4">
                                    <i class = "fa fa-pencil fa-5x"></i>
                                </div>
                                <div class = "col-md-6">
                                    <h1>Create</h1>
                                </div>
                            </div>
                        @endslot
                        @slot('body')
                            <a href = "/technician-book/create">View</a>
                        @endslot
                    @endcomponent
                </div>
            </section>
        </div>
    </div>
@endsection
