<?php

class DataCheck {

    public static function checkDataSetDungeon($params): bool {
        return self::checkDataDungeon($params->dungeon);
    }

    public static function checkDataSetStart($params): bool {
        // TODO: Использование Dungeon
        if (empty($params->dungeon->id_start_room)
            || !is_numeric($params->dungeon->id_start_room)
            || $params->dungeon->id_start_room <= 0
            || $params->dungeon->id_start_room === Dungeon::ID_FINAL_ROOM
        ) {
            return false;
        }

        // Проверка проходимости подземелья с помощью BFS
        $graph = Dungeon::create()->getGraphRooms();
        if (Utils::bfs($graph, $params->dungeon->id_start_room, Dungeon::ID_FINAL_ROOM)) {
            return true;
        }

        return false;
    }

    public static function checkDataSetPlayer($params): bool {
        return isset($params->player)
            && (!isset($params->player->name) || (isset($params->player->name)
                    && !empty($params->player->name) && is_string($params->player->name)
                    && !is_numeric($params->player->name)));
    }

    public static function checkDataMove($params): bool {
        return isset($params->player, $params->player->direction_to)
            && !empty($params->player->direction_to)
            && is_numeric($params->player->direction_to);
    }

    private static function checkDataDungeon($dungeon): bool {
        // TODO: Использование Dungeon
        // Общая проверка на инициализацию/соответствию типов
        if (!isset($dungeon, $dungeon->rooms)
            || empty($dungeon)
            || !is_array($dungeon->rooms)
        ) {
            return false;
        }

        // Проверка комнат
        foreach ($dungeon->rooms as $room) {
            if (!self::checkDataRoom($room)) {
                return false;
            }
        }

        // Проверка: хотя бы один выход есть в подземелье
        $withExit = false;
        foreach ($dungeon->rooms as $room) {
            if (in_array(Dungeon::ID_FINAL_ROOM, $room->links, true)) {
                $withExit = true;
                break;
            }
        }
        if (!$withExit) {
            return false;
        }

        return true;
    }

    private static function checkDataRoom($room): bool {
        // TODO: Использование Dungeon

        // Комната должна быть:
        // С положительным id: numeric, который не равен id конечной комнаты
        // С type: string, предусмотренным в RoomType
        // С непустым links: array of numeric
        // В links не должен присутствовать id просматриваемой комнаты
        // При наличии content => проверка контента
        return isset($room->id, $room->type, $room->links)
            && is_numeric($room->id)
            && $room->id !== Dungeon::ID_FINAL_ROOM
            && $room->id > 0
            && !empty($room->type)
            && is_string($room->type)
            && ($room->type === RoomType::MONSTER || $room->type === RoomType::TREASURE
                || $room->type === RoomType::EMPTY || $room->type === RoomType::VISITED)
            && !empty($room->links)
            && is_array($room->links)
            && $room->links === array_filter($room->links, 'is_numeric')
            && !in_array($room->id, $room->links, false)
            && (!isset($room->content) || (isset($room->content) && self::checkRoomContent($room)));
    }

    private static function checkRoomContent($room): bool {
        // Проверка на пустоту
        if (empty($room->content)) {
            return false;
        }
        // Если в комнате монстр => проверка монстра
        // Если в комнате сундук => проверка сундука
        if (!($room->type === RoomType::MONSTER && self::checkMonster($room->content->monster))
            && !($room->type === RoomType::TREASURE && self::checkChest($room->content->chest))) {
            return false;
        }
        return true;
    }

    private static function checkMonster($monster): bool {
        // Монстр должен быть:
        // С type: string, предусмотренным в Monster::types
        // При наличии strength => strength: numeric в диапазоне (0;50)
        // При наличии reduction => reduction: numeric в диапазоне (0;inf)
        return !empty($monster)
            && isset($monster->type)
            && !empty($monster->type)
            && Monster::types[$monster->type] !== null
            && is_string($monster->type)
            && (!isset($monster->strength) || (isset($monster->strength) && is_numeric($monster->strength)
                    && $monster->strength > 0 && $monster->strength < 50))
            && (!isset($monster->reduction) || (isset($monster->reduction) && is_numeric($monster->reduction)
                    && $monster->reduction > 0));
    }

    private static function checkChest($chest): bool {
        // Сундук должен быть:
        // С rarity: string, предусмотренным в Chest::rarities
        return !empty($chest)
            && isset($chest->rarity)
            && !empty($chest->rarity)
            && Chest::rarities[$chest->rarity] !== null
            && is_string($chest->rarity);
    }


}