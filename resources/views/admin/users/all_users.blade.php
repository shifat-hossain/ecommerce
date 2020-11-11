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
            <h4 class="card-title">Users List</h4>
            
            <div class="card-tools">
                <a href="{{url('users/create')}}" class="btn btn-info btn-sm" >
                    <i class="fas fa-plus-circle"></i> Add New User
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
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
    
</div>

<script>
    $('#example1').DataTable( {
        "processing": true,
            // DataTables server-side processing mode
        "serverSide": true,
        // Initial no order.
        "order": [],
        "ajax": {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "{{url("admin/user-list")}}",
            type : 'POST',
            'data': function(data){
             }
        },
        columns: [
            { data: 'sl' },
            { data: 'name' },
            { data: 'email' },
            { data: 'role_name' },
            { data: 'action' },
        ]
        
    });
</script>

@endsection


