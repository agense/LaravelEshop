<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\StatisticsService;

class DashboardController extends Controller
{
    /**
     * Show the application admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatisticsService $stService)
    {
        $data = $stService->getDashboardStatistics();
        return view('admin.dashboard', compact("data"));
    }
}
