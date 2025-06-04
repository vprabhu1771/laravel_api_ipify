<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Http;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'public_ip'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($row) {
            $row->public_ip = self::fetchPublicIP();
        });

        static::updating(function ($row) {
            $row->public_ip = self::fetchPublicIP();
        });
    }

    protected static function fetchPublicIP()
    {
        try {
            $response = Http::timeout(5)->get('https://api.ipify.org/?format=json');

            if ($response->successful()) {
                return $response->json('ip');
            }
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
        }

        return 'Unknown';
    }
}
