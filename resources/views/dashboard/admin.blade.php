@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <h1>Dashboard Admin</h1>

    <p style="margin-top: 10px;">
        Selamat datang, {{ Auth::user()->nama }}
    </p>

    <p style="margin-top: 5px;">
        Role : {{ Auth::user()->role }}
    </p>

@endsection