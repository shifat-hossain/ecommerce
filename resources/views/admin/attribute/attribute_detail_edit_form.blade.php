
<h5 class="success_msg" style="color: green;font-weight: 600;"></h5>
<div class="form-group">
    <label for="exampleInputEmail1">Attribute Name</label>
    <input type="text" class="form-control" name="attribute_name" id="edit_attribute_value" value="{{$attribute_data->attribute_name}}" placeholder="Enter Name">
    <input type="hidden" name="attribute_id" id="edit_attribute_id" value="{{$attribute_data->id}}">
</div>
<?php
if($attribute_group_data->attribute_group_name == 'Color')
{
?>
<div class="form-group">
    <label for="exampleInputEmail1">Color Code</label>
    <input type="text" id="update_color_code" readonly value="{{$attribute_data->color_code}}">
    <input type="color" onchange="changecolorValue(this.value)" class="form-control" name="attribute_color_code" id="edit_attribute_color_code" value="{{$attribute_data->color_code}}">
</div>
<?php }?>