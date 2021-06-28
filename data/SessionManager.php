<?php


class SessionManager {

    private const CURRENT_POSITION = 'cur_pos';
    private const DUNGEON = 'dungeon';
    private const PLAYER = 'player';
    private const SCORE = 'score';

    public static function getCurrentPosition(): int {
        self::assertVarExist(self::CURRENT_POSITION);
        return $_SESSION[self::CURRENT_POSITION];
    }

    public static function setCurrentPosition(int $id_room): void {
        $_SESSION[self::CURRENT_POSITION] = $id_room;
    }

    public static function getDungeon(): object {
        self::assertVarExist(self::DUNGEON);
        return $_SESSION[self::DUNGEON];
    }

    public static function setDungeon(object $dungeon): void {
        $_SESSION[self::DUNGEON] = $dungeon;
    }

    public static function getScore(): int {
        self::assertVarExist(self::SCORE);
        return $_SESSION[self::SCORE];
    }

    public static function setScore(int $score): void {
        $_SESSION[self::SCORE] = $score;
    }

    public static function getPlayer(): ?object {
        self::assertVarExist(self::PLAYER);
        return $_SESSION[self::PLAYER];
    }

    public static function setPlayer(object $player): void {
        $_SESSION[self::PLAYER] = $player;
    }

    private static function assertVarExist(string $var_name): void {
        if (!isset($_SESSION[$var_name])) {
            $t = ERR_NO_SESSION_VAR;
            $t['message'] .= " || $var_name";
            Main::sendError(__CLASS__, __FUNCTION__, $t);
        }
    }

}