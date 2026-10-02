<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Visitor;
use App\Models\Preloved\Product as PrelovedProduct;
use App\Models\Seller\Product as SellerProduct;
use App\Models\Seller\Store;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $totalProducts = SellerProduct::count() + PrelovedProduct::count();
        $activeProducts = SellerProduct::where('status', 'active')->count()
            + PrelovedProduct::where('status', 'active')->count();
        $totalStores = Store::count();
        $totalDrafts = SellerProduct::where('status', 'draft')->count()
            + PrelovedProduct::where('status', 'draft')->count();

        $approvedStartDate = $now->copy()->subDays(29)->startOfDay();
        $approvedProducts30Days = SellerProduct::where('status', 'active')
            ->whereBetween('approved_at', [$approvedStartDate, $now])
            ->count();
        $approvedPreloved30Days = PrelovedProduct::where('status', 'active')
            ->whereBetween('approved_at', [$approvedStartDate, $now])
            ->count();
        $approvedProducts30DaysLabel = number_format(
            $approvedProducts30Days + $approvedPreloved30Days,
            0,
            ',',
            '.'
        );

        // Total pengunjung unik bulan ini.
        $pengunjungBulanIni = Visitor::whereYear('visit_date', $now->year)
            ->whereMonth('visit_date', $now->month)
            ->count();

        // Data trafik unik 30 hari terakhir.
        $startDate = $now->copy()->subDays(29)->toDateString();
        $endDate = $now->toDateString();

        $visitorStats = Visitor::whereBetween('visit_date', [$startDate, $endDate])
            ->selectRaw('DATE(visit_date) as visit_day, COUNT(*) as total_visitors')
            ->groupBy('visit_date')
            ->get()
            ->keyBy('visit_day');

        $chartLabels = [];
        $chartVisitors = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dateString = $date->toDateString();

            $chartLabels[] = $date->translatedFormat('d M');

            $stat = $visitorStats->get($dateString);
            $chartVisitors[] = $stat ? (int) $stat->total_visitors : 0;
        }

        // Pertumbuhan pengunjung unik dibandingkan bulan sebelumnya.
        $lastMonth = $now->copy()->subMonth();
        $lastMonthVisitors = Visitor::whereYear('visit_date', $lastMonth->year)
            ->whereMonth('visit_date', $lastMonth->month)
            ->count();

        $persentasePertumbuhan = 0;

        if ($lastMonthVisitors > 0) {
            $persentasePertumbuhan = round(
                (($pengunjungBulanIni - $lastMonthVisitors) / $lastMonthVisitors) * 100,
                1
            );
        } elseif ($pengunjungBulanIni > 0) {
            $persentasePertumbuhan = 100;
        }

        $latestProducts = SellerProduct::with('owner')
            ->latest()
            ->limit(4)
            ->get();
        $latestPrelovedProducts = PrelovedProduct::with('owner')
            ->latest()
            ->limit(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'totalStores',
            'approvedProducts30DaysLabel',
            'totalDrafts',
            'pengunjungBulanIni',
            'chartLabels',
            'chartVisitors',
            'persentasePertumbuhan',
            'latestProducts',
            'latestPrelovedProducts'
        ));
    }
}
