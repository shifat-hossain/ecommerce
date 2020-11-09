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
            <h4 class="card-title">Add Brand</h4>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="add_form" enctype="multipart/form-data">
                @method('PUT')
                <div class="form-row">                 
                    <!--<h4 id="success_msg" style="color: green;font-weight: 600;"></h4>-->
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Brand Name</label>
                        <input type="text" class="form-control" value="{{$brands->brand_name}}" name="brand_name" id="brand_name" placeholder="Enter Name">
                        <input type="hidden" id="brand_id" value="{{$brands->id}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">Brand Image</label>
                        <input type="file" class="form-control" name="brand_image" id="brand_image">
                    </div>  
                </div>

                <button type="submit" id="add_btn" class="btn btn-primary">Submit</button>
            </form>
            <h3 id="success_msg"></h3>
        </div>
    </div>


</div>

<script>

    $("#add_form").on('submit', function (e) {
        e.preventDefault();
        $(".error_msg").html('');
//        var data = new FormData($('#add_form')[0]);
//        var data = $('#add_form').serialize();
//        alert(data['brand_name']);
//        
        let brand_id = $('#brand_id').val();
//         alert(data);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url('brands/')}}/" + brand_id + "",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
            window.location.href = "{{ url('brands')}}";
            }
        }).done(function () {
            $("#success_msg").html("Data Updated Successfully");
//            setTimeout(function(){  }, 3000);
             window.location.href = "{{ url('brands')}}";
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
