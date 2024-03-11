<?php

namespace App\Api\SMS;

use App\Models\SmscIntegration;
use Illuminate\Support\Facades\Auth;


class SmscSendCmd

{

private $SMSC_LOGIN = "";			// логин клиента
private $SMSC_PASSWORD = "";	// пароль
private $SMSC_POST = 0;					// использовать метод POST
private $SMSC_HTTPS = 0;				// использовать HTTPS протокол
private $SMSC_CHARSET = "utf-8";	// кодировка сообщения: utf-8, koi8-r или windows-1251 (по умолчанию)
protected $SMSC_DEBUG = 0;				// флаг отладки
///private $SMTP_FROM = "api@smsc.ru";     // e-mail адрес отправителя


public function setLogin($login)
{
    $this->SMSC_LOGIN = $login;
}

public function setPassword($password)
{
    $this->SMSC_PASSWORD = $password;
}

    public function _smsc_send_cmd($cmd, $arg = "", $files = array())
    {
        $check = SmscIntegration::query()->where('user_id', Auth::user()->id)->first();

        if(!empty($check)){

            $this->SMSC_LOGIN = $check->login;
            $this->SMSC_PASSWORD = $check->password;

        }

        $url = $_url = ($this->SMSC_HTTPS ? "https" : "http")."://smsc.ru/sys/$cmd.php?login=".urlencode($this->SMSC_LOGIN)."&psw=".urlencode($this->SMSC_PASSWORD)."&fmt=1&charset=".$this->SMSC_CHARSET."&".$arg;

        $i = 0;
        do {
            if ($i++)
                $url = str_replace('://smsc.ru/', '://www'.$i.'.smsc.ru/', $_url);

            $ret = $this->_smsc_read_url($url, $files, 3 + $i);
        }
        while ($ret == "" && $i < 5);

        if ($ret == "") {
            if ($this->SMSC_DEBUG)
                echo "Ошибка чтения адреса: $url\n";

            $ret = ","; // фиктивный ответ
        }

        $delim = ",";

        if ($cmd == "status") {
            parse_str($arg, $m);

            if (strpos($m["id"], ","))
                $delim = "\n";
        }

        return explode($delim, $ret);
    }


private function _smsc_read_url($url, $files, $tm = 5)
{
    $ret = "";
    $post = $this->SMSC_POST || strlen($url) > 2000 || $files;

    if (function_exists("curl_init"))
    {
        static $c = 0; // keepalive

        if (!$c) {
            $c = curl_init();
            curl_setopt_array($c, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => $tm,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array("Expect:")
            ));
        }

        curl_setopt($c, CURLOPT_POST, $post);

        if ($post)
        {
            list($url, $post) = explode("?", $url, 2);

            if ($files) {
                parse_str($post, $m);

                foreach ($m as $k => $v)
                    $m[$k] = isset($v[0]) && $v[0] == "@" ? sprintf("\0%s", $v) : $v;

                $post = $m;
                foreach ($files as $i => $path)
                    if (file_exists($path))
                        $post["file".$i] = function_exists("curl_file_create") ? curl_file_create($path) : "@".$path;
            }

            curl_setopt($c, CURLOPT_POSTFIELDS, $post);
        }

        curl_setopt($c, CURLOPT_URL, $url);

        $ret = curl_exec($c);
    }
    elseif ($files) {
        if ($this->SMSC_DEBUG)
            echo "Не установлен модуль curl для передачи файлов\n";
    }
    else {
        if (!$this->SMSC_HTTPS && function_exists("fsockopen"))
        {
            $m = parse_url($url);

            if (!$fp = fsockopen($m["host"], 80, $errno, $errstr, $tm))
                $fp = fsockopen("212.24.33.196", 80, $errno, $errstr, $tm);

            if ($fp) {
                stream_set_timeout($fp, 60);

                fwrite($fp, ($post ? "POST $m[path]" : "GET $m[path]?$m[query]")." HTTP/1.1\r\nHost: smsc.ru\r\nUser-Agent: PHP".($post ? "\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: ".strlen($m['query']) : "")."\r\nConnection: Close\r\n\r\n".($post ? $m['query'] : ""));

                while (!feof($fp))
                    $ret .= fgets($fp, 1024);
                list(, $ret) = explode("\r\n\r\n", $ret, 2);

                fclose($fp);
            }
        }
        else
            $ret = file_get_contents($url);
    }

    return $ret;
}

}
