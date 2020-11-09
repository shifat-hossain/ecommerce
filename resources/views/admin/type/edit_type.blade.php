
<input  type="hidden" class="form-control mb-4" value="{{$type_info->id}}" name="id" id="type_id">

<div class="mb-4">
    <label for="type_section">Type Section</label>
    <select style="width: 100%" name="type_section" id="type_section" class="form-control select2 dynamic college_id">
        <option value="">Select Type</option>

        <option <?php if($type_info->type_section == 'CLIENT'){echo "selected";}?> value="CLIENT">Client</option>
        <option <?php if($type_info->type_section == 'VENDOR'){echo "selected";}?> value="VENDOR">Vendor</option>
        <option <?php if($type_info->type_section == 'USER'){echo "selected";}?> value="USER">User</option>
    </select>
</div>

<div class="form-group">
    <label for="type_name">Type Name</label>
    <input  type="text" class="form-control mb-4" value="{{$type_info->type_name}}" name="type_name" id="type_name" placeholder="Type Name">
</div>



