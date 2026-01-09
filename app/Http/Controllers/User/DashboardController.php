<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\UserDashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected UserDashboardService $dashboardService
    ) {
    }

    /**
     * Display the user dashboard.
     */
    public function index(Request $request)
    {
        $data = $this->dashboardService->getOverviewData($request->user());

        return view('dashboard.index', $data);
    }
}
