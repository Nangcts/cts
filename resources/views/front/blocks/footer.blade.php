<footer class="page-footer">
    <div id="footer" class="footer-container layout2 footer">
        <div class="footer-top">
            <div class="footer2 box-parallax">
                <div class="container">
                    <div class="main-footer2">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="footer-box2">
                                    <h2 class="title18 font-bold color">CTS GROUP</h2>
                                    <p class="desc white">{!! print_block(4) !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="footer-box2">
                                    <h2 class="title18 font-bold color">Thông tin liên hệ</h2>
                                    <div class="contact-footer2">
                                        <p class="desc white"><span class="color"><i class="fa fa-map-marker"></i></span>{{ $config->adress }} </p>
                                        <p class="desc white"><span class="color"><i class="fa fa-phone"></i></span>{{ $config->phone }}</p>
                                        <p class="desc white"><span class="color"><i class="fa fa-envelope"></i></span><a class="white" href="#">{{ $config->email }}</a></p>
                                        <p class="desc white"><span class="color"><i class="fa fa-clock"></i></span> Giờ làm việc: 8h00 - 17h30p Từ T2 - T7</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="footer-box2 clearfix">
                                    <h2 class="title18 font-bold color">Theo dõi CTSGROUP</h2>
                                    <div class="fb-page" data-href="{{ $config->facebook }}" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="{{ $config->facebook }}" class="fb-xfbml-parse-ignore"><a href="{{ $config->facebook }}">Facebook</a></blockquote></div>
                                </div>
                                <div class="social-network footer-box2 clearfix" style="margin-top: 15px;">
                                    <h2 class="title18 font-bold color">Kết nối với chúng tôi</h2>
                                    <a class="float-shadow" href="#"><img src="{{ asset('images/icon/icon-fb.png') }}" alt=""></a>
                                    <a class="float-shadow" href="#"><img src="{{ asset('images/icon/icon-tw.png') }}" alt=""></a>
                                    <a class="float-shadow" href="#"><img src="{{ asset('images/icon/icon-pt.png') }}" alt=""></a>
                                    <a class="float-shadow" href="#"><img src="{{ asset('images/icon/icon-gp.png') }}" alt=""></a>
                                    <a class="float-shadow" href="#"><img src="{{ asset('images/icon/icon-ig.png') }}" alt=""></a>
                                </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-lg-12 nas">
                                    {!! print_block(16) !!}
                                </div>
                            </div>
                        </div>
                        <!-- End Main Footer -->
                        <div class="logo-footer2 text-center"><a class="pulse" href="#"><img src="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}" alt=""></a></div>
                        <div class="bottom-footer2 text-center">
                            <p class="copyright2 desc white">© {{ date('Y') }} Bản quyền thuộc về CTS GROUP</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>