$(document).ready(function () {
    $('.cart.button')
        .popup({
            position: "bottom right",
            lastResort: 'bottom right',
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
    
    $('.js-slider').slick({
        dots: true
    });

    $('#menu-mob').slicknav({
        appendTo: '.main-menu',
        label: ''
    });

    $('.ui.dropdown').dropdown({
        action: 'hide'
    });    
});