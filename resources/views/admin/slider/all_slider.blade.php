@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Slider</h4>
            
            @if(Auth::user()->can('add-slider'))
            <div class="card-tools">
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_modal" ><i class="fas fa-plus-circle"></i> Add New Slider</button>
            </div>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Slider Image</th>
                        <th>Slider Title</th>
                        <th>Slider Text</th>
                        <th>Slider Tag</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_slider as $row)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <img src="{{ asset('storage/app/'.$row->slider_image) }}" alt="" style="width: 80px;height: 50px">
                            </td>
                            <td>
                                {{ $row->slider_title }}
                            </td>
                            <td>
                                {{ $row->slider_text }}
                            </td>
                            <td>
                                {{ $row->slider_tag }}
                            </td>
                            <td>
                                @if(Auth::user()->can('add-slider'))
                                <button data-id="{{$row->id}}" class="btn btn-success btn-sm mr-2 view_modal float-left">
                                    Edit
                                </button> 
                                @endif

                                @if(Auth::user()->can('delete-slider'))
                                <form method="post" action="{{url('sliders/'.$row->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_modal_label">Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_form">
                    
                    <div class="modal-body">
                        
                        <h4 id="success_msg" style="color: green;font-weight: 600;"></h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider Title</label>
                            <input type="text" class="form-control" name="slider_title" id="slider_title" placeholder="Enter Slider Title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider Text</label>
                            <input type="text" class="form-control" name="slider_text" id="slider_text" placeholder="Enter Slider Text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider Tag</label>
                            <input type="text" class="form-control" name="slider_tag" id="slider_tag" placeholder="Enter Slider Tag">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider Image</label>
                            <input type="file" class="form-control" name="slider_image" id="slider_image">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="add_btn" class="btn btn-primary">Save changes</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal_label">Edit Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_form">
                    
                    <div class="modal-body" id="modal_body">
                        
                        <h4 id="success_msg" style="color: green;font-weight: 600;"></h4>                        
                    </div>
                    @method('PUT')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button"  class="btn btn-primary edit_button">Save changes</button>
                    </div>
                    
                </form>
            </div>
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
            url: "sliders",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Save Successfully");
            location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value){
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
</script>

<script type="text/javascript">
    $(".view_modal").click(function (){

        var id = $(this).data("id");
        $.ajax({
            method: "GET",
            url: "sliders/"+id+"/edit",
            data: id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                $("#modal_body").html(data);
                $("#edit_modal").modal("show");
                
            }
        });
    });
</script>

    <script type="text/javascript">
        $(".edit_button").click(function (){
            //alert('sdfas');
        $(".error_msg").html('');

        var data = new FormData($('#edit_form')[0]);
    
        var id = $('[name=id]').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "sliders/"+id,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Save Successfully");
            location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value){
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
    </script>

@endsection


