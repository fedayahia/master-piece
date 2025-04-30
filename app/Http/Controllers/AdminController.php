<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PrivateSession;

use Carbon\Carbon;


class AdminController extends Controller
{
    public function index()
    {
        $payments = $this->getPaymentData();

        $users = $this->getUserData();

        $privateSessionsCount = PrivateSession::count();

        $coursesCount = Course::count();

        return view('admin.dashboard', array_merge(
            $payments,
            $users,
            ['coursesCount' => $coursesCount, 'privateSessionsCount' => $privateSessionsCount] 
        ));
    }

    private function getPaymentData()
    {
        $total = Payment::sum('amount');

        $currentMonth = Payment::whereMonth('created_at', now()->month)->sum('amount');
        $lastMonth = Payment::whereMonth('created_at', now()->subMonth()->month)->sum('amount');
        $growth = $lastMonth > 0 ? round(($currentMonth - $lastMonth) / $lastMonth * 100) : 100;

        $months = [];
        $amounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            $amounts[] = Payment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
        }

        return [
            'totalPayments' => $total,
            'paymentGrowth' => $growth,
            'paymentMonths' => $months,
            'paymentAmounts' => $amounts
        ];
    }

    private function getUserData()
    {
        $total = User::count();

        $currentMonth = User::whereMonth('created_at', now()->month)->count();
        $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $growth = $lastMonth > 0 ? round(($currentMonth - $lastMonth) / $lastMonth * 100) : 100;

        $months = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            $counts[] = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'totalUsers' => $total,
            'userGrowth' => $growth,
            'userMonths' => $months,
            'userCounts' => $counts
        ];
    }
}

