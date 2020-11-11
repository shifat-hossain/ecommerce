@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Unit</h4>

            <div class="card-tools">
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_modal" > <i class="fas fa-plus-circle"></i> Add New Unit</button>

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php // echo '<pre>';print_r($all_category);?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Unit Name</th>
                        <th>Unit Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_units as $row)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $row->unit_name }}
                        </td>
                        <td>
                            {{ $row->unit_code }}
                        </td>
                        <td>
                            <button onclick="fadeEditModal('{{$row->id}}')" style="margin-right: 5px" class="btn btn-success btn-sm float-left view_modal" >
                                Edit
                            </button> 
                            <form method="post" action="{{url('admin/units/'.$row->id)}}">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you want to delete this!')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_modal_label">Add Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_form">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <h4 id="success_msg" style="color: green;font-weight: 600;"></h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Unit Name</label>
                            <input type="text" class="form-control" name="unit_name" id="unit_name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Unit Code</label>
                            <input type="text" class="form-control" name="unit_code" id="unit_code" placeholder="Enter Code">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="add_btn" class="btn btn-primary">Add unit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- edit_modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal_label">Edit Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit_form">
                    @csrf
                    @method('POST')
                    <div class="modal-body" id="edit_modal_body">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="update_unit" class="btn btn-primary">Update unit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    $("#add_btn").click(function () {
        $(".error_msg").html('');
        var data = $('#add_form').serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "units",
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $("#success_msg").html("Data Save Successfully");
            location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });

    function fadeEditModal(id)
    {

//        $('#edit_modal').modal('show');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url("admin/units/")}}/' + id + '/edit',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
//                $('#edit_modal_body').html(response.responseText);
            }

        }).done(function (data, textStatus, jqXHR) {
//            alert();
            console.log(data);

        }).fail(function (data, textStatus, jqXHR) {
//            console.log(data.responseText);
            $('#edit_modal_body').html(data.responseText);
            $('#edit_modal').modal('show');
        });

    }

    $("#update_unit").click(function () {
        $(".error_msg").html('');
        var data = $('#edit_form').serialize();
//        let attributeName = $('#attribute_group_name').val();
        let id = $('#unit_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "PUT",
            url: "{{url('admin/units')}}/" + id,
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $(".success_msg").html("Data Save Successfully");
            location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#edit_" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });

    });



</script>
@endsection


