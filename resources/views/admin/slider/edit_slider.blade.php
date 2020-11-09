
<input type="hidden" name="id" value="{{$slider_info->id}}">
<div class="form-group">
    <label for="exampleInputEmail1">Slider Title</label>
    <input type="text" class="form-control" name="slider_title" id="slider_title" placeholder="Enter Slider Title" value="{{$slider_info->slider_title}}">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Slider Text</label>
    <input type="text" class="form-control" name="slider_text" id="slider_text" placeholder="Enter Slider Text" value="{{$slider_info->slider_text}}">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Slider Tag</label>
    <input type="text" class="form-control" name="slider_tag" id="slider_tag" placeholder="Enter Slider Tag" value="{{$slider_info->slider_tag}}">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Slider Image</label>
    <input type="hidden" name="pre_img" value="{{$slider_info->slider_image}}">
    <input type="file" class="form-control" name="slider_image" id="slider_image">
</div>