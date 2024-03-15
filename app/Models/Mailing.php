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
        'mailing_send_birth',
        'mailing_immediate_dispatch',
        'mailing_deferred',
        'mailing_frequency_date',
        'mailing_frequency_type',
        'mailing_type',
        'mailing_to_day',
        'user_id'
    ];
}
