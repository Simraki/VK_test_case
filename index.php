<?php

require_once 'loader.php';

mb_internal_encoding("UTF-8");

function error(array $error, string $method = "empty") {
    Utils::error($error, 'index.php', $method);
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $raw_data = json_decode(file_get_contents("php://input"), false, 512, JSON_THROW_ON_ERROR);
    } catch(JsonException $e) {
        error(ERR_DECODE);
    }

    if (!empty($raw_data)) {
        $params = $raw_data->params;

        if (JSON_RPC::checkRequestFormat($raw_data)) {
            $main = new Main();
            $method = $raw_data->method;

            if ($method === "setDungeon") {
                if (DataCheck::checkDataSetDungeon($params)) {
                    $main->setDungeon($params);
                } else {
                    error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method === "setStart") {
                if (DataCheck::checkDataSetStart($params)) {
                    $main->setStart($params);
                } else {
                    error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method === "setPlayer") {
                if (DataCheck::checkDataSetPlayer($params)) {
                    $main->setPlayer($params);
                } else {
                    error(ERR_INVALID_PARAMS, $method);
                }
            } elseif ($method === "movePerson") {
                if (DataCheck::checkDataMove($params)) {
                    $main->move($params);
                } else {
                    error(ERR_INVALID_PARAMS, $method);
                }
            } else {
                error(ERR_METHOD_NOT_FOUND, $method);
            }
        } else {
            error(ERR_INVALID_REQUEST);
        }
    } else {
        error(ERR_PARSE);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo 'User module ready';
}