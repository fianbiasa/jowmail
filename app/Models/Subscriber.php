<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = ['email_list_id', 'name', 'email'];

    public function list()
    {
        return $this->belongsTo(EmailList::class, 'email_list_id');
    }
}