<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HumanLoss;
use App\Models\Incident;

use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Total Users
        $totalUsers = User::count();

        // Total Incidents
        $totalIncidents = Incident::count();

        // ✅ Total Human Loss where loss_type = 'Died'
        $totalHumanLoss = HumanLoss::where('loss_type', 'died')->count();

        // Active sessions in last 30 minutes
        $activeSessions = DB::table('sessions')
            ->where('last_activity', '>', now()->subMinutes(30)->timestamp)
            ->count();

        // Visitor data
        $visitorData = DB::table('sessions')
            ->select('ip_address', 'user_agent', 'last_activity')
            ->get()
            ->map(function ($visitor) {
                $visitor->location = $this->getLocationByIp($visitor->ip_address);
                return $visitor;
            });

        // Daily traffic stats
        $dailyTraffic = DB::table('sessions')->select(DB::raw('DATE(FROM_UNIXTIME(last_activity)) as date'), DB::raw('COUNT(*) as session_count'))->groupBy(DB::raw('DATE(FROM_UNIXTIME(last_activity))'))->get();

        return view('dashboard', compact('totalUsers', 'totalIncidents', 'totalHumanLoss', 'activeSessions', 'visitorData', 'dailyTraffic'));
    }

    private function getLocationByIp($ip)
    {
        $url = "http://ip-api.com/json/{$ip}";

        $response = @file_get_contents($url);
        if (!$response) {
            return ['city' => 'Unknown', 'region' => 'Unknown', 'country' => 'Unknown'];
        }

        $data = json_decode($response, true);
        if (!isset($data['status']) || $data['status'] === 'fail') {
            return ['city' => 'Unknown', 'region' => 'Unknown', 'country' => 'Unknown'];
        }

        return [
            'city' => $data['city'],
            'region' => $data['regionName'],
            'country' => $data['country'],
        ];
    }
}
