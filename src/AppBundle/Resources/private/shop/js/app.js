$(document).ready(function () {
    $('.cart.button')
        .popup({
            position: "bottom right",
            lastResort: 'bottom right',
            popup: $('.cart.popup'),
            on: 'click',
        })
    $("button[name=submit]").click(function () {
        var baseId = this.id;
        var quantitySelector = 'input#' + baseId;
        $('#sylius_add_to_cart_cartItem_variant').val(baseId);
        $('#sylius_add_to_cart_cartItem_quantity').val($(quantitySelector).val());
    });

    $(".clickable-row").click(function () {
        window.location = $(this).data("href");
    });

    $('.js-slider').slick({dots: true,
        autoplay: true,
        autoplaySpeed: 2000
    });

    $('#menu-mob').slicknav({
        appendTo: '.main-menu',
        label: ''
    });

    $('.ui.dropdown').dropdown({
        action: 'hide'
    });

    $('#sylius_checkout_address_shippingAddress_street').on("keyup", $.debounce(750, function (e) {
        queryStr = $("#sylius_checkout_address_shippingAddress_street").val();
        if (queryStr.length >= 4) {
            $("#suggestion_container").html("");
            $("#wrong_address").addClass('hidden');
            $("#suggestion_container").addClass('loading');
            $("#suggestion_container").removeClass('hidden');
            $.get('/integration/addressing/', {value: queryStr}, function (data) {
                if (data.suggestions.length > 0) {
                    $.each(data.suggestions, function(key, item) {
                        data = item.data;
                        if (null != item.data.postal_code) {fullAddress = item.data.postal_code + ', ' + item.unrestricted_value;} else fullAddress = item.unrestricted_value;
                        $("#suggestion_container").append('<p><a href="#" ' +
                            'data-fias="${data.fias_id}" ' +
                            'data-country="${data.country_iso_code}" ' +
                            'data-city="${data.city}" ' +
                            'data-city-fias="${data.city_fias_id}" ' +
                            'data-postcode="${data.postal_code}" ' +
                            'data-full-address="${fullAddress}">${fullAddress}</a></p>');
                    });
                }
                else {
                    $("#wrong_address").removeClass('hidden');
                    $("#suggestion_container").addClass('hidden');
                    $('#sylius_checkout_address_shippingAddress_city').val('Не определено');
                    $('#sylius_checkout_address_shippingAddress_postcode').val('000000');
                    $('#sylius_checkout_address_shippingAddress_provinceCode [value="RU"]').attr('selected', 'selected');
                }

                $("#suggestion_container").removeClass('loading');
            }, "json");
        }
    }));
    
    $('body').on('click', '#suggestion_container a', function (e) {
        var fias = $.trim($(this).data('fias'));
        var postcode = $.trim($(this).data('postcode')) ? $.trim($(this).data('postcode')) : "000000";
        var country = $.trim($(this).data('country'));
        var city = $.trim($(this).data('city'));
        var city_fias = $.trim($(this).data('city-fias'));
        var fullAddress = $.trim($(this).data('full-address'));

        $('#sylius_checkout_address_shippingAddress_city').val(city);
        $('#sylius_checkout_address_shippingAddress_postcode').val(postcode);
        $('#sylius_checkout_address_shippingAddress_fiasCode').val(fias);
        $('#sylius_checkout_address_shippingAddress_street').val(fullAddress);
        $('#sylius_checkout_address_shippingAddress_provinceCode option').each(function(){
            if (this.value == city_fias) {this.selected = true; return false;} else if (this.value == country) {this.selected = true;}
        });
        $("#suggestion_container").addClass('hidden');
        return false;
    })
});