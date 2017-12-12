<?php
// function is_ajax() //Function to check if the request is an AJAX request
// {
//     return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
// }
/**
 * Generate a random string, using a cryptographically secure
 * pseudorandom number generator (random_int)
 *
 * For PHP 7, random_int is a PHP core function
 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
 *
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters
 *                         to select from
 * @return string
 */
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
function sendMail($from,$to,$subject,$body){
    $headers= 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";    
    $headers .= "From:".$from."\r\n";
    
    //ارسال ایمیل
    if (!mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers)) {
        //die("<p>خطا در ارسال ایمیل! تنظیمات سرور شما از این امکان پشتیبانی نمی کند</p>");
    return 0;
    }
    return 1;
}
?>