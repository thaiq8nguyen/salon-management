@extends('layouts.main')
@section('pageTitle', 'API Dashboard')
@push('scripts')
<script src = "{{ asset('js/api-dashboard.js') }}"></script>
@endpush
@section('content')
    <div class = "main-content" id = "root">
        <div class = "container-fluid">
            <div class = "row" style = "margin-top: 25px;">
                <div class = "col-md-6 col-md-offset-3">
                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <personal-access-tokens></personal-access-tokens>
                </div>
            </div>
        </div>
    </div>
@endsection