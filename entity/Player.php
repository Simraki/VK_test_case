<?php


class Player {

    public const NO_DIRECTION = 0;

    private $name;
    private $direction_to;

    private function __construct(string $name, int $direction_to = null) {
        $this->name = $name;
        $this->direction_to = $direction_to;
    }

    // Создание экземпляра из репозитория
    public static function create(): Player {
        $obj = Repository::getPlayer();
        return self::createFromObj($obj);
    }

    // Создание экземпляра из объекта
    public static function createFromObj(object $obj): Player {
        $name = $obj->name ?? 'Ghost';
        $direction_to = $obj->direction_to;
        return new self($name, $direction_to);
    }

    // Установка игрока
    public static function setPlayer(object $player): bool {
        return Repository::setPlayer($player);
    }

    // Действие "атаковать монстра"
    public static function attack(Monster $monster): int {
        while (true) {
            $dmg = Utils::getRandomInt(2, 50);
            $reward = $monster->hit($dmg);
            if ($reward >= 0) {
                return $reward;
            }
        }
    }

    // Находится ли в конечной комнате
    public static function atFinalRoom(): bool {
        return self::getCurrentPosition() === Dungeon::ID_FINAL_ROOM;
    }

    // Получить имя игрока
    public function getName(): string {
        return $this->name;
    }

    // Получить направление игрока
    public function getDirectionTo(): int {
        return $this->direction_to ?? self::NO_DIRECTION;
    }

    // TODO: Не относится к ответственности сущности "Игрок"
    // Установка текущей позиции
    public static function setCurrentPosition(int $id_room): bool {
        return Repository::setCurrentPosition($id_room);
    }

    // Получение текущей позиции
    public static function getCurrentPosition(): int {
        return Repository::getCurrentPosition();
    }

    // Установка кол-ва заработанных очков
    public static function setScore(int $score): bool {
        return Repository::setScore($score);
    }

    // Получение кол-ва заработанных очков
    public static function getScore(): int {
        return Repository::getScore();
    }

    // Добавление к кол-ву заработанных очков
    public static function addScore(int $add): void {
        $add += Repository::getScore();
        Repository::setScore($add);
    }

}