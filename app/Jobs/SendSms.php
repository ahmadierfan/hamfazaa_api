<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;


class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected $paramsArray;
    protected $fk_smspattern;
    protected $fk_registrar;
    protected $mobile;

    /**
     * Create a new job instance.
     */
    public function __construct(string $url, array $paramsArray, int $fk_smspattern, ?int $fk_registrar = null, string $mobile)
    {
        $this->url = $url;
        $this->paramsArray = $paramsArray;
        $this->fk_smspattern = $fk_smspattern;
        $this->fk_registrar = $fk_registrar;
        $this->mobile = $mobile;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sendArray = [
            "paramsArray" => $this->paramsArray,
            "fk_smspattern" => $this->fk_smspattern,
            "mobile" => $this->mobile
        ];

        if ($this->fk_registrar != null)
            $sendArray['fk_registrar'] = $this->fk_registrar;

        $response = Http::post(
            $this->url . 'api/crm/v1/company/auth/send-sms',
            $sendArray
        );
        $response->body();

        if ($response->successful()) {
            $response->body();
        } else {
            \Log::error('Failed to send sms.', [
                'response' => $response->body(),
            ]);
        }
    }
}
