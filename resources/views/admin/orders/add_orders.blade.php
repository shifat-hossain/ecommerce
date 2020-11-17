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
            <h4 class="card-title">Add Order</h4>           
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="add_form" autocomplete="off">
                <div class="form-row">

                    <div class="from-group col-md-6">
                        <select id="customer_id" name="customer_id" class="form-control">
                            <option value=""> Select Customer</option>

                            @foreach($all_customer as $customer)
                            <option value="{{$customer->id}}"> {{ $customer->customer_first_name.' '.$customer->customer_last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <select id="product_id" name="product_id" class="form-control">
                            <option value=""> Select Product</option>

                            @foreach($all_product as $product)
                            <option value="{{$product->id}}"> {{ $product->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    
                </div>

                <button type="button" id="add_btn" class="btn btn-primary">Submit</button>
            </form>
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
            url: "{{ url('admin/orders') }}",
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $("#success_msg").html("Data Save Successfully");
            // location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
</script>


@endsection


