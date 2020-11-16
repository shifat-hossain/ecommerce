<form id="edit_form">
    @method('PUT')
    <div class="dashboard-detail">
        <ul>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>First name</h6>
                    </div>
                    <div class="right">
                        <input type="hidden" name="id" value="{{$customer_info->id}}">
                        <h6><input class="form-control" type="text" name="customer_first_name" id="customer_first_name" value="{{$customer_info->customer_first_name}}"></h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>Last name</h6>
                    </div>
                    <div class="right">
                        <h6><input class="form-control" type="text" name="customer_last_name" id="customer_last_name" value="{{$customer_info->customer_last_name}}"></h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>Email</h6>
                    </div>
                    <div class="right">
                        <h6><input class="form-control" type="text" name="customer_email" id="customer_email" value="{{$customer_info->customer_email}}"></h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>Phone</h6>
                    </div>
                    <div class="right">
                         <h6><input class="form-control" type="text" name="customer_phone" id="customer_phone" value="{{$customer_info->customer_phone}}"></h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>Country</h6>
                    </div>
                    <div class="right">
                        <h6>
                            <input type="hidden" name="country_name" id="country_name" value="{{ $customer_info->country_name }}">
                            <select style="width: 67%" class="form-control" id="country_id" name="country_id">
                                <option value="">Select Country</option>
                                @foreach(get_all_country() as $country)
                                <option <?php if($country->id == $customer_info->country_id) {echo "selected";} ?> value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>State</h6>
                    </div>
                    <div class="right">
                        <h6>
                            <input type="hidden" name="state_name" id="state_name" value="{{$customer_info->state_name}}">
                            <input type="hidden" name="state_id" id="state_id_view" value="{{$customer_info->state_id}}">
                            <select style="width: 133%" class="form-control" id="state_id">
                                <option value="">Select Country</option>
                                @foreach(get_all_country_wise_state($customer_info->country_id) as $state)
                                <option <?php if($state->id == $customer_info->state_id) {echo "selected";} ?> value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>Address</h6>
                    </div>
                    <div class="right">
                        <h6><input class="form-control" type="text" name="customer_address" id="customer_address" value="{{$customer_info->customer_address}}"></h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                        <h6>Postal Code</h6>
                    </div>
                    <div class="right">
                        <h6><input class="form-control" type="text" name="customer_postal_code" id="customer_postal_code" value="{{$customer_info->customer_postal_code}}"></h6>
                    </div>
                </div>
            </li>
            <li>
                <div class="details">
                    <div class="left">
                    </div>
                    <div class="right">
                        <a id="edit_btn" type="button" class="btn btn-solid">Submit</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</form>