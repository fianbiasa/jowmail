<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}