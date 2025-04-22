function markNotificationAsRead(notificationCount) {
    if(notificationCount !=='0'){
        $.get('/markAsRead');
    }
}

function LoadYoutube(n) {
    jQuery("#youtube").load("getdata.php?n=" + n)
}

$(document).ready(function () {
    var height = $(window).height();
    $('section#main-content').css('min-height', height - 38);
});
    
$(document).ready(function () {

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

    function confirmdelete (msg) {
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