@extends('layouts.main')
@section('pageTitle','Technician Home')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/vuetify.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src = "{{ asset('js/technicians/technician.js')}}"></script>
@endpush
@section('content')
    <div class = 'main-content' id = "root">

        <technician></technician>

    </div>
@endsection
