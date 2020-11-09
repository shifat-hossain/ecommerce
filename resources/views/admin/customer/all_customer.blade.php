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
            <h4 class="card-title">Customer List</h4>

            @if(Auth::user()->can('add-customer'))
            <div class="card-tools">
                <a href="{{url('customers/create')}}" class="btn  btn-info btn-sm" >
                    <i class="fas fa-plus-circle"></i> Add New Customer
                </a>
            </div>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>First Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Region</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    
</div>
<script type="text/javascript">

    $(document).on('click','.client_status',function(){
        var url = "{{url("change-customer-status")}}";
        var id = $(this).data("id");        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: url + '/' + id,
            data: id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            //window.location.href = "{{ url('customers')}}";
            // window.location.reload();
        });

        if ($("#active_status_"+id).text() == 'ACTIVE') {
            $("#active_status_"+id).text('INACTIVE');
        }else if($("#active_status_"+id).text() == 'INACTIVE'){
            $("#active_status_"+id).text('ACTIVE');
        } 
    });
</script>
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
            url : "{{url("customer-list")}}",
            type : 'POST',
            'data': function(data){
             }
        },
        columns: [
            { data: 'sl' },
            { data: 'client_name' },
            { data: 'client_phone' },
            { data: 'client_email' },
            { data: 'country_name' },
            { data: 'state_name' },
            { data: 'client_status' },
            { data: 'action' },
        ]
        
    });
</script>

@endsection


