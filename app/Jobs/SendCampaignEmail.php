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
                // Ganti tag di subject
                $subject = strtr($this->campaign->subject, [
                    '{{name}}' => $subscriber->name,
                    '{{email}}' => $subscriber->email,
                ]);

                // Tambahkan tracking open (pixel)
                $trackingUrl = route('tracking.open', [$this->campaign->id, $subscriber->id]);
                $unsubscribeUrl = route('unsubscribe', ['subscriber' => $subscriber->id]);
                
                // Ganti tag di body
                $body = str_replace(
                    ['{{name}}', '{{email}}'],
                    [$subscriber->name, $subscriber->email],
                    $this->campaign->body
                );

                // Tambahkan tracking click (ubah semua href jadi tracking)
                $body = preg_replace_callback('/href="(https?:\/\/[^"]+)"/i', function ($matches) use ($subscriber) {
                    $originalUrl = $matches[1];
                    $encodedId = base64_encode(Str::random(10) . '.' . $subscriber->id . '.' . $this->campaign->id);
                    $encodedUrl = urlencode(base64_encode($originalUrl));
                    $redirectUrl = route('tracking.redirect', ['id' => $encodedId, 'ref' => $encodedUrl]);
                    return 'href="' . $redirectUrl . '"';
                }, $body);

                // Tambahkan tracking pixel
                $body .= '<img src="' . $trackingUrl . '" width="1" height="1" style="display:none;" />';

                // Tambahkan link unsubscribe
                $unsubscribeUrl = route('unsubscribe', $subscriber->id);

                // Render final HTML email
                $html = view('emails.campaign', [
                    'subject' => $subject,
                    'body' => $body,
                    'unsubscribeUrl' => $unsubscribeUrl, // <== Tambahkan ini
                ])->render();

                Mail::mailer('dynamic')->html($html, function ($msg) use ($subscriber, $smtp, $subject) {
                    $msg->to($subscriber->email)
                        ->from($smtp->from_address, $smtp->from_name)
                        ->subject($subject);

                    $headers = $msg->getSymfonyMessage()->getHeaders();
                    $headers->addTextHeader('X-Campaign-ID', $this->campaign->id);
                    $headers->addTextHeader('X-Subscriber-ID', $subscriber->id);
                    $headers->addTextHeader('Feedback-ID', "campaign-{$this->campaign->id}:subscriber-{$subscriber->id}:jowmail");
                    $headers->addTextHeader('X-Mailer', 'Jowmail.com');
                    $headers->addTextHeader('X-Using', 'Jowmail.com');
                });
            }

            $this->campaign->update(['status' => 'sent']);
        } catch (\Exception $e) {
            $this->campaign->update(['status' => 'failed']);
            Log::error('Campaign send failed: ' . $e->getMessage());
        }
    }
}