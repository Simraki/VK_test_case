<?php


class Main {

    public function setDungeon($params): void {
        $response = GameController::setDungeon($params->dungeon);
        if ($response) {
            JSON_RPC::sendResultResponse(true);
            return;
        }
        Utils::error(ERR_DONT_SET);
    }

    public function setStart($params): void {
        $response = GameController::setStartRoom($params->dungeon->id_start_room);
        $response = $response && GameController::newGame();
        if ($response) {
            JSON_RPC::sendResultResponse(true);
            return;
        }
        Utils::error(ERR_DONT_SET);
    }

    public function setPlayer($params): void {
        $response = GameController::setPlayer($params->player);
        if ($response) {
            JSON_RPC::sendResultResponse(true);
            return;
        }
        Utils::error(ERR_DONT_SET);
    }

    public function move($params): void {
        $response = GameController::movePlayer($params->player);
        if (isset($response->error)) {
            Utils::error($response->error);
            return;
        }
        JSON_RPC::sendResultResponse($response);
    }


    // Отправка ошибки 'изнутри'
    public static function sendError(string $class, string $method, array $error = null): void {
        if ($error === null) {
            $error = ERR_INTERNAL;
        }
        Utils::error($error, $class, $method);
        die;
    }

}
