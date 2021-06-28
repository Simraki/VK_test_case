<?php


class Room {

    private $id;
    private $type;
    private $links;
    private $monster;
    private $chest;

    public function __construct(int $id, string $type, array $links, object $monster = null, object $chest = null) {
        $this->id = $id;
        $this->type = $type;
        $this->links = $links;
        $this->monster = $monster;
        $this->chest = $chest;
    }

    // Создание экземпляра из объекта
    public static function createFromObj(object $room): Room {
        $id = $room->id_room;
        $type = $room->type;
        $links = $room->links;
        $chest = $room->content->chest;
        $monster = $room->content->monster;
        if ($chest !== null) {
            $chest = Chest::createFromObj($chest);
        }
        if ($monster !== null) {
            $monster = Monster::createFromObj($monster);
        }
        return new self($id, $type, $links, $monster, $chest);
    }

    // Каст в объект
    public function toObj(): object {
        $content = (object) [];
        if ($this->hasChest()) {
            $content->chest = $this->getChest()->toObj();
        }
        if ($this->hasMonster()) {
            $content->chest = $this->getMonster()->toObj();
        }
        return (object) [
            'id' => $this->id,
            'type' => $this->type,
            'links' => $this->links,
            'content' => $content
        ];
    }

    // Установка типа комнаты
    public function setType(string $type): void {
        $this->type = $type;
        Dungeon::changeRoomType($this->id, $type);
    }

    // Отметить комнату посещенной
    public function setVisited(): void {
        $this->setType(RoomType::VISITED);
    }

    // Существует ли путь из этой в комнаты в комнату с предоставленным id
    public function isPathExistTo(int $id_room): bool {
        foreach ($this->links as $link) {
            if ($link === $id_room) {
                return true;
            }
        }
        return false;
    }

    // Существует ли сундук в данной комнате
    public function hasChest(): bool {
        return $this->chest !== null;
    }

    // Существует ли монстр в данной комнате
    public function hasMonster(): bool {
        return $this->monster !== null;
    }

    // Получение сундука
    public function getChest(): Chest {
        return $this->chest;
    }

    // Получение монстра
    public function getMonster(): Monster {
        return $this->monster;
    }


}