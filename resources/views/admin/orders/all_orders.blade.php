@extends('layouts.master')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All order</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php // echo '<pre>';print_r($all_category);?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Customer Name</th>
                        <th>Order Code</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_orders as $row)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $row->customer_name }}
                        </td>
                        <td>
                            {{ $row->order_code }}
                        </td>
                        <td>
                            {{ $row->order_grand_total }}
                        </td>
                        <td>
                            {{ $row->order_date }}
                        </td>
                        <td>
                            <a href="{{ url('admin/orders/'.$row->id) }}"   style="margin-right: 5px" class="btn btn-success btn-sm float-left" >
                                View
                            </a> 

                            <!--<form method="post" action="{{url('admin/orders/'.$row->id)}}">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you want to delete this!')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form> -->
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


