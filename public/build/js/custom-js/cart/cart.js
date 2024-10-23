

$(document).on('click', '.btn-add-cart', function(e) {

    e.preventDefault();
    var productId = $(this).find('a').data('product-id');

    $.ajax({
        url: route('cart.add'),
        type: 'GET',
        async: false,
        dataType: 'json',
        data: { productId: productId},
        success: function(response) {

            if(response.status===true){
                getCartItem();
                toastr.success(response.message)
            }
            else{
                toastr.error(response.message)
            }


        },
        error: function(xhr, status, error) {
            console.log('error',error)
        }
    });


});


getCartItem();
function getCartItem() {
    $.ajax({
        url: 'cart-items',
        type: 'GET',
        async: false,
        dataType: 'json',
        success: function(response) {
        
            if (response.status === true) {
                var html = '';
                var subTotal=0;

                $.each(response.data, function(index, row) {

                    subTotal=parseFloat(subTotal) + parseFloat(row.price)
                    html += `
                        <li>
                            <a href="single-product.html" class="minicart-product-image">
                                <img src="${row.image}" alt="${row.name}">
                            </a>
                            <div class="minicart-product-details">
                                <h6><a href="single-product.html">${row.name}</a></h6>
                                <span>$ ${row.price} x ${row.quantity}</span>
                            </div>
                            <button class="close btn-item-remove" data="${row.id}">
                                <i class="fa fa-close"></i>
                            </button>
                        </li>
                    `;
                });

                // Insert generated HTML into the minicart
                $('#miniCart').html(html);
                $('.subTotal').text('$'+subTotal);

            } else {
                $('#miniCart').html('<p style="color: red">Your cart is empty</p>>');
                toastr.error(response.message);
            }
            $('.cart-item-count').text(response.data.length);
        },
        error: function(xhr, status, error) {
            toastr.error(error);
        }
    });
}



$('#miniCart').on('click', '.btn-item-remove', function() {
    var id = $(this).attr('data');
    $.ajax({
        url: "cart-remove",
        type: 'get',
        async: false,
        dataType: 'json',
        data: { id: id },
        success: function(response) {
            getCartItem();
            toastr.success(response.message);
        },
        error: function(xhr, status, error) {
            var errors = xhr.responseJSON.errors;
            toastr.success(error);
        }
    });

});





