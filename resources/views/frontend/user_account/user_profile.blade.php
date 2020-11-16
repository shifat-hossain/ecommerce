
@extends('layouts.home')

@section('title', 'Page Title')

@section('home_content')


    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>Customer dashboard</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">customer dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="profile-top">
                            <div class="profile-image">
                                <img src="../assets/images/logos/17.png" alt="" class="img-fluid">
                            </div>
                            <div class="profile-detail">
                                <h5>{{$customer_info[0]->customer_first_name.' '.$customer_info[0]->customer_last_name}}</h5>
                                <h6>{{$customer_info[0]->customer_email}}</h6>
                            </div>
                        </div>
                        <div class="faq-tab">
                            <ul class="nav nav-tabs" id="top-tab" role="tablist">

                                <li class="nav-item"><a data-toggle="tab" class="nav-link active"
                                        href="#profile">Account Info</a>
                                </li>

                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#orders">My Orders</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="modal" data-target="#logout"
                                        href="#">Change Password</a>
                                </li>

                                <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#logout"
                                        href="#">logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="faq-content tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="profile">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="dashboard-box">
                                                <div class="dashboard-title">
                                                    <h4>profile</h4>
                                                    <span id="edit-profile">edit</span>
                                                </div>
                                                <div id="profile_edit">
                                                    <div class="dashboard-detail">
                                                        <ul>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>Code</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <input type="hidden" id="customer_id" value="{{$customer_info[0]->id}}">
                                                                        <h6>{{$customer_info[0]->customer_code}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>First name</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->customer_first_name}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>Last name</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->customer_last_name}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>Email</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->customer_email}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>Phone</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->customer_phone}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>Country</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->country_name}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>State</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->state_name}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>Address</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->customer_address}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="details">
                                                                    <div class="left">
                                                                        <h6>Postal Code</h6>
                                                                    </div>
                                                                    <div class="right">
                                                                        <h6>{{$customer_info[0]->customer_postal_code}}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="orders">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card dashboard-table mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>orders</h3>
                                                <!-- <a href="#" class="btn btn-sm btn-solid">add product</a> -->
                                            </div>
                                            <table class="table table-responsive-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Order id</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @if(count($order_list) > 0)   
                                                        @foreach($order_list as $order)
                                                            <tr>
                                                                <th scope="row">{{$order->order_code}}</th>
                                                                <td>{{$order->order_status}}</td>
                                                                <td>{{$order->order_date}}</td>
                                                                <td>{{$order->order_grand_total}}</td>
                                                            </tr>
                                                        @endforeach                                                   
                                                    @else
                                                        <tr>
                                                            <td colspan="4">No Data Found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  dashboard section end -->


    <!-- Modal start -->
    <div class="modal logout-modal fade" id="logout" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logging Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you want to log out?
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-dark btn-custom" data-dismiss="modal">no</a>
                    <a href="index.html" class="btn btn-solid btn-custom">yes</a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->

@endsection


@section('extra-scripts')

<script type="text/javascript">

    $(document).on('click', '#edit-profile', function() {
        var id = $('#customer_id').val();
         $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-home"]').attr('content')
            },
            url: "{{url('user/edit-profile')}}/" + id,
            success: function (response) {
                $('#profile_edit').html(response);
            }
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


    $(document).on('click', '#edit_btn', function() {

        var url = "{{url("user/update-profile")}}"
        var id = $('[name=id]').val();
        $(".error_msg").html('');
        var data = new FormData($('#edit_form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-home"]').attr('content')
            },
            method: "POST",
            url: url + '/' + id,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $("#success_msg").html("Data Update Successfully");
            // window.location.href = "{{ url('admin/customers')}}";
            location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
    
</script>

@endsection