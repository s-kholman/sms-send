<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;

class ValidateClient
{
    public function __invoke(array $data): bool|array
    {
        //dd($data);

        $data['phone'] = ltrim($data['phone'], '+');

        //dump(preg_match('/^7\d{10}$/',$data['phone']));
        //dump(preg_match('/^((7)+([0-9]){10})$/',$data['phone']));

        if(!preg_match('/^7\d{10}$/',$data['phone'])){

            return false;

        }




            if($data['birth'] <> null)
            {

                if(date(date('Y-m-d', strtotime($data['birth'])) == date('Y-m-d'))) {
                    $rep = explode('.', $data['birth']);
                    $rep[2] = '20' . $rep[2];
                    $data['birth'] = implode('.', $rep);
                }

                if(date(date('Y-m-d', strtotime($data['birth'])) > date('Y-m-d'))) {
                    $rep = explode('.', $data['birth']);
                    $rep[2] = '19' . $rep[2];
                    $data['birth'] = implode('.', $rep);
                }

                $data['birth'] = date('Y-m-d', strtotime($data['birth']));

                $check = explode('-', $data['birth']);

                if(!checkdate($check[1], $check[2], $check[0]) )
                {
                    $data['birth'] = null;
                }
            } else{
                $data['birth'] = null;
            }




        if(!preg_match('/^[а-яА-Я\s]+[а-яА-Я]+[а-яА-Я]*$/u',$data['clientFullName'])){

            $data['clientFullName'] = null;
        }

        return $data;

    }

}
