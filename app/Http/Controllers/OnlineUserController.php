<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnlineUserController extends Controller
{
    public function index(): JsonResponse
    {
        // Users seen in the last 5 minutes
        $onlineThreshold = now()->subMinutes(5);

        $onlineUsers = User::where('last_seen_at', '>=', $onlineThreshold)
            ->select('id', 'username', 'last_seen_at')
            ->get();

        return response()->json([
            'online_users' => $onlineUsers,
            'total_online' => $onlineUsers->count(),
        ]);
    }
}
