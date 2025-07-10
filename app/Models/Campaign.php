<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
    'subject',
    'body',
    'smtp_account_id',
    'email_list_id',
    'status',
    'scheduled_at',
];

    public function smtpAccount()
    {
        return $this->belongsTo(SmtpAccount::class);
    }

    public function emailList()
    {
        return $this->belongsTo(EmailList::class);
    }
}