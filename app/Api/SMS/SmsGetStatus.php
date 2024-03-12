<?php

namespace App\Api\SMS;

use Illuminate\Support\Facades\Auth;

class SmsGetStatus extends SmscSendCmd
{

    public function get_status($id, $phone, $all = 1)
    {
        $m = $this->_smsc_send_cmd("status", "phone=".urlencode($phone)."&id=".urlencode($id)."&all=".(int)$all);

        // (status, time, err, ...) или (0, -error)

        if (!strpos($id, ",")) {
            if ($this->SMSC_DEBUG)
                if ($m[1] != "" && $m[1] >= 0)
                    echo "Статус SMS = $m[0]", $m[1] ? ", время изменения статуса - ".date("d.m.Y H:i:s", $m[1]) : "", "\n";
                else
                    echo "Ошибка №", $m[1], "\n";

            if ($all && count($m) > 9 && (!isset($m[$idx = $all == 1 ? 14 : 17]) || $m[$idx] != "HLR")) // ',' в сообщении
                $m = explode(",", implode(",", $m), $all == 1 ? 9 : 12);
        }
        else {
            if (count($m) == 1 && strpos($m[0], "-") == 2)
                return explode(",", $m[0]);

            foreach ($m as $k => $v)
                $m[$k] = explode(",", $v);
        }

        return $m;
    }
}
