function markNotificationAsRead(notificationCount) {
    if (notificationCount !== '0') {
        $.get('/markAsRead');
    }
}

function LoadYoutube(n) {
    jQuery("#youtube").load("getdata.php?n=" + n)
}

function format_price($price) {
    return number_format($price, 0, ',', '.');
}

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
$(document).ready(function () {
    var height = $(window).height();
    $('section#main-content').css('min-height', height - 38);
});

$(document).ready(function () {
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

    function goBack() {
        window.history.back();
    }
    if ($('ul.sub li.active').hasClass('active')) {
        $('ul.sub li.active').parent('ul').attr('style', 'display:block');
        $('ul.sub li.active').parent().prev('.dcjq-parent').addClass('active');

    }
});

$(document).ready(function () {
    $("p.alert").delay(6000).slideUp();

    function confirmdelete(msg) {
        if (window.confirm(msg)) {
            return true;
        }
        return false;
    }
    var height = $(window).height();

    $('.mobile-body img').height(400);

    $('#btnaddimage').click(function () {
        $('.new-img').append('<div class="form-group"><input type="file" name="fImagesDetail[]" class="Editdetail"></div>');
    });

    $('#btn_add_link').click(function () {
        $('#new-menu-item').prepend('<div class = "txtnewmenuitem"><hr /><span><label>Tiêu đề</label><input type="text" name="txtNewTitle" id="input" class="form-control" placeholder ="Tiêu đề menu" value=""  title="" /></span><span><label>Đường dẫn</label><input type="text" name="txtNewLink" id="input" class="form-control" placeholder = "nhập dạng: http://tenmien.com" value=""  title="" /></span><span><label>Thứ tự</label><input type="text" name="txtNewOrder" id="input" class="form-control" placeholder = "Nhập số thứ tự" value=""  title="" /></span></div>');
    });
});
$(document).ready(function () {
    // Edit ORDER
    $('.btn-edit-order').on('click', function () {
        var baseUrl = document.location.origin;
        var url = baseUrl + "/admin/edit/edit-order/";
        var token = $("input[name='_token']").val();
        var get_id = $(this).attr('id');
        var check = $("input[id = " + get_id + "]").attr('name');
        var order = $("input[id = " + get_id + "]").val();

        $.ajax({
            url: url + get_id,
            type: 'POST',
            cache: false,
            data: {
                "_token": token,
                "order": order,
                "edit_id": get_id,
                "check": check
            },
            success: function (data) {
                if (data == 'fail') {
                    alert('Xảy ra lỗi');

                } else {
                    $("#edit-order-" + get_id).html(data);
                    $(".close").trigger("click");
                }
            }
        });
    });
});
// Frontend JS ===========================================================================*/
$(document).ready(function () {
    $(".various").fancybox({
        type: "iframe", //<--added
        maxWidth: 800,
        maxHeight: 600,
        fitToView: false,
        width: '70%',
        height: '70%',
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none'
    });
    // Refresh Captcha
    $(".btn-refresh").click(function () {
        $.ajax({
            type: 'GET',
            url: '/refresh_captcha',
            success: function success(data) {
                $(".captcha span").html(data.captcha);
            }
        });
        var height = $(window).height();
        $('section#main-content').css('min-height', height - 38);
    });
    /* ================ Menu Mobile ================ */
    $(".nav-navbar").mmenu({
        // options
    }, {
        // configuration
        clone: true
    });
    $('.mm-listview').removeClass('ruby-menu')
    var API = $("#mm-bs-navbar").data("mmenu");

    $("#hamburger").on("click", function () {
        API.open();

    });
    // Owlcarousel Fron =================================================================//}
    $('.product-items .owl-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            560: {
                items: 3
            },
            768: {
                items: 4
            },
            1000: {
                items: 4
            }
        }
    })
    $('#list_newest_news .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            560: {
                items: 2
            },
            768: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    })

    $('#home_page_posts .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            560: {
                items: 2
            },
            768: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    })
    $('.testimonial .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            560: {
                items: 2
            },
            768: {
                items: 2
            },
            1000: {
                items: 2
            }
        }
    })

    $('#home_page_products .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            560: {
                items: 3
            },
            768: {
                items: 4
            },
            1000: {
                items: 4
            }
        }
    })
    $('#list_offer_products .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            560: {
                items: 3
            },
            768: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    })
    $('.blog-list-wrap .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 2
            },
            380: {
                items: 2
            },
            480: {
                items: 2
            },
            600: {
                items: 3
            },
            768: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    })
    $('#slider .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        items: 1,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: false,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
    })
    function learnTab() {
        $("[data-learn-tab]").length > 0 && ($("[data-learn-tab]").on("mouseover click ontouchstart", function() {
            var t = $(this),
            a = t.attr("data-learn-tab"),
            i = $(a),
            e = i.closest(".tab-element-content"),
            o = t.closest(".circle-container");
            e.find(".for-tab").removeClass("active"),
            o.find("[data-learn-tab]").removeClass("active"),
            t.addClass("active"),
            i.addClass("active"),
            e.find(".for-tab.start").hide()
        }))
    }

    function learTabMB() {
        $("[data-learn-tab]").on("mouseleave click", function() {
            var t = $(this),
            a = t.attr("data-learn-tab"),
            i = $(a),
            e = i.closest(".tab-element-content");
            t.closest(".circle-container");
            t.removeClass("active"), i.removeClass("active"), e.find(".for-tab.start").show()
        })
    }

    function drawCircleMy() {
        $(".learning-elements-wrap").length > 0 && $(".learning-elements-wrap").each(function() {
            var t = $(this).width();
            $(this).css("height", t), updateLayout(t)
        })
    }

    function initEvents() {
        $(function() {
            drawCircleMy(),
            learnTab()
        }),
        $(window).on("load", function() {}),
        $(window).on("resize", function() {
            setTimeout(drawCircleMy, 400);
            if ($(window).width() > 1025) {
                learTabMB()
            }
        })
    }
    var updateLayout = function(t) {
        var a = $(".learning-elements-wrap .learning-item");
        if ($(window).width() > 991)
            for (var i = 0; i < a.length; i++) {
                var e = 360 / a.length,
                o = e * i;
                $(a[i]).css("transform", "rotate(" + o + "deg) translate(0, -" + (t / 2 - 40) + "px) rotate(-" + o + "deg)")
            } else
            for (var i = 0; i < a.length; i++) {
                var e = 360 / a.length,
                o = e * i;
                $(a[i]).css("transform", "rotate(" + o + "deg) translate(0, -" + (t / 2 - 15) + "px) rotate(-" + o + "deg)")
            }
        };
        initEvents();
    });
