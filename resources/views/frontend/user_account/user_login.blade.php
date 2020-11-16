
@extends('layouts.home')

@section('title', 'Page Title')

@section('home_content')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>customer's login</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">login</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Login</h3>
                    <div class="theme-card">
                        <h4 id="err_msg" style="color: red;font-weight: 600;text-align: center;"></h4>
                        <form id="login" class="theme-form">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" required="">
                            </div>
                            <div class="form-group">
                                <label for="review">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Enter your password" required="">
                            </div>
                            <a id="login_btn" type="button" class="btn btn-solid">Login</a>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>New Customer</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">Create A Account</h6>
                        <p>Sign up for a free account at our store. Registration is quick and easy. It allows you to be
                            able to order from our shop. To start shopping click register.</p><a href="{{url('user/registration')}}"
                            class="btn btn-solid">Create an Account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection


@section('extra-scripts')

<script type="text/javascript">
    $("#login_btn").click(function () {
        $(".error_msg").html('');
        var data = $('#login').serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-home"]').attr('content')
            },
            method: "POST",
            url: "{{ url('user/login-check') }}",
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function (data) {
            if (data.status == 'ok') {
                window.location.href = "{{ url('user/profile')}}";
            }else if(data.status == 'not_ok'){
                $("#err_msg").html(data.message);
            }
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
</script>


@endsection