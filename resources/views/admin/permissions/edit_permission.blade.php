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
            <h4 class="card-title">Edit Permissions Info</h4>
            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            
            <div class="alert alert-success" id="success_msg" role="alert" style="display: none;"></div>
            
            <form id="add_form">
                
                @method('PUT')
                <input type="hidden" name="id" value="{{ $permission_data->id }}">
                
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="Name">
                            Permission Section
                        </label>
                        <input type="text" class="form-control" name="section_name" id="section_name" value="{{ $permission_data->section_name }}" placeholder="Permission Section">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Name">
                            Permission Name
                        </label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $permission_data->name }}" placeholder="Permission Name">
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
            url: "{{url("admin/permissions")}}/"+ $("[name=id]").val(),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Update Successfully");
            $("#success_msg").show();
            setInterval(function() {
                window.location.href = "{{ url('admin/permissions')}}";
            }, 2000);
            
            // location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value){
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
  </script>


@endsection


