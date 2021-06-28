<?php


class Repository {

    // Сохранить 'нагрузку' в файл
    public static function saveInPlayersFile(object $load): void {

        $filename = ConfigLoader::get("leaderboard.filename");

        if (empty($filename)) {
            Main::sendError(__CLASS__, __FUNCTION__, ERR_EMPTY_FILE_PATH);
        }

        if (!file_exists($filename)) {
            touch($filename);
        }
        $text = file_get_contents($filename);

        $arr = unserialize($text, ['allowed_classes' => true]);
        if (!is_array($arr)) {
            $arr = [];
        }

        $arr[] = $load;

        $text = serialize($arr);
        file_put_contents($filename, $text);
        unset($text, $arr);
    }

    public static function getCurrentPosition(): int {
        return SessionManager::getCurrentPosition();
    }

    public static function setCurrentPosition(int $id_room): bool {
        SessionManager::setCurrentPosition($id_room);
        return SessionManager::getCurrentPosition() === $id_room;
    }

    public static function getDungeon(): object {
        return SessionManager::getDungeon();
    }

    public static function setDungeon(object $dungeon): bool {
        SessionManager::setDungeon($dungeon);
        return SessionManager::getDungeon() === $dungeon;
    }

    public static function getScore(): int {
        return SessionManager::getScore();
    }

    public static function setScore(int $score): bool {
        SessionManager::setScore($score);
        return SessionManager::getScore() === $score;
    }

    public static function getPlayer(): object {
        // Если пользователь не предоставлен (==null), заменяем 'гостевым' профилем
        return SessionManager::getPlayer() ?? (object) [];
    }

    public static function setPlayer(object $player): bool {
        SessionManager::setPlayer($player);
        return SessionManager::getPlayer() === $player;
    }

}