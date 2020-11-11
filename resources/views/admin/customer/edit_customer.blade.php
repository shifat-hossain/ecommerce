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
            <h4 class="card-title">Edit Customer Info</h4>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="edit_form" autocomplete="off">
                <div class="form-row">

                    @method('PUT')

                    <!--                    <div class="form-group col-md-6">
                                            <label for="Type">Type</label>
                                            <select class="form-control" name="customer_type" id="type">
                                                <option value="">Select Customer Type</option>
                    
                                                @foreach($customer_type_section as $key => $value)
                                                <option value="{{$value->type_name}}" @if($value->type_name == $customer_info->customer_type) selected @endif>{{$value->type_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>-->

                    <div class="form-group col-md-6">
                        <label for="customer_first_name">First Name</label>
                        <input type="text" class="form-control" name="customer_first_name" value="{{$customer_info->customer_first_name}}" id="customer_first_name" placeholder="Customer Name">
                        <input type="hidden" class="form-control" name="id" value="{{$customer_info->id}}" id="id" placeholder="Customer Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customer_last_name">Last Name</label>
                        <input type="text" class="form-control" name="customer_last_name" id="customer_last_name" value="{{$customer_info->customer_last_name}}" placeholder="Customer Name">
                    </div>



                    <div class="form-group col-md-6">
                        <label for="Name">Email</label>
                        <input type="text" class="form-control" value="{{$customer_info->customer_email}}" name="customer_email" id="customer_email" placeholder="Email">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" value="{{$customer_info->customer_phone}}" class="form-control" name="customer_phone" type="tel">
                        <span id="valid-msg" class="hide">✓ Valid</span>
                        <span id="error-msg" class="hide"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Type">Country</label>
                        <select class="form-control" id="country" name="country" onchange="getStates(this.value)">
                            <option value="">Select Country</option>

                            @foreach($all_countries as $key => $value)
                            <option value="{{$value->id}} | {{$value->name}}" @if($value->id == $customer_info->country_id)selected @endif>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Type">Region</label>
                        <select class="form-control" name="state" id="statesoption" >
                            @foreach($all_states as $key => $value)
                            <option value="{{$value->id}} | {{$value->name}}" @if($value->id == $customer_info->state_id)selected @endif>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_postal_code">Postal Code</label>
                        <input id="customer_postal_code" value="{{$customer_info->customer_postal_code}}" class="form-control" name="customer_postal_code">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customer_code">Code</label>                     
                        <input type="text" class="form-control" value="{{$customer_info->customer_code}}" name="customer_code" id="customer_code" value="#customer-code123" placeholder="Customer Name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="customer_address">Address</label>
                        <textarea class="form-control" name="customer_address" id="customer_address" rows="3" placeholder="Enter ...">{{$customer_info->customer_address}}</textarea>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input id="password" class="form-control" name="password">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" class="form-control" name="confirm_password">
                    </div>
                    <?php
                    $arry = $customer_info->toArray();
                    ?>
                    @foreach($all_customer_custom_field as $key => $row)

                    <div class="form-group col-md-6">
                        <label for="{{$row->field_key}}">{{$row->field_label}}</label>
                        <input id="{{$row->field_key}}" class="form-control" name="{{$row->field_key}}" value="{{$arry[$row->field_key]}}">
                    </div>

                    @endforeach

                </div>
                 <!--Hiden Input-->
                    <input type="hidden" name="country_name" id="country_name" value="{{$customer_info->country_name}}">
                    <input type="hidden" name="country_id" id="country_id" value="{{$customer_info->country_id}}">
                    <input type="hidden" name="state_name" id="state_name" value="{{$customer_info->state_name}}">
                    <input type="hidden" name="state_id" id="state_id" value="{{$customer_info->state_id}}">
                    <!--Hiden Input-->

                <button type="button" id="edit_btn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>


</div>

<script>
    var input = document.querySelector("#customer_phone");
    var errorMsg = document.querySelector("#error-msg");
    var validMsg = document.querySelector("#valid-msg");
    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    var Iti = window.intlTelInput(input, {
        initialCountry: "bd",
        utilsScript: '<?php echo url('/'); ?>' + "/public/admin_asset/js/utils.js",
    });

    var reset = function () {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function () {
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


    $("#edit_btn").click(function () {

        var url = "{{url("admin/customers")}}"
        var id = $('[name=id]').val();
        $(".error_msg").html('');
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
        }).done(function () {
            $("#success_msg").html("Data Save Successfully");
            window.location.href = "{{ url('admin/customers')}}";
            //window.location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });


    //    Get States by country

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

</script>


@endsection


