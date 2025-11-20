<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * Get the user's image for AdminLTE
     *
     * @return string
     */
    public function adminlte_image()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=87C15A&background=192334';
    }

    /**
     * Get the user's description for AdminLTE
     *
     * @return string
     */
    public function adminlte_desc()
    {
        return 'Administrator';
    }

    /**
     * Get the user's profile URL for AdminLTE
     *
     * @return string
     */
    public function adminlte_profile_url()
    {
        return 'admin/profile';
    }
}
