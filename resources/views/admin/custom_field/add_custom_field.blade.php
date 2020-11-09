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
            <form id="add_form" autocomplete="off">
                <div class="form-row">
                    
                    <div class="form-group col-md-6">
                        <label for="field_section">Field Section</label>
                        <select class="form-control" name="field_section" id="field_section">
                            <option value="">Select Field Section</option>
                            <option value="customers">Customer</option>
                            <option value="vendors">Vendor</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_type">Field Type</label>
                        <select class="form-control" name="field_type" id="field_type">
                            <option value="">Select Field Type</option>
                            <!-- <option value="email">Email</option> -->
                            <option value="text">Text</option>
                            <!-- <option value="tel">Tel</option> -->
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_key">Column Name</label>
                        <input placeholder="Enter Default Value" id="field_key" class="form-control" name="field_key" type="text">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_label">Field Label</label>
                        <input placeholder="Enter Field Label" id="field_label" class="form-control" name="field_label">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_validation">Field Validation</label>
                        <select class="form-control" name="field_validation" id="field_validation">
                            <option value="">Select Field Validation</option>
                            <option value="optional">Optional</option>
                            <option value="required">Required</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_default_value">Field Default Value</label>
                        <input placeholder="Enter Default Value" id="field_default_value" class="form-control" name="field_default_value" type="text">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="field_in_list">Field In List</label>
                        <select class="form-control" name="field_in_list" id="field_in_list">
                            <option value="">Select</option>
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                </div>

                <button type="button" id="add_btn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
    
</div>

<script>


    $("#add_btn").click(function (){
        
        $(".error_msg").html('');
        var data = new FormData($('#add_form')[0]);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url("custom-fields")}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Save Successfully");
            window.location.href = "{{ url('custom-fields')}}";
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


