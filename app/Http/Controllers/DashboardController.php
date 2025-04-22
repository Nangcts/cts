<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;

use URL;

use DB;

use File;

use Spatie\Analytics\Period;
use Analytics;
use App\Libraries\GoogleAnalytics;

class DashboardController extends Controller
{
	public function getDashboard() {
		$data_analytics['active'] = Analytics::getAnalyticsService()->data_realtime->get('ga:'.env('ANALYTICS_VIEW_ID'), 'rt:activeVisitors')->totalsForAllResults['rt:activeVisitors'];
		
		$data_analytics['total_page_views'] = Analytics::fetchTotalVisitorsAndPageViews(Period::days(10));
		
		$data_analytics['today'] = Analytics::fetchTotalVisitorsAndPageViews(Period::days(0));
		

        if (!$data_analytics['today']){
            $data_analytics['today'] = $data_analytics['today'][0];
        } else {
            $data_analytics['today'] = 0;
        }
		
		
		$data_analytics['top_visited_pages'] = Analytics::fetchMostVisitedPages(Period::days(7), 6);
		
		$data_analytics['devices'] = GoogleAnalytics::fetchDeviceVisitors(Period::days(29));
		$data_analytics['organic_search'] = GoogleAnalytics::fetchOrganicSearch(Period::days(29));
		$data_analytics['month_visitor'] = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
		$data_analytics['month_visitor'] = $data_analytics['month_visitor']->sum('visitors');
        
		$startDate =  \Carbon\Carbon::now()->startOfMonth();
		$endDate = new \Carbon\Carbon('now');
        
		if($startDate == $endDate) {
			$data_analytics['month_visitors'] = Analytics::fetchTotalVisitorsAndPageViews(Period::day(0));
		} else {
			$data_analytics['month_visitors'] = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $endDate));
		}
		$data_analytics['month_visitors'] = $data_analytics['month_visitors']->sum('visitors');
		
		

		return view('admin.dashboard.dashboard', compact('data_analytics'));
	}



	public function fetchDeviceVisitors(Period $period): Collection
	{
		$response = $this->performQuery(
			$period,
			'ga:users',
			['dimensions' => 'ga:deviceCategory']
		);

		return collect($response['rows'] ?? [])
		->map(function (array $pageRow) {
		});
	}

	public function updateSiteMap ()
	{
		// create new sitemap object
		$sitemap = App::make('sitemap');

	// set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
	// by default cache is disabled
		$sitemap->setCache('laravel.sitemap', 60);

	// check if there is cached sitemap and build new only if is not
		if (!$sitemap->isCached()) {
		// add item to the sitemap (url, date, priority, freq)
			$sitemap->add(URL::to('/'), \Carbon\Carbon::now(), '1.0', 'daily');
		// get all Catalog from db
			$catalogs = DB::table('catalog')->orderBy('created_at', 'desc')->get();

		// add every post to the sitemap
			foreach ($catalogs as $catalog) {
				$sitemap->add(route('allRoute', $catalog->slug), $catalog->updated_at, '0.8' , 'daily');
			}
		// get all Catalog from db
			$cates = DB::table('cate')->orderBy('created_at', 'desc')->get();

		// add every post to the sitemap
			foreach ($cates as $cate) {
				$sitemap->add(route('allRoute', $cate->slug), $cate->updated_at, '0.8' , 'daily');
			}
		// get all posts from db
			$posts = DB::table('article')->orderBy('created_at', 'desc')->get();

		// add every post to the sitemap
			foreach ($posts as $post) {
				$sitemap->add(route('allRoute', $post->slug), $post->updated_at, '0.6' , 'daily');
			}

		// get all posts from db
			$products = DB::table('products')->orderBy('created_at', 'desc')->get();

		// add every post to the sitemap
			foreach ($products as $product) {
				$sitemap->add(route('allRoute', $product->slug), $product->updated_at, '0.6' , 'daily');
			}
		}

		$sitemap->store('xml', 'sitemap');
		if (File::exists(public_path() . '/sitemap.xml')) {
			chmod(public_path() . '/sitemap.xml', 0777);
		}

		return redirect()->route('dashboard');
	}

}
