<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crontab extends Model
{
    use HasFactory;
    protected $fillable = [
        'run_date',
        'status',
        'message_id',
    ];

    public function Message(){

        return $this->belongsTo(Message::class);

    }

    public function SmsStatus(){
        return $this->hasMany(SmsStatus::class);
    }
}
