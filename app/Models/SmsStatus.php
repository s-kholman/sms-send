<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsStatus extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'message_id',
            'sms_uuid',
            'phone',
            'date',
            'user_id',
            'status_code',
            'crontab_id'
        ];

    public function smscIntegration()
    {
        return $this->hasOne(SmscIntegration::class, 'user_id', 'user_id');
    }

    public function Crontab(){
        return $this->hasOne(Crontab::class, 'id', 'crontab_id');
    }
}
