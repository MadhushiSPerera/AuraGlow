<?php
$db_name='mysql:host=localhost;dbname=auraglow_db';
$username='root';
$userpassword='';

$conn=new PDO($db_name,$username,$userpassword);

if(!$conn){
    echo "Connection failed!";
}

function unique_id(){
    $chars ='01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLenth=strlen($chars);
    $randomString='';
    for($i=0;$i<20;$i++){
        $randomString.=$chars[mt_rand(0,$charLenth - 1)];
    }
    return $randomString;
}

?>