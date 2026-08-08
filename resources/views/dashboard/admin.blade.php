@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <h1>Dashboard Admin</h1>

    <p>
        Selamat datang, {{ Auth::user()->nama }}
    </p>

    <p>
        Role : {{ Auth::user()->role }}
    </p>

@endsection