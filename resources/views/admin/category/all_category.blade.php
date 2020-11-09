@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Category</h4>
            
            @if(Auth::user()->can('add-category'))
            <div class="card-tools">
                <a class="btn btn-info btn-sm" href="{{url('categories/create')}}"><i class="fas fa-plus-circle"></i> Add New Category</a>
            </div>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php // echo '<pre>';print_r($all_category);?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Category Name</th>
                        <th>Parent Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_category as $row)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $row->category_name }}
                        </td>
                        <td>
                            {{ $row->parent_cat }}
                        </td>
                        <td>
                            @if(Auth::user()->can('edit-category'))
                            <a href="{{url('categories/'.$row->id.'/edit')}}" style="margin-right: 5px" class="btn btn-primary btn-sm float-left view_modal">
                                Edit
                            </a> 
                            @endif

                            @if(Auth::user()->can('delete-category'))
                            <form method="post" action="{{url('categories/'.$row->id)}}">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you want to delete this! All sub category will be deleted!');" type="submit" class="btn btn-danger btn-sm">Delete</button>
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
                    <h5 class="modal-title" id="add_modal_label">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_form">
                    <div class="modal-body">
                        <h4 id="success_msg" style="color: green;font-weight: 600;"></h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="add_btn" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    $("#add_btn").click(function () {
        $(".error_msg").html('');
        var data = $('#add_form').serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "categories",
            data: data,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $("#success_msg").html("Data Save Successfully");
            location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    })
</script>
@endsection


