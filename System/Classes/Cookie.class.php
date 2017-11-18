<?php
//powered by kevin
namespace System\Classes;

use Marmot\Core;

class Cookie
{
    /**
     * @var string name of the cookie
     */
    public $name;
    /**
     * @var string value of the cookie
     */
    public $value='';
    /**
     * @var string domain of the cookie
     */
    public $domain='';
    /**
     * @var integer the timestamp at which the cookie expires.
     *      This is the server timestamp.
     *      Defaults to 0, meaning "until the browser is closed".
     */
    public $expire = 0;
    /**
     * @var string the path on the server in which the cookie will be available on. The default is '/'.
     */
    public $path='/';

    public function __construct(string $domain = '', string $path = '')
    {
        $this->domain = empty($domain) ? Core::$container->get('cookie.domain') : $domain;
        $this->path = empty($path) ? Core::$container->get('cookie.path') : $path;
    }

    public function add()
    {
        $this->value = $this->authcode($this->value, 'ENCODE');
        return setcookie(
            $this->name,
            $this->value,
            $this->expire ? (Core::$container->get('time') + $this->expire) : 0,
            $this->path,
            $this->domain,
            false,
            true
        );
    }

    public function get()
    {
        if (isset($_COOKIE[$this->name])) {
            $this->value = $this->authcode($_COOKIE[$this->name], 'DECODE');
            return $this->value;
        }
        return '';
    }

    //字符串解密加密
    /**
     * 加密解密字符串(可控制过期时间)
     *
     * @param string $string
     * @param string $operation
     * @param string $key
     * @param bool $expiry
     * @return unknown
     */
    public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {

        $ckey_length = 4; // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥

        $key = md5($key ? $key : Core::$container->get('cookie.encrypt.key'));
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? (
            $operation == 'DECODE'
            ? substr($string, 0, $ckey_length)
            : substr(md5(microtime()), - $ckey_length)
            )
        : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE'
        ? base64_decode(substr($string, $ckey_length))
        : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array ();
        for ($i = 0; $i <= 255; $i ++) {
            $rndkey [$i] = ord($cryptkey [$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i ++) {
            $j = ($j + $box [$i] + $rndkey [$i]) % 256;
            $tmp = $box [$i];
            $box [$i] = $box [$j];
            $box [$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i ++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box [$a]) % 256;
            $tmp = $box [$a];
            $box [$a] = $box [$j];
            $box [$j] = $tmp;
            $result .= chr(ord($string [$i]) ^ ($box [($box [$a] + $box [$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0)
                && substr($result, 10, 16)
                == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
}
