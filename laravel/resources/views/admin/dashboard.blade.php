@extends('layouts.admin')

@section('title', 'Dashboard — Seav.ai Admin')
@section('page-title', 'Dashboard')
@section('page-meta', 'Platform overview')

@php $pageTitle = 'Dashboard'; $pageMeta = 'Platform overview'; @endphp

@section('content')
@include('admin.partials.dashboard-content')
@endsection
