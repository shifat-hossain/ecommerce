@extends('layouts.master')

@section('content')

<style>
    span.select2.select2-container.select2-container--default{
        width: 450px !important;
    }
    .hide{
        display: none;
    }
    #valid-msg{
        color: green;
    }
    #error-msg{
        color: red;
    }
</style>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Custom Field</h4>
            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="edit_form" autocomplete="off">
                <div class="form-row">
                    @method('PUT')
                    <input type="hidden" id="id" class="form-control" name="id" value="{{$custom_field->id}}">
                    <div class="form-group col-md-6">
                        <label for="field_section">Field Section</label>
                        <select class="form-control" name="field_section" id="field_section">
                            <option value="">Select Field Section</option>
                            <option <?php  if($custom_field->field_section == 'clients'){ echo "selected";} ?> value="clients">Client</option>
                            <option <?php  if($custom_field->field_section == 'vendors'){ echo "selected";} ?> value="vendors">Vendor</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_type">Field Type</label>
                        <select class="form-control" name="field_type" id="field_type">
                            <option value="">Select Field Type</option>

                            <!-- <option <?php  if($custom_field->field_type == 'email'){ echo "selected";} ?> value="email">Email</option> -->

                            <option <?php  if($custom_field->field_type == 'text'){ echo "selected";} ?> value="text">Text</option>
                            
                            <!-- <option <?php  if($custom_field->field_type == 'tel'){ echo "selected";} ?> value="tel">Tel</option> -->
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_key">Column Name</label>
                        <input placeholder="Enter Default Value" id="field_key" class="form-control" name="field_key" value="{{$custom_field->field_key}}" type="text">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_label">Field Label</label>
                        <input placeholder="Enter Field Label" id="field_label" class="form-control" name="field_label" value="{{$custom_field->field_label}}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_validation">Field Validation</label>
                        <select class="form-control" name="field_validation" id="field_validation">
                            <option value="">Select Field Validation</option>
                            <option <?php  if($custom_field->field_validation == 'optional'){ echo "selected";} ?> value="optional">Optional</option>
                            <option <?php  if($custom_field->field_validation == 'required'){ echo "selected";} ?> value="required">Required</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_default_value">Field Default Value</label>
                        <input placeholder="Enter Default Value" id="field_default_value" class="form-control" name="field_default_value" value="{{$custom_field->field_default_value}}" type="text">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_in_list">Field In List</label>
                        <select class="form-control" name="field_in_list" id="field_in_list">
                            <option value="">Select</option>
                            <option <?php  if($custom_field->field_in_list == 'YES'){ echo "selected";} ?> value="YES">YES</option>
                            <option <?php  if($custom_field->field_in_list == 'NO'){ echo "selected";} ?> value="NO">NO</option>
                        </select>
                    </div>


                </div>

                <button type="button" id="edit_btn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
    
</div>

<script>


    $("#edit_btn").click(function (){
        
        $(".error_msg").html('');
        var url = "{{url("admin/custom-fields")}}";
        var id = $('[name=id]').val();
        var data = new FormData($('#edit_form')[0]);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: url + '/' + id,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Save Successfully");
            window.location.href = "{{ url('admin/custom-fields')}}";
            // window.location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value){
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
  </script>


@endsection
