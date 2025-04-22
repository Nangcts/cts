function initialise() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
    $('#ban_tiec').DataTable({
        responsive: true
    });
    $('#ban_tiec_finish').DataTable({
        responsive: true
    });
    $('#transaction').DataTable({
        responsive: true
    });
}
jQuery(document).ready(function ($) {
    $("div.alert").delay(3000).slideUp();
    $(document).on("click", ".qty-down", function () {
        var getid = $(this).attr('id');
        var getqty = $("input[id = " + getid + "]").val();
        var addqty = parseInt(getqty) - 1;
        $("input[id = " + getid + "]").val(addqty);
        $("input[id = " + getid + "]").trigger("change");
    });
    $(document).on("click", ".qty-up", function () {
        var getid = $(this).attr('id');
        var getqty = $("input[id = " + getid + "]").val();
        var addqty = parseInt(getqty) + 1;
        $("input[id = " + getid + "]").val(addqty);
        $("input[id = " + getid + "]").trigger("change");

    });

    $(document).on("change", ".tbl-cart input[name='qty']", function () {
        var qty = $(this).val();
        var rowId = $(this).attr('id');
        var _token = $("form[name='frm_cart'] input[name='_token']").val();
        $.ajax({
            type: "GET",
            url: 'update/' + rowId + '/' + qty,
            data: {
                "_token": _token,
                "rowId": rowId,
                "qty": qty
            },
            success: function (data) {

                $('form[name="frm_cart"] .cart-control').html(data);
            }
        });
    });

    $(document).ready(function () {
        var height = $(window).height();
        $('section#main-content').css('min-height', height - 38);
    });


});
