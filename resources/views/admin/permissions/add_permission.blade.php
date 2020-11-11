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
            <h4 class="card-title">Permissions Info</h4>
            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            
            <div class="alert alert-success" id="success_msg" role="alert" style="display: none;"></div>
            
            <form id="add_form">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="Name">
                            Permission Section
                        </label>
                        <input type="text" class="form-control" name="section_name" id="section_name" placeholder="Permission Section">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Name">
                            Permission Name  <span class="add" style="color: green;cursor: pointer;">[Add New Permission]</span>
                        </label>
                        <div class="optionBox">
                            <div class="block">
                                <input type="text" class="form-control" name="name[]" id="name.0" placeholder="Permission Name">
                            </div>
                        </div>
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
            url: "{{url("admin/permissions")}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Save Successfully");
            $("#success_msg").show();
            setInterval(function() {
                window.location.href = "{{ url('admin/permissions')}}";
            }, 2000);
            // location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value){
                console.log(key);
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
    
    
    var id = 1;
    $('.add').click(function () {
        id++;
//        alert(id);
        $('.block:last').after('<div class="block" style="text-align: left;">\
                                    <input type="text" class="form-control" name="name[]" id="name.'+ id +'" placeholder="Permission Name" style="width: 90%;float: left;margin: 10px 15px 0 auto;">\
                                    <span class="remove btn btn-danger" style="margin: 10px 0;">X</span>\
                                </div>');
    
    });
    
    $('.optionBox').on('click', '.remove', function () {
        $(this).parent().remove();
    });
</script>


@endsection


