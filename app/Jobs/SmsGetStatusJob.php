<?php

namespace App\Jobs;

use App\Api\SMS\SmsGetStatus;
use App\Models\SmsStatusSend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsGetStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    private SmsGetStatus $smsGetStatus;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->smsGetStatus = new SmsGetStatus();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $this->smsGetStatus->setLogin($this->data['login']);

        $this->smsGetStatus->setPassword($this->data['password']);

        $get_status = $this->smsGetStatus->get_status($this->data['sms_send_id'], $this->data['phone']);

        if (is_array($get_status)) {
            foreach ($get_status as $status) {
                if (is_array($status) && array_key_exists(11, $status)) {
                    SmsStatusSend::query()
                        ->where('phone_send', $status[4])
                        ->where('sms_send_id', $status[11])
                        ->update(['sms_status_code' => $status[0]]);
                }
            }
        }
    }
}
