<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'notifications',
        'public_profile',
        'show_active',
        'crash_telemetry',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
