@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Products</h4>
            
            @if(Auth::user()->can('add-product'))
            <div class="card-tools">
                <a href="{{url('products/create')}}" class="btn btn-info btn-md">
                    <i class="fa fa-plus-circle"></i>Add New Product
                </a>
            </div>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_product as $row)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <img src="" alt="brand image" style="width: 80px;">
                        </td>
                        <td>
                            {{ $row->name }}
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            {{ $row->price }}
                        </td>
                        <td>
                            @if($row->status == '1')
                            Active
                            @else
                            Inactive
                            @endif
                        </td>
                        <td>

                            <a href=""  class="btn btn-primary btn-sm mr-2 float-left">
                                View
                            </a> 

                            
                             
                            @if(Auth::user()->can('edit-product'))
                            <a href="products/{{ $row->id }}/edit"  class="btn btn-success btn-sm mr-2 float-left text-white">
                                Edit
                            </a> 
                            @endif
                            

                            @if(Auth::user()->can('delete-product'))
                            <form method="post" action="{{ route('products.destroy', $row->id) }}">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure want to delete this?');" type="submit" class="btn btn-danger btn-sm float-left">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                        
                </tbody>
            </table>
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
            url: "brands",
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
    })
</script>
@endsection


