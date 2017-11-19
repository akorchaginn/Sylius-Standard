$(document).ready(function () {
    $('.cart.button')
        .popup({
            position: "bottom left",
            lastResort: 'bottom left',
            popup: $('.cart.popup'),
            on: 'click',
        })
    $("button[name=submit]").click(function(){
        var baseId = this.id;
        var quantitySelector = 'input#'+baseId;
        $('#sylius_add_to_cart_cartItem_variant').val(baseId);
        $('#sylius_add_to_cart_cartItem_quantity').val($(quantitySelector).val());
    });
        
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});