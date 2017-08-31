@extends('layouts.main')
@section('pageTitle','Wage Report')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/vuetify.min.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/technician-wage.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/wages/wage-report.js') }}"></script>
@endpush
@include('partials.main-navbar')
@section('content')

    <div class = "main-content" id = "root">
        <wage-report-app></wage-report-app>
    </div>

@endsection

