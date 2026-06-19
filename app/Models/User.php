<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'profile_photo',
        'email',
        'password',
        'user_role_id',
        'is_active',
        'member_id',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->member_id)) {
                $user->member_id = self::generateUniqueMemberId();
            }
        });
    }

    public static function generateUniqueMemberId()
    {
        do {
            $code = 'MEM-' . strtoupper(Str::random(6));
        } while (self::where('member_id', $code)->exists());

        return $code;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    /**
     * Get the user's full name.
     */
    public function getNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
