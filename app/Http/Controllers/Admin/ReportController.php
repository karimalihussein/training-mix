<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Get basic stats
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => 100,
        ];

        // Get recent activity
        $recentActivity = $this->getRecentActivity();

        // Get sales data for charts
        $salesData = $this->getSalesData();

        return Inertia::render('Admin/Reports/Index', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'salesData' => $salesData,
        ]);
    }

    public function sales()
    {
        $salesData = $this->getSalesData();
        $topProducts = $this->getTopProducts();

        return Inertia::render('Admin/Reports/Sales', [
            'salesData' => $salesData,
            'topProducts' => $topProducts,
        ]);
    }

    public function users()
    {
        $userGrowth = $this->getUserGrowth();
        $userStats = $this->getUserStats();

        return Inertia::render('Admin/Reports/Users', [
            'userGrowth' => $userGrowth,
            'userStats' => $userStats,
        ]);
    }

    public function products()
    {
        $productStats = $this->getProductStats();
        $categoryData = $this->getCategoryData();

        return Inertia::render('Admin/Reports/Products', [
            'productStats' => $productStats,
            'categoryData' => $categoryData,
        ]);
    }

    private function getRecentActivity()
    {
        // This would typically come from an activity log
        // For now, return mock data
        return [
            [
                'action' => 'New user registered',
                'details' => 'john@example.com',
                'time' => Carbon::now()->subMinutes(2)->diffForHumans(),
            ],
            [
                'action' => 'Order completed',
                'details' => 'Order #1234 - $299.99',
                'time' => Carbon::now()->subMinutes(5)->diffForHumans(),
            ],
            [
                'action' => 'Product updated',
                'details' => 'iPhone 15 Pro stock updated',
                'time' => Carbon::now()->subMinutes(10)->diffForHumans(),
            ],
        ];
    }

    private function getSalesData()
    {
        // Get sales data for the last 7 months
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $data[] = [
                'date' => $date->format('Y-m'),
                'sales' => rand(1000, 5000),
                'orders' => rand(50, 200),
                'users' => rand(20, 100),
            ];
        }

        return $data;
    }

    private function getTopProducts()
    {
        // Mock data for top products
        return [
            ['name' => 'iPhone 15 Pro', 'sales' => 234, 'revenue' => 234000],
            ['name' => 'MacBook Air', 'sales' => 156, 'revenue' => 156000],
            ['name' => 'AirPods Pro', 'sales' => 98, 'revenue' => 19600],
            ['name' => 'iPad Air', 'sales' => 87, 'revenue' => 43500],
            ['name' => 'Apple Watch', 'sales' => 76, 'revenue' => 22800],
        ];
    }

    private function getUserGrowth()
    {
        // Mock user growth data
        $data = [];
        $total = 1200;
        for ($i = 6; $i >= 0; $i--) {
            $new = rand(40, 80);
            $total += $new;
            $data[] = [
                'month' => Carbon::now()->subMonths($i)->format('M'),
                'new' => $new,
                'total' => $total,
            ];
        }

        return $data;
    }

    private function getUserStats()
    {
        return [
            'total' => User::count(),
            'active' => User::where('last_login_at', '>=', Carbon::now()->subDays(30))->count(),
            'new_this_month' => User::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
        ];
    }

    private function getProductStats()
    {
        return [
            'total' => Product::count(),
            'in_stock' => Product::where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'low_stock' => Product::where('stock', '<=', 10)->where('stock', '>', 0)->count(),
        ];
    }

    private function getCategoryData()
    {
        // Mock category data
        return [
            ['name' => 'Electronics', 'value' => 400, 'color' => '#3B82F6'],
            ['name' => 'Clothing', 'value' => 300, 'color' => '#10B981'],
            ['name' => 'Books', 'value' => 200, 'color' => '#F59E0B'],
            ['name' => 'Home & Garden', 'value' => 150, 'color' => '#EF4444'],
            ['name' => 'Sports', 'value' => 100, 'color' => '#8B5CF6'],
        ];
    }
}