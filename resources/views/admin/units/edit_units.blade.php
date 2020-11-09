                    <h4 id="success_msg" style="color: green;font-weight: 600;"></h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Unit Name</label>
                            <input type="text" class="form-control" value="{{$unit_data->unit_name}}" name="unit_name" id="edit_unit_name" placeholder="Enter Name">
                            <input type="hidden" class="form-control" value="{{$unit_data->id}}" name="unit_id" id="unit_id" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Unit Code</label>
                            <input type="text" class="form-control" value="{{$unit_data->unit_code}}" name="unit_code" id="edit_unit_code" placeholder="Enter Code">
                        </div>