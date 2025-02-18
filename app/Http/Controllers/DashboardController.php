<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $customers = Customer::count();
        $vendors = Vendor::count();
        $products = Product::count();
        $vehicles = Vehicle::count();
        $sales = Sale::count();
        $s_price = Sale::sum('s_total');
        $salesValue = Sale::orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.dashboard.admin', compact('users', 'customers', 'vendors', 'products', 'vehicles', 'sales', 's_price', 'salesValue'));
    }

    public function getChartData()
    {
        // Get sales data for last 7 days
        $salesData = Sale::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Get revenue data for last 7 days
        $revenueData = Sale::selectRaw('DATE(created_at) as date, SUM(s_total) as total')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Get customer data for last 7 days
        $customerData = Customer::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $dates = [];
        $sales = [];
        $revenue = [];
        $customers = [];

        // Fill in data arrays
        for($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;
            $sales[] = $salesData->where('date', $date)->first()->count ?? 0;
            $revenue[] = $revenueData->where('date', $date)->first()->total ?? 0;
            $customers[] = $customerData->where('date', $date)->first()->count ?? 0;
        }

        return response()->json([
            'dates' => $dates,
            'sales' => $sales,
            'revenue' => $revenue,
            'customers' => $customers
        ]);
    }

    public function showBlocks()
    {
        return view('welcome');
    }

}
