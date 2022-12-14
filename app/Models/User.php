<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Modules\Address\Entities\Address;
use Modules\Cart\Entities\Cart;
use Modules\PaymentType\Entities\PaymentType;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'image_path',
        'role',
        'password',
        'verification_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfilePicture()
    {
        $image_path = ($this->image_path) ? "/storage/{$this->image_path}" : asset('images/default-avatar-profile-image.jpg');

        return $image_path;
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function mainAddress()
    {
        $address = Address::where('user_id', Auth::id())->where('is_main', 1)->first();
        return $address->id;
    }
}