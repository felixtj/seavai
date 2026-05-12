<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LoginLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'email',
        'event',
        'ip_address',
        'user_agent',
        'device_type',
        'country',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public static function record(string $event, ?User $user = null, ?string $email = null): void
    {
        $request = request();
        static::create([
            'user_id'     => $user?->id,
            'email'       => $email ?? $user?->email,
            'event'       => $event,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'device_type' => static::detectDevice($request->userAgent()),
            'created_at'  => now(),
        ]);
    }

    private static function detectDevice(?string $ua): string
    {
        if (!$ua) return 'desktop';
        if (preg_match('/Mobile|Android|iPhone/i', $ua)) return 'mobile';
        if (preg_match('/Tablet|iPad/i', $ua)) return 'tablet';
        return 'desktop';
    }
}
