<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\SolarSystem;
use App\Models\PageContent;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'banners' => Banner::count(),
            'active_banners' => Banner::where('is_active', true)->count(),
            'solar_systems' => SolarSystem::count(),
            'active_solar_systems' => SolarSystem::where('is_active', true)->count(),
            'page_contents' => PageContent::count(),
            'contact_infos' => ContactInfo::count(),
        ];

        $recent_banners = Banner::latest()->take(5)->get();
        $recent_solar_systems = SolarSystem::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_banners', 'recent_solar_systems'));
    }
}
