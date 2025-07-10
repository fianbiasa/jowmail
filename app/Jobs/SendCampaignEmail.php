<?php

namespace App\Jobs;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\View;

class SendCampaignEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle()
    {
        if ($this->campaign->scheduled_at && now()->lt($this->campaign->scheduled_at)) {
            // Belum waktunya kirim
            return;
        }

        $smtp = $this->campaign->smtpAccount;

        config([
            'mail.mailers.dynamic' => [
                'transport' => 'smtp',
                'host' => $smtp->host,
                'port' => $smtp->port,
                'encryption' => $smtp->encryption,
                'username' => $smtp->username,
                'password' => $smtp->password,
            ],
            'mail.default' => 'dynamic',
        ]);

        $subscribers = $this->campaign->emailList->subscribers;
        $campaign = $this->campaign; // simpan agar bisa diakses dalam closure

        try {
            foreach ($subscribers as $subscriber) {
    $trackingUrl = route('tracking.open', [$this->campaign->id, $subscriber->id]);

    $bodyWithPixel = str_replace(
        ['{{name}}', '{{email}}'],
        [$subscriber->name, $subscriber->email],
        $this->campaign->body
    );
    $bodyWithPixel .= '<img src="' . $trackingUrl . '" width="1" height="1" style="display:none;" />';

    $html = view('emails.campaign', [
        'subject' => $this->campaign->subject,
        'body' => $bodyWithPixel,
    ])->render();

    Mail::html($html, function ($msg) use ($subscriber, $smtp, $campaign) {
        $msg->to($subscriber->email)
            ->from($smtp->from_address, $smtp->from_name)
            ->subject($campaign->subject);
    });
}


            $campaign->update(['status' => 'sent']);
        } catch (\Exception $e) {
            $campaign->update(['status' => 'failed']);
            Log::error('Campaign send failed: ' . $e->getMessage());
        }
    }
}