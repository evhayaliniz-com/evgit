<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message; // Eğer sohbetler mesajlar üzerinden yürüyorsa
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    /**
     * Sohbeti sil (belirli bir kullanıcıyla olan tüm mesajları).
     */
    public function destroy($receiverId): JsonResponse
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Giriş yapmalısınız.'], 401);
        }

        // Kullanıcı ile olan tüm mesajları sil
        $deleted = Message::where(function ($q) use ($userId, $receiverId) {
            $q->where('sender_id', $userId)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($userId, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $userId);
        })->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sohbet silindi.',
            'deleted_count' => $deleted
        ]);
    }
}
