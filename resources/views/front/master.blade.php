<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $config->analytics }}"></script><script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $config->analytics }}');
    </script>
    @yield('og')
    <meta property=”fb:app_id” content="1595608977182021" />
    <meta property=”fb:admins” content="100000465372582">

    <meta name="description" content="@yield('des')" />

    <link rel="icon" type="image/png" href="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}" />
    <link rel="canonical" href="#" />

    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts/icofont/icofont.min.css') }}">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/owlcarousel/dist/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300i,400i,500i,700i&display=swap&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/mmenu/jquery.mmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mmenu/jquery.mmenu.all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mmenu_custom.css') }}">
    <link href="{{ asset('css/mega-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/ruby-vertical.css') }}" rel="stylesheet" type="text/css">
    @yield('css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="page-index @yield('body-class')">
    <div class="page">
        @include('front.blocks.header')
        @yield('slide')
        <main id="main-page">
            @yield('content')
        </main>
        @include('front.blocks.footer')
    </div>
</div>
<!-- Script For All Pagé -->
<script src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/owlcarousel/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/mmenu/jquery.mmenu.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/frontend.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js" type="text/javascript"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5f0520e1223d045fcb7b81bc/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=1595608977182021&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Load Facebook SDK for JavaScript -->
@include('front.blocks.click-call')
@include('front.blocks.zalo')
@include('front.blocks.facebookchat')
@yield('js')
</body>

</html>
