<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan kolom role ada di fillable
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // --- TAMBAHKAN METHOD INI ---
    /**
     * Cek apakah user memiliki salah satu dari role yang diberikan
     */
    public function hasAnyRole(...$roles)
    {
        // Jika parameter dikirim sebagai array
        if (isset($roles[0]) && is_array($roles[0])) {
            $roles = $roles[0];
        }

        return in_array($this->role, $roles);
    }

    /**
     * Cek apakah user memiliki role spesifik
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}