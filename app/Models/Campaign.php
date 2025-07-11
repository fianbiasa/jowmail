<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignOpen;
use App\Models\CampaignClick;

class Campaign extends Model
{
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

    public function opens()
    {
        return $this->hasMany(CampaignOpen::class);
    }

    public function clicks()
    {
        return $this->hasMany(CampaignClick::class);
    }
}