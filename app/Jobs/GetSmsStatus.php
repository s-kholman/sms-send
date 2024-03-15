<?php

namespace App\Jobs;

use App\Api\SMS\SmsGetStatus;
use App\Models\SmsStatusSend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetSmsStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $date;
    private $user_id;
    private SmsGetStatus $smsGetStatus;
    /**
     * Create a new job instance.
     */
    public function __construct($date, $user_id)
    {
        $this->date = $date;
        $this->user_id = $user_id;
        $this->smsGetStatus = new SmsGetStatus();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $get_status = [];
        /**
         * 1. Запрос, где поле sms_status_code равно null
         * 2. Затем из обновленной базы берем значения и показываем пользователю
         */
        $get_status_sms = SmsStatusSend::query()
            ->whereDate('date', $this->date)
            ->where('user_id', $this->user_id)
            ->where('sms_status_code', null)
            ->orWhere('sms_status_code', 0)
            ->get()
            ->groupBy('sms_send_id');
        $t = '';
        $m = '';

        if (count($get_status_sms) > 0) {
            foreach ($get_status_sms as $key => $phone) {
                foreach ($phone as $value) {
                    $t .= $value->phone_send . ',';
                    $m .= $key . ',';
                }
            }
            $this->smsGetStatus->setUserID($this->user_id);
            $get_status = $this->smsGetStatus->get_status($m, $t);

            foreach ($get_status as $status){
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
