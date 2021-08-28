@extends('client.layouts.index')



@section('content')
<html>

<head>
    <meta charset="utf-8" />
    <title>Tạo Wishlist bằng Jquery - Lập Trình Việt Nhật</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" id="open-sans-css"
        href="https://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;subset=latin%2Clatin-ext&amp;ver=4.4.2"
        type="text/css" media="all">
    <link rel="stylesheet" id="style-css" href="css/style.css" type="text/css" media="all">
</head>

<body>
    <div id="mhead">
        <h2>Tạo Wishlist cho sản phẩm sử dụng Jquery - laptrinhvietnhat.com</h2>
    </div>
    <div id='msg'></div>
    <div id='products_container'>
        <div class='item-container'>
            <div class='product_name col-s'>
                Iphone 11 pro 128gb
            </div>
            <div class='product_price col-s'>
                19 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='Iphone 11 pro 128gb' product_id='product1' product_price='19'>Add
                    to wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                Samsung galaxy fold 2
            </div>
            <div class='product_price col-s'>
                50 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='Samsung galaxy fold 2' product_id='product2'
                    product_price='50'>Add to wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                Samsung Galaxy S10 Lite
            </div>
            <div class='product_price col-s'>
                10 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='Samsung Galaxy S10 Lite' product_id='product3'
                    product_price='10'>Add to wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                Samsung Galaxy Tab with S Pen (P205)
            </div>
            <div class='product_price col-s'>
                9 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='Samsung Galaxy Tab with S Pen (P205)' product_id='product4'
                    product_price='9'>Add to wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                Samsung Galaxy A30
            </div>
            <div class='product_price col-s'>
                3 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='Samsung Galaxy A30' product_id='product5' product_price='3'>Add
                    to wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                Samsung Galaxy S7
            </div>
            <div class='product_price col-s'>
                5 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='Samsung Galaxy S7' product_id='product6' product_price='5'>Add to
                    wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                MacBook Pro Touch 16 inch 2019 (MVVJ2SA/A)
            </div>
            <div class='product_price col-s'>
                60 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='MacBook Pro Touch 16 inch 2019 (MVVJ2SA/A)' product_id='product7'
                    product_price='60'>Add to wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                MSI Gaming GL65 Leopard 10SDK i7 10750H/144Hz (242VN)
            </div>
            <div class='product_price col-s'>
                30 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='MSI Gaming GL65 Leopard 10SDK i7 10750H/144Hz (242VN)'
                    product_id='product8' product_price='30'>Add to wishlist</button>
            </div>
        </div>
        <div class='item-container'>
            <div class='product_name col-s'>
                iPad Pro 12.9 inch Wifi 128GB (2020)
            </div>
            <div class='product_price col-s'>
                27 triệu
            </div>
            <div class='product_action col-s'>
                <button class='wishlist' product_name='iPad Pro 12.9 inch Wifi 128GB (2020)' product_id='product9'
                    product_price='27'>Add to wishlist</button>
            </div>
        </div>
    </div>

    <div id='wish_list' class='col-s'>
        <p class="wish_list_heading">
            <span id='listitem'>0</span>
            <span id='p_label'>Sản phẩm yêu thích</span>
        </p>
        <table id='wish_list_item' border='0'></table>
    </div>
    <script type="text/javascript" src="js/wishlist.js"></script>
</body>

</html>
<script src="">
var wish_list = new Array();

if (jQuery.inArray($product_id, wish_list) == -1) {
    $product_str = "<tr class='wishlist-item' id='list_id_" +
        $product_id + "'><td class='w-pname'>" +
        $product_name + "</td><td class='w-price'>" +
        $prduct_price +
        " triệu</td><td class='w-premove' wpid='" + $product_id +
        "'> (xoá) </td></tr>";
    jQuery("#wish_list_item").append($product_str);
    wish_list.push($product_id);
    show_message("Đã thêm sản phẩm yêu thích");
}
jQuery("#listitem").html(wish_list.length);
if (wish_list.length > 1) {
	jQuery("#p_label").html("Sản phẩm");
} else {
	jQuery("#p_label").html("Sản phẩm");
}
jQuery("#wish_list_item").on("click", ".w-premove", function() {
   $product_id = jQuery(this).attr("wpid");
   jQuery("#list_id_" + $product_id).remove();
   wish_list = jQuery.grep(wish_list, function(n, i) {
      return n != $product_id;
   });
   show_message("Ðã xoá sản phẩm yêu thích");
   count_items_in_wishlist_update();
});
function count_items_in_wishlist_update() {
	jQuery("#listitem").html(wish_list.length);
	if (wish_list.length > 1) {
		jQuery("#p_label").html("Sản phẩm");
	} else {
		jQuery("#p_label").html("Sản phẩm");
	}
}
function show_message($msg) {
	jQuery("#msg").html($msg);
	$top = Math.max(0,
			((jQuery(window).height() - jQuery("#msg").outerHeight()) / 2)
					+ jQuery(window).scrollTop())
			+ "px";
	$left = Math.max(0,
			((jQuery(window).width() - jQuery("#msg").outerWidth()) / 2)
					+ jQuery(window).scrollLeft())
			+ "px";
	jQuery("#msg").css("left", $left);
	jQuery("#msg").animate({
		opacity : 0.6,
		top : $top
	}, 400, function() {
		jQuery(this).css({
			'opacity' : 1
		});
	}).show();
	setTimeout(function() {
		jQuery("#msg").animate({
			opacity : 0.6,
			top : "0px"
		}, 400, function() {
			jQuery(this).hide();
		});
	}, 1000);
}
</script>
@endsection