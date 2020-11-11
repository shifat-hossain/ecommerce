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
            <h4 class="card-title">Permissions List</h4>
            
            <div class="card-tools">
                <a href="{{url('admin/permissions/create')}}" class="btn btn-info btn-sm" >
                    <i class="fas fa-plus-circle"></i> Add New Permission
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Section</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_permissions as $row)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $row->section_name }}
                            </td>

                            <td>
                                {{ $row->name }}
                            </td>
                            
                            <td>
                                <a href="{{url('admin/permissions')}}/{{ $row->id }}/edit" class="btn btn-success btn-sm">
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

<script>
    $("#example1").DataTable();
</script>

@endsection


