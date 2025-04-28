@extends('master')

@section('content')

<section class="wrapper">
    <section class="panel">
        <div class="col-lg-12 header-page-admin">
            <header class="panel-heading">
                <strong>Sắp xếp sản phẩm theo danh mục</strong>
            </header>
        </div>

        <div class="panel-body">
            <form id="category-form">
                <label for="category_id">Chọn danh mục:</label>
                <select name="category_id" onchange="getProductsByCategory(this.value)" class="form-control" style="width: 300px">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach(App\Category::where('parent_id', 0)->orderBy('sort_order', 'asc')->get() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @foreach(App\Category::where('parent_id', $category->id)->orderBy('sort_order', 'asc')->get() as $child1)
                            <option value="{{ $child1->id }}">&nbsp;&nbsp;↳ {{ $child1->name }}</option>
                            @foreach(App\Category::where('parent_id', $child1->id)->orderBy('sort_order', 'asc')->get() as $child2)
                                <option value="{{ $child2->id }}">&nbsp;&nbsp;&nbsp;&nbsp;↳↳ {{ $child2->name }}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </form>

            <div id="sort-control" style="margin: 20px 0;">
                <a href="javascript:void(0);" id="sort-button" class="btn outlined mleft_no" data-mode="sort">Sắp xếp</a>
                <div id="reorder-helper" class="light_box" style="display:none;">
                    1. Kéo thả để xếp lại sản phẩm.<br>2. Click 'Lưu sắp xếp'.
                </div>
            </div>

            <div id="product-list">
                @if($offer_products->count())
                    <ul class="reorder_ul reorder-photos-list" style="pointer-events: none; opacity: 0.6;">
                        @foreach($offer_products as $item)
                            <li id="{{ $item->id }}" class="ui-sortable-handle col-lg-3 col-md-3 col-sm-3 col-xs-4" style="float: left; width: 100%">
                                <div class="move-icon" style="float: left; margin-right: 15px;">
                                    <i class="fa fa-arrows" aria-hidden="true"></i>
                                </div>
                                <div class="inner" style="float: left; margin-right: 25px; min-width: 350px">
                                    {{ $item->name }}
                                </div>
                                <div class="more-link">
                                    <a style="padding: 5px 12px; border: 1px solid #ccc; float:right; margin-right:50px;" title="Gỡ sản phẩm" class="btn btn-xs" 
                                       href="{{ route('removeOfferProduct', $item->id) }}"
                                       onclick="return confirm('Bạn có chắc sẽ loại sản phẩm này?')">
                                        <i class="fa fa-trash" style="color: red;"></i>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                @endif
            </div>
        </div>
    </section>
</section>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
function initSortingButton() {
    $("ul.reorder-photos-list").sortable({ disabled: true });

    $('#sort-button').off('click').on('click', function(e) {
        e.preventDefault();

        if ($(this).data('mode') === 'sort') {
            $("ul.reorder-photos-list").sortable('enable');
            $("ul.reorder-photos-list").css({ "pointer-events": "auto", "opacity": "1" });
            $(this).html('Lưu sắp xếp').data('mode', 'save');
            $('#reorder-helper').slideDown('slow');
        } else if ($(this).data('mode') === 'save') {
            var ids = [];
            $("ul.reorder-photos-list li").each(function() {
                ids.push($(this).attr('id'));
            });

            $(this).prop('disabled', true).html('<img style="width:25px;" src="{{ asset('images/refresh-animated.gif') }}" /> Đang lưu...');

            $.post("{{ url('/admin/product/reorder-offer-products') }}", {
                ids: ids,
                _token: "{{ csrf_token() }}"
            }, function(response) {
                alert('Sắp xếp thành công!');
                window.location.reload(); // Sau khi lưu xong, reload lại trang
            }).fail(function() {
                alert('Lỗi khi lưu sắp xếp!');
                $('#sort-button').prop('disabled', false).html('Lưu sắp xếp').data('mode', 'save');
            });
        }
    });
}

function getProductsByCategory(categoryId) {
    if (!categoryId) {
        $('#product-list').html('<p>Vui lòng chọn danh mục.</p>');
        return;
    }

    $.ajax({
        url: "{{ route('sortOfferProducts') }}",
        type: "GET",
        data: { category_id: categoryId },
        beforeSend: function() {
            $('#product-list').html('<p>Đang tải sản phẩm...</p>');
        },
        success: function(response) {
            $('#product-list').html(response);
            initSortingButton(); // rất quan trọng: phải gọi lại
            $("ul.reorder-photos-list").sortable({ disabled: true }).css({"pointer-events": "none", "opacity": "0.6"});
            $('#sort-button').html('Sắp xếp').data('mode', 'sort').prop('disabled', false);
            $('#reorder-helper').hide();
        },
        error: function() {
            $('#product-list').html('<p>Không thể tải sản phẩm.</p>');
        }
    });
}

$(document).ready(function() {
    // Khi trang reload, chọn lại danh mục đã lưu
    var selectedCategoryId = localStorage.getItem('selectedCategoryId');
    if (selectedCategoryId) {
        $('select[name="category_id"]').val(selectedCategoryId);
        // Gọi hàm để tải sản phẩm của danh mục đã chọn
        getProductsByCategory(selectedCategoryId);
    }

    // Lưu giá trị danh mục đã chọn vào localStorage
    $('select[name="category_id"]').on('change', function() {
        localStorage.setItem('selectedCategoryId', this.value);
        getProductsByCategory(this.value); // Tải lại sản phẩm khi thay đổi danh mục
    });

    initSortingButton();
});

$(document).ready(function() {
    initSortingButton();
});
</script>

@endsection
