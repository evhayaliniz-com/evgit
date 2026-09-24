<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids)) {
            return response()->json(['status' => 'ok']);
        }

        Notification::whereIn('id', $ids)
            ->where('to_id', auth()->id())
            ->update(['is_read' => 1]);

        return response()->json(['status' => 'ok']);
    }
}
