<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $notificationIds = $request->notifications;

        DatabaseNotification::whereIn('id', $notificationIds)
            ->update(['read_at' => now()]);


        return response()->json(['status' => 'success']);
    }

}

