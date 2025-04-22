@extends('front.master')
@section('title')
{{ $config->site_title }} | Liên hệ
@endsection
@section('keywords')
{{ $config->site_keywords }}
@endsection
@section('des')
{{ $config->site_des }}
@endsection
@section('og')
<meta property="og:url"                content="{{Request::url()}}" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="{{ $config->site_title }}" />
<meta property="og:description"        content="{{ $config->site_des }}" />
<meta property="og:image"              content="{{ asset('public/upload/logo/'.$config->site_logo) }}" />
@endsection

@section('breadcrumbs')
<section class="breadcrumb-region">
    <div class="container">
        <div class="">
            {!! BreadCrumbs::render('contact') !!}
        </div>
    </div>
</section>
@endsection
<!-- Start Content Page -->
@section('content')
<div class="container">
    <div class="contact-page">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="page-login page_cotact">
                <h2 class="title-head-contact"><span>Liên hệ với chúng tôi</span></h2>
                <p class="descripti des_contact">
                    Bạn hãy điền nội dung tin nhắn vào form dưới đây và gửi cho chúng tôi. Chúng tôi sẽ trả lời bạn sau khi nhận được.
                </p>
                <div id="login">
                    <form accept-charset="UTF-8" action="/contact" id="contact" method="post">
                        <input name="FormType" value="contact" type="hidden">
                        <input name="utf8" value="true" type="hidden">
                        <div class="form-signup clearfix">
                            <div class="row group_contact">
                                <fieldset class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input name="contact[name]" placeholder="Họ tên" id="name" class="form-control  form-control-lg" required="" type="text">
                                </fieldset>
                                <fieldset class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input name="contact[email]" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" data-validation="email" id="email" class="form-control form-control-lg" required="" type="email">
                                </fieldset>
                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <textarea name="contact[body]" placeholder="Nội dung" id="comment" class="form-control content-area form-control-lg" rows="15" required=""></textarea>

                                </fieldset>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button tyle="summit" class="btn btn-style btn-primary text-upper">Gửi tin nhắn</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="page_cotact page-right">
                <div class="widget-item info-contact">
                    <div class="section_maps">
                        <h1 class="title-head hidden">Liên hệ</h1>
                        <div class="box-maps">
                            <div class="iFrameMap">
                                <div class="google-map">
                                    <div id="contact_map" class="map" style="position: relative; overflow: hidden;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4429.652252208432!2d105.8592968895681!3d20.99749894607015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac0fa91c7a61%3A0x7e45d2d963bc2cd!2zMzQ2IEtpbSBOZ8awdSwgTWluaCBLaGFpLCBIYWkgQsOgIFRyxrBuZywgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1511851665215" width="600" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .widget-title -->
                    <h2 class="title-head-contact"><span>{{ $config->company_name }}</span></h2>
                    <ul class="widget-menu">

                        <li><span class="ico-left"><i class="fa fa-map-marker color-x" aria-hidden="true"></i></span>
                            <span class="txt-content-add">
                                <span class="bold-color">Địa chỉ:</span> {{$config->adress}}
                            </span>
                        </li>
                        <li><span class="ico-left"><i class="fa fa-mobile-phone color-x" aria-hidden="true"></i></span>
                            <span class="bold-color">Hotline:</span>
                            <a class="rc" href="tel:{{ $config->hotline }}">{{ $config->hotline }}</a>
                        </li>
                        <li><span class="ico-left"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                            <span class="bold-color">Email:</span>
                            <a class="rc" href="mailto:{{ $config->email }}">{{ $config->email }}</a>
                        </li>
                    </ul>

                    <!-- End .widget-menu -->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection