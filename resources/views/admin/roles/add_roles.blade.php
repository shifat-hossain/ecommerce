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
            <h4 class="card-title">Roles Info</h4>

        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="alert alert-success" id="success_msg" role="alert" style="display: none;"></div>

            <form id="add_form">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="Name">Role Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Role Name">
                    </div>

                    <div class="form-group col-md-12">

                        <label for="Name" style="display: block;">Permission</label>

                        @foreach($all_permissions as $key => $val)
                        <h6 style="font-weight: bold;font-size: 13px;">
                            {{$key}}
                        </h6>
                        @foreach($val as $row)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="permissions[]" 
                                   id="inlineCheckbox{{$key}}_{{ $loop->iteration }}" value="{{ $row->id }}">
                            <label class="form-check-label" for="inlineCheckbox{{$key}}_{{ $loop->iteration }}">
                                {{ $row->name }}
                            </label>
                        </div>
                        @endforeach
                        @endforeach

                    </div>

                </div>

                <button type="button" id="add_btn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>


</div>

<script>

    $("#add_btn").click(function () {

        $(".error_msg").html('');
        var data = new FormData($('#add_form')[0]);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url("admin/roles")}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $("#success_msg").html("Data Save Successfully");
            $("#success_msg").show();
            window.location.href = "{{ url('admin/roles')}}";
            // location.reload();
        }).fail(function (data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
</script>


@endsection


