<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class OnlineUserController extends Controller
{
    public function index(): JsonResponse
    {
        $onlineUsersData = Cache::remember('online_users', 60, function () {
            // Users seen in the last 5 minutes
            $onlineThreshold = now()->subMinutes(5);

            $onlineUsers = User::where('last_seen_at', '>=', $onlineThreshold)
                ->select('id', 'username', 'last_seen_at')
                ->get();

            return [
                'online_users' => $onlineUsers,
                'total_online' => $onlineUsers->count(),
            ];
        });

        return response()->json($onlineUsersData);
    }
}
