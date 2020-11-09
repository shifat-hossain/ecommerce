@extends('layouts.master')

@section('content')

<style>
    span.select2.select2-container.select2-container--default{
        width: 450px !important;
    }
</style>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Custom Field List</h4>
            
            <div class="card-tools">
                <a href="{{url('custom-fields/create')}}" class="btn btn-info btn-sm" >
                    <i class="fas fa-plus-circle"></i> Add New Custom Field
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Level</th>
                        <th>Section</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($all_custom_field as $key => $row)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$row->field_label}}</td>
                        <td>{{$row->field_section}}</td>
                        <td>{{$row->field_type}}</td>
                        <td>
                            <!-- Default checked -->
                            <div class="custom-control custom-switch text-center">
                              <input type="checkbox" class="custom-control-input status" data-id="{{$row->id}}" id="customSwitch{{$row->id}}" <?php if($row->field_status == 'ACTIVE'){echo "checked";}?>>
                              <label class="custom-control-label" for="customSwitch{{$row->id}}"></label>
                            </div>
                        </td>
                        <td>
                            <a href="{{url('custom-fields/'.$row->id.'/edit')}}"   class="btn  btn-success btn-sm float-left mr-2" >Edit</a>

                            <form method="post" action="{{url('custom-fields/'.$row->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    $(".status").click(function (){
         var url = "{{url("change-fields-status")}}";
        var id = $(this).data("id");        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: url + '/' + id,
            data: id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            window.location.href = "{{ url('custom-fields')}}";
            // window.location.reload();
        });
    });
</script>


@endsection


