@extends('layouts.main')
@section('pageTitle','Create Book')
@push('styles')
<link rel = "stylesheet" href = "/css/technician-book-create.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    @component('partials.header')
        <h1>Create</h1>
        <p>Create new technicians book record</p>
    @endcomponent
    <div class = "main-content">
        <div class = "container-fluid">
            <div class = "row">
                <div class = "col-md-4 col-md-offset-4 form-container">
                        <div class = "col-md-6 form">
                            @component('forms.create-technician-book', ['technicians' => $technicians])
                            @endcomponent
                        </div>
                        <div class = "col-md-6 message">
                            @if(Session::has('message'))
                                @component('alert.alert-success')
                                    @slot('message')
                                        {{ Session::get('message') }}
                                    @endslot
                                @endcomponent
                                @elseif(Session::has('error'))
                                @component('alert.alert-danger')
                                    @slot('message')
                                        {{ Session::get('error') }}
                                    @endslot
                                @endcomponent

                            @endif

                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection