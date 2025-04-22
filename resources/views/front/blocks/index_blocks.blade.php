<section class="block-icon clear-both margin-15">
    <div class="container">
        <h3 class="title margin-25">Tại sao chọn chúng tôi</h3>
        <ul class="row list-job float-left margin-25">
            <li class="col-md-4 col-sm-12 col-xs-12">
                <div class="jobsWrp text-center">
                    <div class="icon-box-img has-icon-bg">
                        <div class="job-icon">{{ get_block_img(8) }}</div>
                    </div>
                    <div class="jobTitle"><a href="#">{{ get_block_title(8) }}</a></div>
                    <div class="text-intro">{{ print_block(8) }}</div>
                </div>
            </li>
            <li class="col-md-4 col-sm-12 col-xs-12">
                <div class="jobsWrp text-center">
                    <div class="icon-box-img has-icon-bg">
                        <div class="job-icon">{{ get_block_img(9) }}</div>
                    </div>
                    <div class="jobTitle"><a href="#">{{ get_block_title(9) }}</a></div>
                    <div class="text-intro">{{ print_block(9) }}</div>
                </div>
            </li>
            <li class="col-md-4 col-sm-12 col-xs-12">
                <div class="jobsWrp text-center">
                    <div class="icon-box-img has-icon-bg">
                        <div class="job-icon">{{ get_block_img(11) }}</div>
                    </div>
                    <div class="jobTitle"><a href="#">{{ get_block_title(11) }}</a></div>
                    <div class="text-intro">{{ print_block(11) }}</div>
                </div>
            </li>

        </ul>
    </div>
</section>
<section class="section-intro margin-25">
    <div class="container">
        <div class="row">

            <div class="col-sm-5 col-xs-12 col-intro-img">
                <div class="inner">
                    <a href="">
                        {!! get_block_img(12) !!}
                    </a>
                </div>
            </div>
            <div class="col-sm-7 col-xs-12 col-intro-text">
                <div class="inner">
                    <h1 class="intro-title">
                        {{ get_block_title(12) }}
                    </h1>
                    <div class="intro-content">
                        <ul class="headerline-services">
                            <li>
                                <div class="icon-service">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(rgba(255, 255, 255, 0.5) 0px 0px 10px);" width="65" height="65" viewbox="0 0 200 173.20508075688772"><path fill="#DD4242" d="M0 86.60254037844386L50 0L150 0L200 86.60254037844386L150 173.20508075688772L50 173.20508075688772Z"></path></svg>
                                    <i class="icofont-microphone-alt"></i>
                                </div>
                                <div class="short-des">
                                    <h4>Cho thuê thiết bị âm thanh, ánh sáng</h4>
                                    <p>Luôn đổi mới, tậm tâm làm việc để nâng cao chất lượng dịch vụ là kim chỉ nam cho mọi hành động của MKTECH</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon-service">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(rgba(255, 255, 255, 0.5) 0px 0px 10px);" width="65" height="65" viewbox="0 0 200 173.20508075688772"><path fill="#DD4242" d="M0 86.60254037844386L50 0L150 0L200 86.60254037844386L150 173.20508075688772L50 173.20508075688772Z"></path></svg>
                                    <i class="icofont-people"></i>
                                </div>
                                <div class="short-des">
                                    <h4>Tổ chức sự kiện trọn gói</h4>
                                    <p>Luôn đổi mới, tậm tâm làm việc để nâng cao chất lượng dịch vụ là kim chỉ nam cho mọi hành động của MKTECH</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon-service">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(rgba(255, 255, 255, 0.5) 0px 0px 10px);" width="65" height="65" viewbox="0 0 200 173.20508075688772"><path fill="#DD4242" d="M0 86.60254037844386L50 0L150 0L200 86.60254037844386L150 173.20508075688772L50 173.20508075688772Z"></path></svg>
                                    <i class="icofont-kid"></i>
                                </div>
                                <div class="short-des">
                                    <h4>Cung cấp ca sĩ, nhóm múa</h4>
                                    <p>Luôn đổi mới, tậm tâm làm việc để nâng cao chất lượng dịch vụ là kim chỉ nam cho mọi hành động của MKTECH</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon-service">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(rgba(255, 255, 255, 0.5) 0px 0px 10px);" width="65" height="65" viewbox="0 0 200 173.20508075688772"><path fill="#DD4242" d="M0 86.60254037844386L50 0L150 0L200 86.60254037844386L150 173.20508075688772L50 173.20508075688772Z"></path></svg>
                                    <i class="icofont-ui-movie"></i>
                                </div>
                                <div class="short-des">
                                    <h4>Cho thuê thiết bị phục vụ sự kiện</h4>
                                    <p>Luôn đổi mới, tậm tâm làm việc để nâng cao chất lượng dịch vụ là kim chỉ nam cho mọi hành động của MKTECH</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="intro-btn text-center padding-20">
                        <a type="button" href="tel:{{ $config->hotline }}"><i class="fa fa-phone"></i> HOTLINE: {{ $config->hotline }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

