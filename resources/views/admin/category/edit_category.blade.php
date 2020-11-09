

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
            <h4 class="card-title">Edit {{$category_data->category_name}} Category</h4>           
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="edit_form" autocomplete="off" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    @csrf
                    @method('PUT')

                    <div class="form-group col-md-6">
                        <label for="category_name">Category Name</label>
                        <input type="text" onkeyup="makeSlug(this.value)" class="form-control" name="category_name" id="category_name" value="{{$category_data->category_name}}"  placeholder="Category Name">
                        <!--<input type="text" class="form-control" name="category_name" id="category_name" value="{{$category_data->category_name}}" placeholder="Enter Name">-->
                        <input type="hidden" value="{{$category_data->id}}" id="category_id">
                        @error('category_name')
                        <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">Parent Category</label>
                        <select class="form-control" name="parent_id" id="">
                            <option value="">Select Category</option>
                            @foreach($all_category as $row)
                            <option value="{{ $row->id }}" @if($row->id == $category_data->parent_id) selected @endif>
                                    {{ $row->category_name }}
                        </option>
                        @endforeach
                    </select>
                </div>               


                <div class="form-group col-md-6">
                    <label for="Slug">Slug</label>
                    <input type="text"  value="{{$category_data->slug}}" class="form-control" name="category_slug" id="category_slug" placeholder="Slug">
                </div>



                <div class="form-group col-md-6">
                    <label for="category_cover_image">Cover Image</label>
                    <input type="file" id="category_cover_image" name="category_cover_image" class="form-control" >
                    @error('category_cover_image')
                    <p style="color: red">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="category_menu_image">Menu Image</label>
                    <input type="file" id="category_menu_image" name="category_menu_image" class="form-control" >
                    @error('category_menu_image')
                    <p style="color: red">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="category_meta_title">Meta Title</label>
                    <input type="text" class="form-control"  value="{{$category_data->meta_title}}" name="category_meta_title" id="category_meta_title" placeholder="Meta title">
                </div>
                <div class="form-group col-md-6">
                    <label for="category_meta_description">Meta Description</label>
                    <input type="text" class="form-control"  value="{{$category_data->meta_description}}" name="category_meta_description" id="category_meta_description" placeholder="Meta Description">
                </div>
                <div class="form-group col-md-6">
                    <label for="category_meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control"  value="{{$category_data->meta_keywords}}" name="category_meta_keywords" id="category_meta_keywords" placeholder="Meta Keywords">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="client_phone">Description</label>
                <textarea class="form-control" name="category_description" id="category_description" rows="5" placeholder="Category Description"> {{$category_data->category_description}}</textarea>

            </div>
            <button type="submit" id="add_btn" class="btn btn-primary">Submit</button>
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
</script>
<script>
    $("#edit_form").on('submit', function (e) {
        e.preventDefault();
        $(".error_msg").html('');
//        var data = new FormData($('#add_form')[0]);
//        var data = $('#add_form').serialize();
//        alert(data['brand_name']);
//        
        let id = $('#category_id').val();
//         alert(data);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url('categories/')}}/" + id + "",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                window.location.href = "{{ url('categories')}}";
            }
        }).done(function () {
            $("#success_msg").html("Data Updated Successfully");
//            setTimeout(function(){  }, 3000);
            window.location.href = "{{ url('categories')}}";
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



