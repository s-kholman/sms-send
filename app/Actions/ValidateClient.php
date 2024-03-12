<?php

namespace App\Actions;

class ValidateClient
{
    public function __invoke(array $data): bool|array
    {
        //dd($data);
        $data['phone'] = ltrim($data['phone'], '+');

        if(!preg_match('/^7\d{10}/',$data['phone'])){
            return false;
        }


        if($data['birth'] <> null)
        {
            $data['birth'] = date('Y-m-d', strtotime($data['birth']));
            $date = explode('-', $data['birth']);
            if(!checkdate($date[1], $date[2], $date[0]) )
            {
                return false;
            }
        } else {

            return false;

        }



        if(!preg_match('/^[а-яА-Я\s]+[а-яА-Я]+[а-яА-Я]*$/u',$data['clientFullName'])){

            return false;
        }

        return $data;

    }

}
