@extends('layouts.master')

@section('content')

<style>
    span.select2.select2-container.select2-container--default {
        width: 450px !important;
    }
    .hide {
        display: none;
    }
    #valid-msg {
        color: green;
    }
    #error-msg {
        color: red;
    }
</style>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Category</h4>           
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="add_form" autocomplete="off">
                
                 <div class="alert alert-success" id="success_msg" role="alert" style="display: none;"></div>
                
                <div class="form-row">
                    @csrf
                    @method('POST')

                    <div class="form-group col-md-6">
                        <label for="category_name">Category Name</label>
                        <input type="text" onkeyup="makeSlug(this.value)" class="form-control" name="category_name" id="category_name" placeholder="Category Name">
                        
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">Parent Category</label>
                        <select class="form-control" name="parent_id" id="">
                            <option value="">Select Category</option>
                            @foreach($all_category as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->category_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Slug">Slug</label>
                        <input type="text" class="form-control" name="category_slug" id="category_slug" placeholder="Slug">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="category_cover_image">Cover Image</label>
                        <input type="file" id="category_cover_image" name="category_cover_image" class="form-control" >
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="category_menu_image">Menu Image</label>
                        <input type="file" id="category_menu_image" name="category_menu_image" class="form-control" >
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="category_meta_title">Meta Title</label>
                        <input type="text" class="form-control" name="category_meta_title" id="category_meta_title" placeholder="Meta title">
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="category_meta_description">Meta Description</label>
                        <input type="text" class="form-control" name="category_meta_description" id="category_meta_description" placeholder="Meta Description">
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="category_meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" name="category_meta_keywords" id="category_meta_keywords" placeholder="Meta Keywords">
                    </div>
                    
                </div>
                
                <div class="form-group col-md-12">
                    <label for="client_phone">Description</label>
                    <textarea class="form-control" name="category_description" id="category_description" rows="5" placeholder="Category Description"></textarea>
                </div>
                
                <button type="button" id="add_btn" class="btn btn-primary">Submit</button>
                
            </form>
        </div>
    </div>
</div>

<script>
    function makeSlug(val)
    {
        let str = val;
        let output = str.replace(/\s+/g, '-').toLowerCase();
        $('#category_slug').val(output);
    }
    
    $("#add_btn").click(function () {
        $(".error_msg").html('');
        var data = new FormData($('#add_form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url("admin/categories")}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function (data) {
            var json_data = JSON.parse(data);
            if(json_data.status == 'Success') {
                $("#success_msg").html("Data Save Successfully");
                $("#success_msg").show();
                window.location.href = "{{ url('admin/categories')}}";
            }
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    })
</script>


@endsection


