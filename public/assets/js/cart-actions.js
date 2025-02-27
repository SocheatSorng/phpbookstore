$(document).ready(function () {
    $('body').on('click', '.remove-item', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        console.log("Removing item using URL:", url);
        var $link = $(this);

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log("Response received:", response);
                if (response.success) {
                    // Remove the list item and update the total.
                    $link.closest('li').fadeOut(function () {
                        $(this).remove();
                        $("#cart-total").text("$" + Number(response.cart_total)
                            .toFixed(2));
                    });
                    // Optionally update the cart count here.
                } else {
                    alert(response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
                alert('There was an error processing your request.');
            }
        });
        return false;
    });
});