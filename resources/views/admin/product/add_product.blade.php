@extends('layouts.master')

@section('content')
<style>
    .card-body ul{
        padding-left: 14px;
    }
    
    .card-body ul li{
        list-style: none;
    }
    
    .dz-message{
        display: none;
    }
    
    .dropzone {
        min-height: 150px;
        border: 1px solid #ced4da;
        background: white;
        padding: 20px 20px;
    }
</style>

<div class="col-12">
    
    <div class="alert alert-success" id="success_msg" role="alert" style="display: none;"></div>
    <div id="error_msg"></div>
    
    
    <form id="add_form">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">
                            Basic Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">
                            Attribute
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="seo-tab" data-toggle="pill" href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                            SEO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">
                            Options
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <!-- /.form-group -->
                                        <div id="myId" class="dropzone" style="text-align: center;">
                                            <i class="fa fa-camera" style="font-size: 60px;color: #bbcdd2;"></i>
                                            <br>Drop images here
                                            <br>
                                            <strong>or select files</strong>
                                            <br>
                                            <small>Recommended size 800 x 800px for default theme.<br>JPG, GIF or PNG format.</small>
                                        </div>
                                        <!-- /.form-group -->

                                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin: 30px 0px;">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                                    Summary
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                                    Description
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                <textarea id="summernote" name="short_description" placeholder=""></textarea>
                                            </div>
                                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                <textarea id="summernote1" name="description" placeholder=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <select class="form-control select2" name="brand">
                                                <option value="">Choose Brand</option>
                                                @foreach($all_brand as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->brand_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="text" name="price" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="text" name="quantity" class="form-control">                                         
                                        </div>
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <select class="form-control select2" name="unit">
                                                <option value="">Choose Unit</option>
                                                @foreach($all_unit as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->unit_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="card border-primary mb-3">
                                            <div class="card-header">Categories</div>
                                            <div class="card-body text-primary" style="padding-left: 0px;">
                                                <?php echo $category_list;?>
                                            </div>
                                        </div>

    <!--                                    <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="on_sale">
                                                <label for="on_sale" class="custom-control-label">Product On Sale</label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="sale_price_div" style="display: none;">
                                            <label>Sale Price</label>
                                            <input type="text" name="product_name" class="form-control">
                                        </div>-->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">

                                        <p class="card-text">
                                            To add combinations, you first need to create proper attributes and values in <strong>Attributes</strong>.
                                            When done, you may enter the wanted attributes (like "size" or "color") and their respective values ("XS", "red", "all", etc.) in the field below; or simply select them from the right column. 
                                        </p>

                                        <a href="{{url('attributes')}}" class="card-link">Attributes Link</a>
                                    </div>
                                </div>
                                
                                <div class="card" style="height: 150px; overflow: auto;"> 
                                    <div id="product-attribute" class="card-body">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                @foreach($all_attribute_with_group as $row)
                                <div class="card card-primary collapsed-card">
                                    <div class="card-header" style="padding: 0.25rem 1.25rem;">
                                        <h3 class="card-title">
                                            {{ $row->attribute_group_name }}
                                        </h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        @foreach($row->attributes as $val)
                                        <div class="attribute">
                                            <label>
                                                <input type="checkbox" class="attribute-checkbox" id="attribute-{{ $val->id }}" data-label="{{ $row->attribute_group_name }} : {{ $val->attribute_name }}" value="{{ $val->id }}"> 
                                                {{ $val->attribute_name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                @endforeach
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input type="text" name="meta_title" class="form-control" placeholder="To have a different title from the product name, enter it here.">
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" name="meta_description" placeholder="To have a different description than your product summary in search results pages, write it here."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <input type="text" name="meta_keywords" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Friendly URL</label>
                                            <input type="text" name="slug" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tags</label>
                                    <input type="text" name="tags" class="form-control" placeholder="Use a comma to create separate tags. E.g.: dress, cotton, party dresses.">
                                </div>
                                <div class="form-group">
                                    <label>EAN</label>
                                    <input type="text" name="ean" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" name="sku" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="product-footer justify-content-md-center">
            <div class="col-lg-4">
                <label class="label-switch switch-primary">
                    <input type="checkbox" class="switch switch-bootstrap status" name="status" id="status" value="1" checked="checked">
                     <span class="lable active_status"> Active</span>
                </label>
            </div>
            <div class="col-sm-5 col-lg-7 text-right">

                <div class="js-spinner spinner hide btn-primary-reverse onclick mr-1 btn"></div>
                <div class="btn-group hide dropdown">
                    <button class="btn btn-primary js-btn-save ml-3" id="add_btn" type="button">
                        <span>Save</span>
                    </button><button class="btn btn-primary dropdown-toggle dropdown-toggle-split" type="button" id="dropdownMenu" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <a class="dropdown-item duplicate js-btn-save" href="/admin-dev/index.php/sell/catalog/products/unit/duplicate/20?_token=gdLbJbM_fRZx14T0h5kYuDVLtaTA--xvDhzF9DdPs1I">
                            Duplicate
                        </a>
                        <a class="dropdown-item go-catalog js-btn-save" href="/admin-dev/index.php/sell/catalog/products/last?_token=gdLbJbM_fRZx14T0h5kYuDVLtaTA--xvDhzF9DdPs1I">
                            Go to catalog
                        </a>
                        <a class="dropdown-item new-product js-btn-save" href="/admin-dev/index.php/sell/catalog/products/new?_token=gdLbJbM_fRZx14T0h5kYuDVLtaTA--xvDhzF9DdPs1I">
                            Add new product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    if($("#myId").length) {
        var myDropzone = new Dropzone("div#myId", {
            addRemoveLinks: true,
            url: "{{ route('products.upload') }}",
            maxFilesize: 2000,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init: function() {
            },
            success: function (file, response) {
                $('form#add_form').append('<input type="hidden" name="images_name[]" value="' + response + '">')
            }
        });
    }
    
    $("[name=name]").keyup(function () {
        var product_name = $(this).val();
        product_name = product_name.replace(/\s+/g, '-').toLowerCase();
//        console.log(product_name);
        $("[name=slug]").val(product_name);
    });
    
    var attribute_array = [];
    $(".attribute-checkbox").change(function () {
        
        if($.inArray($(this).val(), attribute_array) == -1){
            attribute_array.push($(this).val());
        } else if($.inArray($(this).val(), attribute_array) != -1){
           const index = attribute_array.indexOf($(this).val());
           attribute_array.splice(index, 1);
        }
        
        var html = "";
        attribute_array.forEach(function (item) {
            html += '<div id="product-attribute'+item+'">\
                        <i class="fa fa-minus-circle"></i> '+$("#attribute-"+item).data("label")+'\
                        <input type="hidden" name="attribute[]" value="'+item+'">\
                    </div>';
        }); 
        $("#product-attribute").html(html);
        
    });
    
    $("#status").change(function () {
        if ($(this).is(":checked")) {
            $(".active_status").text("Active");
        } else {
            $(".active_status").text("Inactive");
        }
    });
    
    $("#add_btn").click(function (){
        $(".error_msg").html('');
        var data = new FormData($('#add_form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url("admin/products")}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
            }
        }).done(function(data) {
            var json_data = JSON.parse(data);
            if(json_data.status == 'Success') {
                $("#success_msg").html("Data Save Successfully");
                $("#success_msg").show();
                window.location.href = "{{ url('admin/products')}}";
            }
            
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            
            $.each(json_data.errors, function(key, value){
                $("#error_msg").html("<div class='alert alert-default-danger' role='alert'>\
                                        " + value + "\
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>\
                                                <span aria-hidden='true'>&times;</span>\
                                            </button>\
                                        </div>");
            });
        });
    });
    
    $("#on_sale").click(function () {
        $("#sale_price_div").hide();
        if($('#on_sale').prop('checked')) {
            $("#sale_price_div").show();
        }
    });
    
//    SummerNote Image
</script>
@endsection


