@extends('layouts.master')

@section('content')

<style>
    span.select2.select2-container.select2-container--default{
        width: 450px !important;
    }
</style>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Roles List</h4>
            
            <div class="card-tools">
                <a href="{{url('admin/roles/create')}}" class="btn btn-info btn-sm" >
                    <i class="fas fa-plus-circle"></i> Add New Role
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_roles as $row)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $row->name }}
                            </td>

                            <td>
                                {{ $row->slug }}
                            </td>
                            
                            <td>
                                <a class="btn btn-success btn-sm" href="{{url('admin/roles')}}/{{ $row->id }}/edit">
                                    Edit
                                </a>
                                <a class="btn btn-danger btn-sm text-white">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>


@endsection


