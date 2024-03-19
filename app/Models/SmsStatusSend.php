<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsStatusSend extends Model
{
    use HasFactory;
    protected $fillable = [
        'mailing_id',
        'sms_send_id',
        'phone_send',
        'date',
        'user_id',
        'sms_status_code',
    ];

    public function smscIntegration()
    {
        return $this->hasOne(SmscIntegration::class, 'user_id', 'user_id');
    }

    public function Mailing()
    {
        return$this->belongsTo(Mailing::class);
    }
}
