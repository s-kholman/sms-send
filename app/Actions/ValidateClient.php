<?php

namespace App\Actions;

class ValidateClient
{
    public function __invoke(array $data): bool|array
    {

        if(!preg_match('/^7\d{10}/',$data['phone'])){
            return false;
        }

        $date = explode('.', $data['birth']);
        if(!checkdate($date[1], $date[0], $date[2]))
        {
            return false;
        }

        if(!preg_match('/^[а-яА-Я\s]+[а-яА-Я]+[а-яА-Я]*$/u',$data['clientFullName'])){
            return false;
        }

        return $data;

    }

}
