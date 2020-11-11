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
 
    #map{
        width: 100%;
        height: 250px;
    }

    #searchInput{
        top: 10px !important;
        padding: 10px;
        width: 300px;

    </style>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Company Info</h4>           
            </div>
            <!-- /.card-header -->
            <div class="card-body">



                <form id="add_form">

                    <div class="form-row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Company Name:</label>
                                <input type="text" class="form-control" name="company_name" value="{{ $company_data[0]->company_name }}">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Comapny Email:</label>
                                <input type="text" class="form-control" name="company_email" value="{{ $company_data[0]->company_email}}">
                            </div>
                        </div>
                    </div><!-- end form-row -->
                    <div class="form-row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Company Phone:</label>
                                <input type="text" class="form-control" name="company_phone" value="{{ $company_data[0]->company_phone}}">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Comapny Image:</label>
                                <input type="file" class="form-control" name="company_image">
                            </div>
                        </div>
                    </div><!-- end form-row -->

                    <div class="form-row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Facebook Link:</label>
                                <input type="text" class="form-control" name="facebook_link" value="{{ $company_data[0]->facebook_link}}">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Twitter Link:</label>
                                <input type="text" class="form-control" name="twitter_link" value="{{ $company_data[0]->twitter_link}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Pinterest Link:</label>
                                <input type="text" class="form-control" name="pinterest_link" value="{{ $company_data[0]->pinterest_link}}">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Google Link:</label>
                                <input type="text" class="form-control" name="google_link" value="{{ $company_data[0]->google_link}}">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="inputGroupSelect07" class="">Instagram Link:</label>
                                <input type="text" class="form-control" name="instagram_link" value="{{ $company_data[0]->instagram_link}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                         <label for="inputGroupSelect07" class="">Address:</label>
                        <textarea class="form-control textarea text-left p-3 h-100" name="company_address" id="exampleFormControlTextarea1" rows="2" placeholder="Company Address">{{ $company_data[0]->company_address}}</textarea>
                    </div>
                    <div class="form-group">
                         <label for="inputGroupSelect07" class="">Company Summary:</label>
                        <textarea class="form-control textarea text-left p-3 h-100" name="company_summary" id="exampleFormControlTextarea1" rows="2" placeholder="Company Summary">{{ $company_data[0]->company_summary}}</textarea>
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
                                <input type="text" class="form-control" id="longitude" name="longitude" readonly="" value="{{ $company_data[0]->longitude}}">
                            </div><!-- end form-group -->
                        </div>
                        <div class="col-md" id="">
                            <div class="form-group">
                                <label for="exampleInputuname">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" readonly="" value="{{ $company_data[0]->latitude}}">
                            </div><!-- end form-group -->
                        </div>
                    </div>
                    
                        <div id="success_msg" class="text-success" style="text-align: center; min-height: 35px;"></div>
                    
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <button type="button" class="btn btn-info" id="add_btn">Submit</button>
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
                url: "{{url("edit-company-data")}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {

                }
            }).done(function () {
                $("#success_msg").html("Data Updated Successfully");
                setTimeout(function () {
                    document.location.reload();
                }, 2000);
            }).fail(function (data, textStatus, jqXHR) {
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function (key, value) {
                    $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
                });
            });
        });
    </script>
    <script>
        function initMap() {
            var longitude = document.getElementById('longitude').value;
            var latitude = document.getElementById('latitude').value;

            var myLatlng = new google.maps.LatLng(latitude, longitude);
            //    alert(myLatlng);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: myLatlng,
                zoom: 15
            });
            var input = document.getElementById('searchInput');
            //    alert(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                //                        anchorPoint: new google.maps.Point(0, -29),
                draggable: true,
            });

            map.addListener('click', function (event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
                infowindow.setContent('Latitude: ' + event.latLng.lat() + '<br>Longitude: ' + event.latLng.lng());
                infowindow.open(map, marker);
            });

            google.maps.event.addListener(marker, 'dragend', function (event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
                infowindow.setContent('Latitude: ' + event.latLng.lat() + '<br>Longitude: ' + event.latLng.lng());
                infowindow.open(map, marker);
            });

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                /*
                 marker.setIcon(({
                 url: place.icon,
                 size: new google.maps.Size(71, 71),
                 origin: new google.maps.Point(0, 0),
                 anchor: new google.maps.Point(17, 34),
                 scaledSize: new google.maps.Size(35, 35)
                 }));
                 */
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);

                //Location details
                for (var i = 0; i < place.address_components.length; i++) {
                    if (place.address_components[i].types[0] == 'postal_code') {
                        document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
                    }
                    if (place.address_components[i].types[0] == 'country') {
                        document.getElementById('country').innerHTML = place.address_components[i].long_name;
                    }
                }
                document.getElementById('location').innerHTML = place.formatted_address;
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9x8mCn5-P8XUl59uGqwmmcU6Alt1qza8&libraries=places&language=en&callback=initMap" async defer></script>

    @endsection


