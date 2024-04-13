@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Class</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('classes/list') }}">Class List</a></li>
                                <li class="breadcrumb-item active">Edit Class</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form action="{{ route('classes/update') }}" method="POST">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{ $classesEdit->id }}">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Class Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Class Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $classesEdit->name }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Quantity of Students <span class="login-danger">*</span></label>
                                            <input type="number" class="form-control @error('quantityStudent') is-invalid @enderror" name="quantityStudent" value="{{ $classesEdit->quantityStudent }}">
                                            @error('quantityStudent')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Start Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control @error('startDate') is-invalid @enderror" name="startDate" value="{{ $classesEdit->startDate }}">
                                            @error('startDate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
