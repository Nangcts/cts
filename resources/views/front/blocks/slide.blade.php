<section id="slider">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 categories-menu hidden-xs">
				<aside class="menu_products">
					<div class="ruby-wrapper ruby-vertical">
						<ul class="ruby-menu ruby-vertical">
							@foreach (App\Category::where('parent_id',0)->orderBy('sort_order','asc')->get() as $catalog)
							<li class="ruby-menu-mega"><a href="{{ route('allRoute', $catalog->slug) }}" title="{{ $catalog->name }}"><i class="fa fa-{{ $catalog->icon }} mr-7"></i>{{ $catalog->name }}</a>
								<?php $sub_cate_1 =  App\Category::where('parent_id',$catalog->id)->orderBy('sort_order','asc')->get() ?>
								@if($sub_cate_1->first())
								<div class="ruby-grid ruby-grid-lined">
									<div class="ruby-row">
										@foreach ($sub_cate_1 as $item_lv1)
										<div class="ruby-col-3 hidden-md">
											<h3 class="ruby-list-heading"><a href="{{ route('allRoute', $item_lv1->slug) }}" title="{{ $item_lv1->name }}">{{ $item_lv1->name }}</a></h3>
											<?php $sub_cate_2 = App\Category::where('parent_id',$item_lv1->id)->orderBy('sort_order','asc')->get() ?>
											@if($sub_cate_2->first())
											<ul>
												@foreach ($sub_cate_2 as $item_lv2)
												<li><a href="{{ route('allRoute', $item_lv2->slug) }}" title="{{ $item_lv2->name }}">{{ $item_lv2->name }}</a></li>
												@endforeach
											</ul>
											@endif
										</div>
										@endforeach
									</div>
								</div>
								@endif
							</li>
							@endforeach

						</ul>
					</div>
				</aside>
			</div>
			<div class="col-lg-9 slider col-xs-12">
				@if(App\Slider::GetAllSlide())
				<div class="owl-carousel">
					@foreach (App\Slider::GetAllSlide() as $item)
					<a href="{{ $item->link }}">
						<img src="{{ asset('upload/filemanager/slider/'.$item->slide) }}" alt="">
					</a>
					@endforeach
				</div>
				@endif
			</div>
		</div>
	</div>
</section>