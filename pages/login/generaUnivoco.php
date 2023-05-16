<?php
    date_default_timezone_set("Europe/Rome");
    $time = microtime(true);
    $dFormat = "l jS F, Y - H:i:s";
    $mSecs = $time - floor($time);
    $mSecs = substr($mSecs,1);
    $unique = sprintf('%s%s', date($dFormat), $mSecs );

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
        } return $randomString;
        } 
    
    $returnString = generateRandomString();

    $univoco = $returnString.sha1($unique);

?>