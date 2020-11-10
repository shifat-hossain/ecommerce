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
           <form class="text-center" action="edit-company-data" method="post" enctype="multipart/form-data" id="add_slider_info">
                
                <div class="form-row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Company Name:</label>
                            <input type="text" class="form-control" name="company_name" value="{{ $company_data->company_name}}">
                        </div>
                    </div>
                    
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Comapny Email:</label>
                            <input type="text" class="form-control" name="company_email" value="{{ $company_data->company_email}}">
                        </div>
                    </div>
                </div><!-- end form-row -->
                <div class="form-row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Company Phone:</label>
                            <input type="text" class="form-control" name="company_phone" value="{{ $company_data->company_phone}}">
                        </div>
                    </div>
                    
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Comapny Image:</label>
                            <input type="file" class="form-control" name="userfile[]">
                        </div>
                    </div>
                </div><!-- end form-row -->
                
                <div class="form-row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Facebook Link:</label>
                            <input type="text" class="form-control" name="fb_link" value="{{ $company_data->fb_link}}">
                        </div>
                    </div>
                    
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Twitter Link:</label>
                            <input type="text" class="form-control" name="twitter_link" value="{{ $company_data->twitter_link}}">
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Pinterest Link:</label>
                            <input type="text" class="form-control" name="pinterest_link" value="{{ $company_data->pinterest_link}}">
                        </div>
                    </div>
                    
                    <div class="col-md">
                        <div class="form-group">
                            <label for="inputGroupSelect07" class="">Google Link:</label>
                            <input type="text" class="form-control" name="google_link" value="{{ $company_data->google_link}}">
                        </div>
                    </div>
                </div>
               
                <div class="form-group">
                    <textarea class="form-control textarea text-left p-3 h-100" name="company_address" id="exampleFormControlTextarea1" rows="2" placeholder="Company Address">{{ $company_data ['company_address']}}</textarea>
                </div>
                
                <div class="form-group">
                    <input id="searchInput" class="controls" type="text" placeholder="Enter a location">
                    <div id="map"></div>
                    <ul id="geoData">
                        <li style="display: none;">Full Address: <span id="location"></span></li>
                        <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                        <li style="display: none;">Country: <span id="country"></span></li>
                        <li style="display: none;">Latitude: <span id="lat"></span></li>
                        <li style="display: none;">Longitude: <span id="lon"></span></li>
                    </ul>
                </div>
                <div class="form-row">
                    <div class="col-md" id="">
                        <div class="form-group">
                            <label for="exampleInputuname">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" readonly="" value="{{ $company_data->longitude}}">
                        </div><!-- end form-group -->
                    </div>
                    <div class="col-md" id="">
                        <div class="form-group">
                            <label for="exampleInputuname">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" readonly="" value="{{ $company_data->latitude}}">
                        </div><!-- end form-group -->
                    </div>
                </div>
                
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <button type="submit" class="btn" id="add_hotel">Submit</button>
                    </li>
                </ul>

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
            url: "{{url("categories")}}",
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
                window.location.href = "{{ url('categories')}}";
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


