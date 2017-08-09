@extends('layouts.main')
@section('pageTitle',$pageTitle)
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/vuetify.min.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/quick-sale-entry.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src = "{{ asset('js/salon/quick-sale-entry.js') }}"></script>
@endpush
@section('content')
    <div class = "main-content" id = "root">
        <quick-sale-entry></quick-sale-entry>
    </div>
@endsection