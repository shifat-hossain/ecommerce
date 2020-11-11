@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Attribute Detail > 
                {{ $all_attributes[0]->attribute_group_name }}
                <span class="badge badge-pill badge-dark">
                    {{ count($all_attributes[0]['attributes']) }}
                </span>
            </h4>

            <div class="card-tools">
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_attribute_value" >
                    <i class="fas fa-plus-circle"></i>  Add Attribute Value
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>                     
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_attributes[0]['attributes'] as $row)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $row->attribute_name }}
                        </td>

                        <td>
                            <a  onclick="fadeEditModal('{{$row->id}}')" class="btn btn-success btn-sm mr-2 float-left text-white">
                                Edit
                            </a> 

                            <form method="post" action="{{url('admin/delete-attribute/'.$row->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
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
                            <select class="form-control" name="attribute_group_id" id="attribute_group_id"  onchange="getAttributeGroup()">
                                <!--                                <option value="">Select Attribute</option>-->
                                @foreach($all_attributes_group as $row)
                                <option value="{{ $row->id }}" @if($row->id == $all_attributes[0]->id) selected @endif>
                                        {{ $row->attribute_group_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Attribute Value</label>
                        <input type="text" class="form-control" name="attribute_value" id="attribute_value" placeholder="Enter Value">
                    </div>
                    <!--                        <div class="form-group" id="color_div" style="display: none">
                                                <label for="exampleInputEmail1">Color Code</label>
                                                <input type="color" class="form-control" name="color_code" id="color_code" placeholder="Enter color code">
                                            </div>-->
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
                <h5 class="modal-title" id="edit_modal_label">Edit Value</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_attribute_form">
                @method('POST')

                <div class="modal-body" id="edit_modal_body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="update_attribute" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $("#add_val_btn").click(function () {
        $(".error_msg").html('');
        var data = $('#add_val_form').serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{ url('admin/attributes') }}",
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
    });

    $("#attribute_group_id").change(function () {
        if ($.trim($("#attribute_group_id option:selected").text()) == 'Color') {
            $("#color_div").show();
        }
    });
</script>
<script>
    function fadeEditModal(id)
    {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url("admin/attributes/")}}/' + id + '/edit',
            method: 'GET',
            dataType: 'json',
            success: function () {

//                $('#value_of_attribute').val(response.attribute_name);
//                $('#attribute_id').val(response.id);                
//                $('#attribute_color_code').val(response.color_code);
            }
        }).done(function (data, textStatus, jqXHR) {
            alert();
            console.log(data);

        }).fail(function (data, textStatus, jqXHR) {
            console.log(data.responseText);
            $('#edit_modal_body').html(data.responseText);
            $('#edit_modal').modal('show');
        });
        ;
    }

    $("#update_attribute").click(function () {
        $(".error_msg").html('');
        var data = $('#update_attribute_form').serialize();
        let attributeName = $('#edit_attribute_value').val();
//        let attribute_color_code = $('#attribute_color_code').val();
        let id = $('#edit_attribute_id').val();
        if (attributeName !== '')
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{url('admin/attributes-update')}}/" + id,
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
        } else {
            alert('Please fill out inputs');
        }
    });
    function changecolorValue(val)
    {
        $('#update_color_code').val(val);
    }

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
    let textp = $("#attribute_group_id option:selected").text();
    let  trimmedTextp = textp.trim();
    if (trimmedTextp === 'Color')
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


</script>
@endsection


