<!-- latest jquery-->
<script src="{{asset('public')}}/frontend_asset/js/jquery-3.3.1.min.js"></script>

<!-- menu js-->
<script src="{{asset('public')}}/frontend_asset/js/menu.js"></script>

<!-- lazyload js-->
<script src="{{asset('public')}}/frontend_asset/js/lazysizes.min.js"></script>

<!-- popper js-->
<script src="{{asset('public')}}/frontend_asset/js/popper.min.js"></script>
<script src="{{asset('public')}}/frontend_asset/js/price-range.js"></script>

<!-- slick js-->
<script src="{{asset('public')}}/frontend_asset/js/slick.js"></script>

<!-- Bootstrap js-->
<script src="{{asset('public')}}/frontend_asset/js/bootstrap.js"></script>

<!-- Bootstrap Notification js-->
<script src="{{asset('public')}}/frontend_asset/js/bootstrap-notify.min.js"></script>

<!-- Theme js-->
<script src="{{asset('public')}}/frontend_asset/js/script.js"></script>
<script>
     $(document).ready(function() {
         getCart();
     });
function addCart(id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{url('cart/add-to-cart')}}/",
        data: {product_id: id, quantity: '', attribute_id: ''},
        success: function (data, textStatus, jqXHR) {
        $(".success_msg").html("Data Save Successfully");
        getCart();
        }
    });
};

function getCart() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{url('cart/get-cart')}}/",
        success: function (response) {
            $('#getCart').html(response);
        },error:function(){
            alert('Error');
        }
    });
}
;
 function deleteCartExceptReload(id){
    $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: "{{url('cart/delete-to-cart')}}/",
            data:{product_id:id, quantity:'', attribute_id:''},
            success: function (data, textStatus, jqXHR) {

            }
    }).done(function () {
    $("#success_msg").html("Data Save Successfully");
    getCart();
    });
    };

</script>