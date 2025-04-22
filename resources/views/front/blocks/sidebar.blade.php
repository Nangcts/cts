<div id="blog-side" class="col-left sidebar col-sm-3 blog-side" >
    <div id="secondary" class="widget_wrapper13" role="complementary">
        <div class="popular-posts">
            <h2 class="widget-title">Bài viết mới nhất</h2>
            <div class="widget-content">
                <ul class="posts-list unstyled clearfix">
                    @foreach(App\Article::orderBy('created_at','desc')->take(6)->get() as $item)
                    <li>
                        <figure class="featured-thumb"> <a href="{{ route('allRoute',$item->slug) }}" title="{{ $item->title }}"> <img src="{{ asset('upload/filemanager/article/'.$item->image) }}" alt="{{ $item->image }}"> </a> </figure>
                        <div class="content-info">
                            <h4><a href="{{ route('allRoute',$item->slug) }}" title="Lorem ipsum dolor sit amet">{{ $item->title }}</a></h4>
                            <p class="post-meta">
                                <time class="entry-date">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</time> .
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!--widget-content-->
        </div>
    </div>
</div>