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
            <h4 class="card-title">Vendors Info</h4>            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="add_form" autocomplete="off">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="Type">Type</label>
                        <select class="form-control" name="vendor_type" id="type">
                            <option value="">Select Vendor Type</option>

                            @foreach($vendor_type_section as $key => $row)
                            <option value="{{$row->type_name}}">{{$row->type_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="CompanyName">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Name">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Name">Email</label>
                        <input type="text" class="form-control" name="vendor_email" id="vendor_email" placeholder="Email">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Phone">Phone</label>
                        <input id="vendor_phone" class="form-control" name="" type="tel">
                        <span id="valid-msg" class="hide">✓ Valid</span>
                        <span id="error-msg" class="hide"></span>
                        <!-- <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone"> -->
                    </div>

                    <!-- <div class="form-group col-md-6">
                        <label for="Mailbox">Mailbox</label>
                        <input type="text" class="form-control" name="mailbox" id="mailbox" placeholder="Mailbox">
                    </div> -->

                    <div class="form-group col-md-6">
                        <label for="Type">Country</label>
                        <select class="form-control" id="country" onchange="getStates(this.value)">
                            <option value="">Select Country</option>
                            @foreach($all_countries as $key => $value)
                            <option value="{{$value->id}} | {{$value->name}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="statesoption">Region</label>

                        <select class="form-control" id="statesoption">
                         <option value="">Select Region</option>
                        </select>
                    </div>

                    <!--Hiden Input-->
                    <input type="hidden" name="vendor_country_name" id="country_name">
                    <input type="hidden" name="vendor_country_id" id="country_id">
                    <input type="hidden" name="vendor_region_name" id="state_name">
                    <input type="hidden" name="vendor_region_id" id="state_id">
                    <!--Hiden Input-->

                    <div class="form-group col-md-6">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" name="vendor_password" id="vendor_password" placeholder="Password">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" id="vendor_confirm_password" placeholder="Confirm Password">
                    </div>

                    @foreach($all_vendor_custom_field as $key => $row)
  
                    <div class="form-group col-md-6">
                        <label for="{{$row->field_key}}">{{$row->field_label}}</label>
                        <input id="{{$row->field_key}}" class="form-control" name="{{$row->field_key}}">
                    </div>

                    @endforeach

                </div>

                <button type="button" id="add_btn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>   
</div>

<script>
    var  input = document.querySelector("#vendor_phone");
    var  errorMsg = document.querySelector("#error-msg");
    var  validMsg = document.querySelector("#valid-msg");
    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    var Iti =  window.intlTelInput(input, {
        initialCountry: "bd",
        separateDialCode: true,
        formatOnDisplay: true,
        hiddenInput: "vendor_phone",
        utilsScript: '<?php echo url('/');?>'+"/public/admin_asset/js/utils.js",
    });

    var reset = function() {
        var text = (Iti.isValidNumber()) ? Iti.getNumber() : "";
        $("[name=vendor_phone]").val(text);
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function() {
        reset();
        if (input.value.trim()) {
            if (Iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = Iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });

    input.addEventListener('keyup', reset);


    $("#add_btn").click(function (){
        
        $(".error_msg").html('');
        var data = new FormData($('#add_form')[0]);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url("admin/vendors")}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Save Successfully");
            window.location.href = "{{ url('admin/vendors')}}";
            // location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value){
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });

    // Get States by country

    function getStates(string)
    {
        var splitted = string.split('|');
        var id = splitted.shift();
        var country_name = splitted.join(',');
        $('#country_id').val(id);
        $('#country_name').val(country_name);
        $.ajax({
            url: "{{url('get-states')}}/" + id,
            success: function (response) {
                $('#statesoption').html(response);
            }
        });
    }

    $('#statesoption').change(function () {
        let state_value = $("select#statesoption option").filter(":selected").val();
        var splitted = state_value.split('|');
        var id = splitted.shift();
        var state_name = splitted.join(',');
        $('#state_id').val(id);
        $('#state_name').val(state_name);
    });
</script>


@endsection


