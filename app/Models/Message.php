<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'text',
        'type',
        'crontab',
        'birth_to_day',
        'user_id',
    ];

    public function Crontab(){

        return $this->hasMany(Crontab::class);

    }

}
