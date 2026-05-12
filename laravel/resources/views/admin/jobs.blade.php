@extends('layouts.admin')

@section('title', 'Job Listings — Seav.ai Admin')
@section('page-title', 'Job Listings')
@section('page-meta', 'Manage all indexed jobs')

@php $pageTitle = 'Job Listings'; $pageMeta = 'Manage all indexed jobs'; @endphp

@section('content')
@include('admin.partials.jobs-content')
@endsection
