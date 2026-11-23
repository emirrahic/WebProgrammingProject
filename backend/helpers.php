<?php
date_default_timezone_set('Europe/Sarajevo');

function getJsonBody() {
    $data = json_decode(Flight::request()->getBody(), true);
    return is_array($data) ? $data : [];
}

function sendError($message, $code) {
    Flight::response()
        ->status($code)
        ->header('Content-Type', 'application/json')
        ->write(json_encode(["error" => $message]))
        ->send();
}

function writeErrorLog($message) {
    $line = "[" . date("Y-m-d H:i:s") . "] ERROR " . $message . "\n";
    file_put_contents(__DIR__ . "/logs/error.log", $line, FILE_APPEND);
}
