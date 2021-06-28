<?php

require_once 'Main.php';

// Конфиг
require_once 'config/ConfigLoader.php';

// Лог
require_once 'rpc/LogWriter.php';

// Обработчики/отправщики
require_once 'errors.php';
require_once 'check/DataCheck.php';
require_once 'rpc/JSON_RPC.php';

// Контроллеры для игры
require_once 'controller/GameController.php';
require_once 'controller/MoveController.php';

// Репозиторий
require_once 'data/Repository.php';
require_once 'data/SessionManager.php';

// Сущности для игры
require_once 'entity/Monster.php';
require_once 'entity/Chest.php';
require_once 'entity/Room.php';
require_once 'entity/RoomType.php';
require_once 'entity/Dungeon.php';
require_once 'entity/Player.php';

// Утилиты
require_once 'Utils.php';