<?php

//Reserved errors
const ERR_PARSE = ["code" => "-32000", "message" => "Ошибка анализа запроса"];
const ERR_INVALID_REQUEST = ["code" => "-32100", "message" => "Некорректный запрос"];
const ERR_METHOD_NOT_FOUND = ["code" => "-32101", "message" => "Метод не найден"];
const ERR_INVALID_PARAMS = ["code" => "-32102", "message" => "Неверные параметры"];
const ERR_INTERNAL = ["code" => "-32103", "message" => "Внутренняя ошибка"];

//Encode and decode errors
const ERR_DECODE = ["code" => "-32248", "message" => "JSON decode error"];
const ERR_ENCODE = ["code" => "-32249", "message" => "JSON encode error"];

// Move errors
const ERR_CANT_MOVE = ["code" => "-32301", "message" => "Нет пути"];
const ERR_FINISHED_GAME = ["code" => "-32302", "message" => "Игра окончена"];

// Setting errors
const ERR_DONT_SET = ["code" => "-32401", "message" => "Переменная не установлена"];

// Config errors
const ERR_EMPTY_FILE_PATH = ["code" => "-32500", "message" => "Путь к файлу пуст"];
const ERR_NO_SESSION_VAR = ["code" => "-32501", "message" => "Переменная сессии не установлена"];