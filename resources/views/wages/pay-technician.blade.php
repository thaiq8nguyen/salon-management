@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "/css/pay-technician.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    @if(Session::has('confirm-pay'))
        <header class = "page-heading">
            <div class = "container-fluid">
                <p>{{ Session::get('confirm-pay') }}</p>
            </div>
        </header>
    @endif
    <section class = "tech-name">
        <div class = "container-fluid">
            <h1>Annie Le</h1>
            <hr>
        </div>
    </section>
    <section class = "sales-container">
        <div class = "container-fluid">
            <div class = "row">
                <div class = "col-md-4">
                    <div class = "panel panel-default">
                        <div class = "panel-body">
                            <table class = "table">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Sales</th>
                                    <th>Tips</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class = "pay-container">

    </div>
@endsection