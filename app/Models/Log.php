<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log as LaravelLog; // Alias to avoid collision

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_name', 'user_id', 'status', 'message'];

    public static function log(string $userName, string $userId, string $status, ?string $message = null): void
    {
        try {
            self::create([
                'user_name' => $userName,
                'user_id' => $userId,
                'status' => $status,
                'message' => $message,
            ]);
        } catch (\Throwable $e) {
            LaravelLog::error("Failed to write sync log", [
                'user-name' => $userName,
                'user-id' => $userId,
                'status' => $status,
                'message' => $message,
                'error' => $e->getMessage()
            ]);
        }
    }
}
