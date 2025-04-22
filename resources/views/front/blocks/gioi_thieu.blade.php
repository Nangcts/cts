<div class="box-about-us clearfix"> 
    <div class="container">
        <h2 class="title-box aos-init" data-aos="fade-up"><span>GIỚI THIỆU - DỊCH VỤ</span></h2>
        <div class="box-about-us-content clearfix">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">  {!! get_block_img(6) !!}</div>
                        <div class="col-md-6">
                            <div class="content-a clearfix aos-init" data-aos="fade-right">
                                {!! print_block(6) !!}<a href="{{ get_block_link(6) }}" data-aos="fade-right" class="read-more aos-init">Chi tiết <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="row">
                        <?php  
                        $dichvu = App\Cate::where('parent_id', 101)->orderBy('sort_order')->get();
                        ?>
                        @foreach ($dichvu as $item)
                        <li class="col-md-6 tieu-chi aos-init" data-aos="fade-up"> <img src="{{ asset('images/icon-5.png') }}" alt="CÙNG NHAU PHÁT TRIỂN"> <a href="{{ route('allRoute', $item->slug) }}"><span>{{ $item->name }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>