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
		$data_analytics = [];
	
		try {
			$data_analytics['active'] = Analytics::getAnalyticsService()->data_realtime->get(
				'properties/' . env('ANALYTICS_MEASUREMENT_ID') . '/realtime',
				'rt:activeVisitors'
			);
		} catch (\Exception $e) {
			\Log::warning('Analytics error (active): ' . $e->getMessage());
			$data_analytics['active'] = null;
		}
	
		try {
			$data_analytics['total_page_views'] = Analytics::fetchTotalVisitorsAndPageViews(Period::days(10));
		} catch (\Exception $e) {
			\Log::warning('Analytics error (total_page_views): ' . $e->getMessage());
			$data_analytics['total_page_views'] = collect();
		}
	
		try {
			$today = Analytics::fetchTotalVisitorsAndPageViews(Period::days(0));
			$data_analytics['today'] = $today[0] ?? 0;
		} catch (\Exception $e) {
			\Log::warning('Analytics error (today): ' . $e->getMessage());
			$data_analytics['today'] = 0;
		}
	
		try {
			$data_analytics['top_visited_pages'] = Analytics::fetchMostVisitedPages(Period::days(7), 6);
		} catch (\Exception $e) {
			\Log::warning('Analytics error (top_visited_pages): ' . $e->getMessage());
			$data_analytics['top_visited_pages'] = collect();
		}
	
		try {
			$data_analytics['devices'] = GoogleAnalytics::fetchDeviceVisitors(Period::days(29));
		} catch (\Exception $e) {
			\Log::warning('Analytics error (devices): ' . $e->getMessage());
			$data_analytics['devices'] = collect();
		}
	
		try {
			$data_analytics['organic_search'] = GoogleAnalytics::fetchOrganicSearch(Period::days(29));
		} catch (\Exception $e) {
			\Log::warning('Analytics error (organic_search): ' . $e->getMessage());
			$data_analytics['organic_search'] = collect();
		}
	
		try {
			$monthData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
			$data_analytics['month_visitor'] = $monthData->sum('visitors');
		} catch (\Exception $e) {
			\Log::warning('Analytics error (month_visitor): ' . $e->getMessage());
			$data_analytics['month_visitor'] = 0;
		}
	
		$startDate = \Carbon\Carbon::now()->startOfMonth();
		$endDate = \Carbon\Carbon::now();
	
		try {
			if ($startDate == $endDate) {
				$monthVisitors = Analytics::fetchTotalVisitorsAndPageViews(Period::day(0));
			} else {
				$monthVisitors = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $endDate));
			}
			$data_analytics['month_visitors'] = $monthVisitors->sum('visitors');
		} catch (\Exception $e) {
			\Log::warning('Analytics error (month_visitors): ' . $e->getMessage());
			$data_analytics['month_visitors'] = 0;
		}
	
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
