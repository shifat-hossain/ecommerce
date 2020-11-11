@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Attribute</h4>
            
            @if(Auth::user()->can('add-attribute'))
            <div class="card-tools">
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_modal" >
                   <i class="fas fa-plus-circle"></i> Add Attribute
                </button> 
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_attribute_value" >
                   <i class="fas fa-plus-circle"></i> Add Attribute Value
                </button>
            </div>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Values</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_attributes as $row)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $row->attribute_group_name }}
                        </td>
                        <td>
                            {{ count($row->attributes) }}
                        </td>
                        <td>

                            @if(Auth::user()->can('view-attribute'))
                            <a href="{{url('admin/attributes/'.$row->id)}}"  class="btn btn-primary btn-sm mr-2 float-left">
                                View
                            </a> 
                            @endif
                            
                            @if(Auth::user()->can('edit-attribute'))
                            <a  class="btn btn-success btn-sm mr-2 float-left text-white"  onclick="fadeEditModal('{{$row->id}}')" >
                                Edit
                            </a> 
                            @endif

                            @if(Auth::user()->can('delete-attribute'))
                            <form method="post" action="{{url('admin/attributes/'.$row->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm float-left">Delete</button>
                            </form>
                            @endif
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
                    <h5 class="modal-title" id="add_modal_label">Add Attribute Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_form">
                    <input type="hidden" name="attribute_type" value="attribute_group">
                    <div class="modal-body">
                        <h5 class="success_msg" style="color: green;font-weight: 600;"></h5>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Attribute Name</label>
                            <input type="text" class="form-control" name="attribute_group_name" id="add_attribute_group_name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="add_btn" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_attribute_value" tabindex="-1" role="dialog" aria-labelledby="add_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_modal_label">Add Attribute Value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_val_form">
                    <input type="hidden" name="attribute_type" value="attribute_value">
                    <div class="modal-body">
                        <h5 class="success_msg" style="color: green;font-weight: 600;"></h5>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Attribute Name</label>
                            <select class="form-control" name="attribute_group_id" id="attribute_group_id" onchange="getAttributeGroup()">
                                <option value="">Select Attribute</option>
                                @foreach($all_attributes as $row)
                                <option value="{{ $row->id }}">
                                    {{ $row->attribute_group_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Attribute Value</label>
                            <input type="text" class="form-control" name="attribute_name" id="attribute_name" placeholder="Enter Name">
                        </div>
                        <div class="form-group" style="display: none" id="showColor">
                            <label for="exampleInputEmail1">Select Color</label><br>       
                            <input id="getcolorValue"  readonly>
                            <input onchange="changecolorValue(this.value)"  type="color" value="" id="color_code" name="color_code">                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="add_val_btn" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal_label">Edit Attribute</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update_attribute_group_form">
                    @method('PUT')
                    <input type="hidden" name="attribute_id" id="attribute_id">
                    <div class="modal-body">
                        <h5 class="success_msg" style="color: green;font-weight: 600;"></h5>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Attribute Name</label>
                            <input type="text" class="form-control" name="attribute_group_name" id="attribute_group_name" placeholder="Enter Name">
                            <input type="hidden" class="form-control" name="attribute_type" id="attribute_type" value="attribute_group" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="update_attribute_group" class="btn btn-primary">Save changes</button>
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
            url: "attributes",
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $(".success_msg").html("Data Save Successfully");
            location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#add_" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });

    $("#add_val_btn").click(function () {
        $(".error_msg").html('');
        var data = $('#add_val_form').serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "attributes",
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $(".success_msg").html("Data Save Successfully");
             location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    })
</script>
<script>
    function fadeEditModal(id)
    {
        $('#edit_modal').modal('show');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url("fetch-attribute-group/")}}/' + id,
            method: 'post',
            dataType: 'json',
            success: function (response) {
                $('#attribute_group_name').val(response.attribute_group_name);
                $('#attribute_id').val(response.id);
            },
            error: function () {
                alert('Something went wrong! Try again')
            }
        });
    }

    $("#update_attribute_group").click(function () {
        $(".error_msg").html('');
        var data = $('#update_attribute_group_form').serialize();
        let attributeName = $('#attribute_group_name').val();
        let id = $('#attribute_id').val();
        if (attributeName !== '')
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "PUT",
                url: "{{url('admin/attributes')}}/" + id,
                data: data,
                success: function (data, textStatus, jqXHR) {

                }
            }).done(function () {
                $(".success_msg").html("Data Save Successfully");
                location.reload();
            }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value){
                $("#"+ key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
        } else {
            alert('Please fill out inputs');
        }
    });


    function getAttributeGroup()
    {
//        var text= $('#attribute_group_id').find(":selected").text();
        let text = $("#attribute_group_id option:selected").text();
        let  trimmedText = text.trim();
        if (trimmedText === 'Color')
        {
            $('#showColor').show();
            $('#getcolorValue').show();
        } else
        {
            $('#showColor').hide();
            $('#getcolorValue').hide();
            $('#getcolorValue').val('');
            $('#color_code').val('');
        }
    }
    function changecolorValue(val)
    {
        $('#getcolorValue').val(val);
    }

</script>
@endsection


