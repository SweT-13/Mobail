<?php
require_once(ROOT . '/config/tg_params.php');


if ($_SESSION['offset'] || isset($date) && in_array('0', $date->result)) {
    $offset = $_SESSION['offset'];
} else
    $offset = 0;

header("Content-Type: application/json");
$date = file_get_contents('https://api.telegram.org/bot' . TG_TOKEN . '/getUpdates?offset=' . $offset);
$date = json_decode($date);
print_r($date);
if (isset($date->result[0])) {
    $offset = $_SESSION['offset'] = $date->result['0']->update_id + 1;
//    $textMessage = $date->result['0']->message->text;
    $chatId = $date->result['0']->message->chat->id;

    $answ = 'todo List' . PHP_EOL;
    $resp = json_decode(SiteAjax::getEvent(), true);
    foreach ($resp as $i) {
        if ($i['status']) {
            $answ .= '<s>';
        }
        $answ .= '<b>id:</b> ' . $i['id'] . '; <b>timeCreate:</b> ' . substr($i['datetime'], 0, 10) . ' ' . substr($i['datetime'], 11, 8) . '; <b>Message:</b> ' . $i['message'];
        if ($i['status']) {
            $answ .= '</s>';
        }
        $answ .= PHP_EOL;
    }
    $textMessage_bot = $answ;
    $arrayQuery = array(
        'chat_id' => $chatId,
        'text' => $textMessage_bot,
        'parse_mode' => 'HTML',
    );
    TG_sendMessage($arrayQuery);
}

function TG_sendMessage($getQuery)
{
    $ch = curl_init('https://api.telegram.org/bot' . TG_TOKEN . '/sendMessage?' . http_build_query($getQuery));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    return $res;
}


