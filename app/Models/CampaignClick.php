<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignClick extends Model
{
    protected $fillable = ['campaign_id', 'subscriber_id', 'url'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}