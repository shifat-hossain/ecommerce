
@extends('layouts.home')

@section('title', 'Page Title')

@section('home_content')


    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>create account</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">create account</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="register-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>create account</h3>

                    <h5 class="success_msg" style="color: green;font-weight: 600;"></h5>
                    <div class="theme-card">
                        <form id="add_form" class="theme-form">
                            
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="customer_first_name">First Name</label>
                                    <input type="text" class="form-control" id="customer_first_name" name="customer_first_name" placeholder="First Name" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="customer_last_name" name="  customer_last_name" placeholder="Last Name"
                                        required="">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="customer_email">Email</label>
                                    <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Email" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_phone">Phone</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" 
                                        placeholder="Enter Phone Number" required="">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col-md-6">
                                    <label for="country_id">Country</label>
                                    <input type="hidden" name="country_name" id="country_name">
                                    <select class="form-control" id="country_id" name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach(get_all_country() as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="state_id">State</label>
                                    <input type="hidden" name="state_name" id="state_name">
                                    <input type="hidden" name="state_id" id="state_id_view">

                                    <select class="form-control" id="state_id">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <div class="col-md-6">
                                    <label for="customer_postal_code">Postal Code</label>
                                    <input type="text" class="form-control" id="customer_postal_code" name="customer_postal_code" placeholder="Enter Postal Code" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="review">Address</label>
                                    <textarea class="form-control" id="customer_address" name="customer_address"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter your password" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="review">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                        placeholder="Enter your password" required="">
                                </div>
                                <a id="add_btn" type="button" class="btn btn-solid">create Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('extra-scripts')
<script type="text/javascript">   
    $("#add_btn").click(function () {
        $(".error_msg").html('');
        var data = $('#add_form').serialize();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-home"]').attr('content')
            },
            method: "POST",
            url: "{{ url('user/store-registration') }}",
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $("#success_msg").html("Registration Successfull");
            location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });

    $(document).on('change', '#country_id', function() {
        var id = $(this).find(':selected').val();
        var country_name = $(this).find(':selected').text();
        $('#country_name').val(country_name);
         $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-home"]').attr('content')
            },
            url: "{{url('get-states')}}/" + id,
            success: function (response) {
                $('#state_id').html(response);
            }
        });
    });

    $(document).on('change', '#state_id', function() {
        let state_value = $("select#state_id option").filter(":selected").val();
        var splitted = state_value.split('|');
        var id = splitted.shift();
        var state_name = splitted.join(',');
        $('#state_id_view').val(id);
        $('#state_name').val(state_name);
    });

</script>
@endsection