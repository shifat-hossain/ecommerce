<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">-->
        <link href="{{asset('public/asset/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />-->
        <!-- Styles -->
        <style>
            span.select2.select2-container.select2-container--default{
                width: 450px !important;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success" id="show_registration_div">Room Management</button>
                    <button class="btn btn-info" id="show_room_allocate_div">Allocate Room For Exam</button>
                    <button class="btn btn-danger" id="show_exam_div">Exam Management</button>
                    <button class="btn btn-warning" id="show_registration_div">Add Student</button>
                    
                    <div id="registration" style="margin-top: 30px;">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Level</label>
                                    <input type="text" class="form-control" id="inputEmail4" placeholder="Level">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Room No</label>
                                    <input type="number" class="form-control" id="inputPassword4" placeholder="Room No">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Capacity</label>
                                    <input type="number" class="form-control" id="inputAddress" placeholder="Capacity">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCity">Status</label>
                                    <select class="form-control">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <button type="button" class="btn btn-primary" id="save_registration">Save</button>
                        </form>
                    </div>
                    
                    <div id="room_allocate" style="margin-top: 30px;display: none;">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Exam</label>
                                <select class="form-control">
                                    <option value="">Select Exam</option>
                                    <option value="1">Exam Name 1</option>
                                    <option value="2">Exam Name 2</option>
                                    <option value="3">Exam Name 3</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity" style="display: block">Room</label>
                                <select class="form-control js-example-basic-multiple" name="states[]" multiple="multiple">
                                    <option value="50">L1R1</option>
                                    <option value="40">L1R2</option>
                                    <option value="20">L2R1</option>
                                </select>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-primary" id="save_registration">Save</button>
                        
                    </div>
                    
                    <div id="show_exam" style="margin-top: 30px;display: none;">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Number Of Student</label>
                                <input type="number" class="form-control" id="inputAddress" placeholder="Number Of Student">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity" style="display: block">Exam Name</label>
                                <select class="form-control">
                                    <option value="">Select Exam</option>
                                    <option value="150">Exam Name 1</option>
                                    <option value="60">Exam Name 2</option>
                                    <option value="20">Exam Name 3</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div id="show_registration" style="margin-top: 30px;display: none;">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Number Of Student</label>
                                <input type="number" class="form-control" id="inputAddress" placeholder="Number Of Student">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity" style="display: block">Exam Name</label>
                                <select class="form-control">
                                    <option value="">Select Exam</option>
                                    <option value="150">Exam Name 1</option>
                                    <option value="60">Exam Name 2</option>
                                    <option value="20">Exam Name 3</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{asset('public/asset/js/jquery-3.3.1.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('public/asset/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        
        <script>
            $("#show_registration_div").click(function (){
                $("#registration").show();
                $("#room_allocate").hide();
                $("#show_exam").hide();
            });
            $("#show_room_allocate_div").click(function (){
                $("#registration").hide();
                $("#room_allocate").show();
                $("#show_exam").hide();
            });
            $("#show_exam_div").click(function (){
                $("#registration").hide();
                $("#room_allocate").hide();
                $("#show_exam").show();
            });
            
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
    </body>
</html>
