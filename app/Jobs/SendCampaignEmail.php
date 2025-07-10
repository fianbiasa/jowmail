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
use Illuminate\Support\Str;

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
            return; // belum waktunya kirim
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

        try {
            foreach ($subscribers as $subscriber) {
                $trackingUrl = route('tracking.open', [$this->campaign->id, $subscriber->id]);

                // Replace tag di body
                $bodyWithPixel = str_replace(
                    ['{{name}}', '{{email}}'],
                    [$subscriber->name, $subscriber->email],
                    $this->campaign->body
                );
                $bodyWithPixel .= '<img src="' . $trackingUrl . '" width="1" height="1" style="display:none;" />';

                // Replace tag di subject
                $subject = strtr($this->campaign->subject, [
                    '{{name}}' => $subscriber->name,
                    '{{email}}' => $subscriber->email,
                ]);

                // Render final email HTML
                $html = view('emails.campaign', [
                    'subject' => $subject,
                    'body' => $bodyWithPixel,
                ])->render();

                Mail::html($html, function ($msg) use ($subscriber, $smtp, $subject) {
                    $msg->to($subscriber->email)
                        ->from($smtp->from_address, $smtp->from_name)
                        ->subject($subject);
                });
            }

            $this->campaign->update(['status' => 'sent']);
        } catch (\Exception $e) {
            $this->campaign->update(['status' => 'failed']);
            Log::error('Campaign send failed: ' . $e->getMessage());
        }
    }
}