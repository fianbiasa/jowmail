<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'is_active',
        'from_name',       // ✅ Tambahkan ini
        'from_address',    // ✅ Tambahkan ini
    ];
}