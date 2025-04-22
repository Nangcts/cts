<?php

$yt = $_GET['n'];

if(isset($yt)){
    $str = "<object width='100%' height='400'><param name='movie' value='https://www.youtube.com/v/".$yt."?version=3&amp;hl=en_US&amp;rel=0&autoplay=0'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed wmode='opaque' src='https://www.youtube.com/v/".$yt."?version=3&amp;hl=en_US&amp;rel=0&autoplay=0' width='100%' height='400' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true'></embed></object>";
    echo $str;
}

?>