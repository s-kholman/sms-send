<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    use HasFactory;
    protected $fillable = [
        'mailing_name',
        'mailing_text',
        'mailing_send_time',
        'mailing_frequency',
        'mailing_to_day',
        'user_id',
    ];
}
