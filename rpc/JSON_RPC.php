<?php

class JSON_RPC {

    public static function checkRequestFormat($request): bool {
        return (!empty($request->method) && is_string($request->method));
    }

    public static function sendResultResponse($result): void {
        $response = [
            "result" => $result,
            "error" => null
        ];
        self::sendResponse($response);
    }

    public static function sendErrorResponse(array $error, string $filename, string $method): void {
        $response = [
            "result" => null,
            "error" => $error
        ];

        LogWriter::logEntry($filename, $method, $error);
        self::sendResponse($response, true);
    }

    private static function sendResponse(array $response, bool $isError = false): void {
        try {
            $msg = json_encode($response, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
            if ($isError) {
                error_log($msg.PHP_EOL, 3, "errors.log");
            }
            echo $msg;
        } catch(JsonException $e) {
            LogWriter::logEntry(__CLASS__, __METHOD__, ERR_ENCODE);
            echo ERR_INTERNAL['message'];
        }
    }
}