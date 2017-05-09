@extends('layouts.main')
@section('content')
    <h1>Technician Sale Entry</h1>
    @if(Session::has('confirm-sale'))
        <p class = "bg-success">{{ Session::get('confirm-sale') }}</p>
    @endif
    <ul>
        @foreach($technicians as $technician)
            <li>{{ $technician->first_name }}<a href = "create/{{ $technician->first_name }}">Add Sale</a></li>
        @endforeach
    </ul>
@endsection