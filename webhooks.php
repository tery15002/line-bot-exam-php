<?php
require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$accessToken = 'o60ClKJrS0BVOejt3EswUm/7erHWPFhZXO2fytzE/Cpcfm9V12rfNewXPJ8M1OjOco8yiTpBrYg4uWruJCFkFg6M1metrmSKvi4ZRlSGc5YkV8DfboEM/ESZg0Q3h+8ayGj5qzM/ZcpG6fDZyWObXAdB04t89/1O/w1cDnyilFU=';





$content = file_get_contents('php://input');
$arrayJson = json_decode($content, true);

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";


//รับข้อความจากผู้ใช้
$message = $arrayJson['events'][0]['message']['text'];

$message = "จะไปบางขุนเทียน";

$pos_por = strpos($message,"ป้ออ");

$pos_where = strpos($message,"ไป");

if($pos_por !== false){
    $message = 'tik';
}

$txt = null;
if($pos_where !== false){
    $explode_ = explode('ไป',$message);
    $txt = $explode_[1];
    $message = 'google';
}

$res_txt_por = ['tik' =>[
                        'เรียกไม',
                        'ไงลูก',
                        'ไง',
                        'ว่าไง',
                        'รำคานนน',
                        'ไอโง่',
                        'กรี๊ดดดดดดด',
                        'กรี๊ดดดดดดดดดดดควยต๊อบดดดดดดดดดดด'
                        ],
                'google' => 'https://www.google.com/maps/search/?api=1&query='.$txt
               ];
//print_r($message);
GetResponseText($message,$res_txt_por,$arrayHeader);

function GetResponseText($message,$res_txt_por,$arrayHeader){

    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";

    if($message == 'tik'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['tik'][array_rand($res_txt_por['tik'],1)];
    }else if($message == 'google'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['google'];
    }
//    print_r($arrayHeader);
//    print_r($arrayPostData);

    replyMsg($arrayHeader,$arrayPostData);

}

/*

#ตัวอย่าง Message Type "Text"
if($message == "สวัสดี"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
    replyMsg($arrayHeader,$arrayPostData);
}
#ตัวอย่าง Message Type "Sticker"
else if($message == "ฝันดี"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "sticker";
    $arrayPostData['messages'][0]['packageId'] = "2";
    $arrayPostData['messages'][0]['stickerId'] = "46";
    replyMsg($arrayHeader,$arrayPostData);
}
#ตัวอย่าง Message Type "Image"
else if($message == "รูปน้องแมว"){
    $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "image";
    $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
    $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
    replyMsg($arrayHeader,$arrayPostData);
}
#ตัวอย่าง Message Type "Location"
else if($message == "พิกัดสยามพารากอน"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "location";
    $arrayPostData['messages'][0]['title'] = "สยามพารากอน";
    $arrayPostData['messages'][0]['address'] =   "13.7465354,100.532752";
    $arrayPostData['messages'][0]['latitude'] = "13.7465354";
    $arrayPostData['messages'][0]['longitude'] = "100.532752";
    replyMsg($arrayHeader,$arrayPostData);
}
#ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
else if($message == "ลาก่อน"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = "อย่าทิ้งกันไป";
    $arrayPostData['messages'][1]['type'] = "sticker";
    $arrayPostData['messages'][1]['packageId'] = "1";
    $arrayPostData['messages'][1]['stickerId'] = "131";
    replyMsg($arrayHeader,$arrayPostData);
}
*/

function replyMsg($arrayHeader,$arrayPostData){
    $strUrl = "https://api.line.me/v2/bot/message/reply";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close ($ch);
}
exit;
?>