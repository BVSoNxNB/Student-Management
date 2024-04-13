@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Classes</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">All classes</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="student-group-form">
                <!-- Search form -->
                <form class="row">
                    <div class="col-lg-3 col-md-6">
                        <input type="text" class="form-control" placeholder="Search by ID ...">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <input type="text" class="form-control" placeholder="Search by Name ...">
                    </div>
                    <div class="col-lg-2">
                        <button type="btn" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Classes</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('classes/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Class</a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Quantity of Students</th>
                                            <th>Start Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classList as $class)
                                        <tr>
                                            <td>{{ $class->id }}</td>
                                            <td>{{ $class->name }}</td>
                                            <td>{{ $class->quantityStudent }}</td>
                                            <td>{{ $class->startDate }}</td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                <button onclick="location.href='{{ url('classes/edit/' . $class->id) }}'" class="btn btn-sm bg-danger-light">
        <i class="feather-edit"></i> Edit
      </button>                                                    <!--  -->
                                                </div>
                                                <form id="deleteForm" action="{{ route('classes.delete') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $class->id }}">
    <button type="submit">Delete</button>
</form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection