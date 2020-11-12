@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Products</h4>
            
            @if(Auth::user()->can('add-product'))
            <div class="card-tools">
                <a href="{{url('admin/products/create')}}" class="btn btn-info btn-md">
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
                            <img src="{{ asset("storage/app/".$row->product_images[0]->images_name) }}" alt="brand image" style="width: 80px;">
                        </td>
                        <td>
                            {{ $row->name }}
                        </td>
                        <td>
                            {{ $row->product_main_category->category_name }}
                        </td>
                        <td>
                            {{ $row->brand->brand_name }}
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
                            <form method="post" action="{{ route('products.destroy', $row->id) }}" style="display: inline-block;">
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


@endsection


