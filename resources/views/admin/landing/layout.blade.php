@extends('layouts.app')

@section('title', 'iSTOCK Demo Sale')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/landing/intro.css') }}">
@endpush

@section('content')
<div class="demo-wrapper">
    @yield('landing-content')
</div>
@endsection