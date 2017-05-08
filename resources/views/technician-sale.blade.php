@extends('layouts.main')
@section('content')
    <h1>Technician Sale Entry</h1>
    <ul>
        @foreach($technicians as $technician)
            <li>{{ $technician->first_name }}</li>
        @endforeach
    </ul>
@endsection