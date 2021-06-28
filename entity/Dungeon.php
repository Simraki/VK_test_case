<?php


class Dungeon {

    public const ID_FINAL_ROOM = -1;
    public const NO_START_ROOM = 0;

    private $id_start_room;
    private $rooms;

    private function __construct(int $id_start_room, array $rooms) {
        $this->id_start_room = $id_start_room;
        $this->rooms = $rooms;
    }

    // Создание экземпляра из репозитория
    public static function create(): Dungeon {
        $obj = Repository::getDungeon();
        return self::createFromObj($obj);
    }

    // Создание экземпляра из объекта
    public static function createFromObj(object $obj): Dungeon {
        $id_start_room = $obj->id_start_room ?? self::NO_START_ROOM;
        $rooms = $obj->rooms;
        return new self($id_start_room, $rooms);
    }

    // Каст в объект
    public function toObj(): object {
        $id_start_room = $this->id_start_room;
        if ($id_start_room === 0) {
            $id_start_room = null;
        }
        return (object) [
            'id_start_room' => $id_start_room,
            'rooms' => $this->rooms
        ];
    }

    // Установка подземелья
    public static function setDungeon(object $dungeon): bool {
        $rooms = $dungeon->rooms;
        $new_rooms = [];
        foreach ($rooms as $room) {
            $id = $room->id;
            unset($room->id);
            $new_rooms[$id] = $room;
        }
        // Добавление конечной комнаты
        $final_room = new Room(self::ID_FINAL_ROOM, RoomType::EMPTY, []);
        $new_rooms[self::ID_FINAL_ROOM] = $final_room->toObj();
        $dungeon->rooms = $new_rooms;
        return Repository::setDungeon($dungeon);
    }

    // Установка id стартовой комнаты
    public function setStartRoom(int $id_room): bool {
        $this->id_start_room = $id_room;
        return Repository::setDungeon($this->toObj());
    }

    // Получить id стартовой комнаты
    public function getStartRoom(): int {
        return $this->id_start_room;
    }

    // Получить комнату по ее id
    public static function getRoomById(int $id_room): Room {
        $dung = Repository::getDungeon();
        $room = $dung->rooms[$id_room];
        $room->id_room = $id_room;
        return Room::createFromObj($room);
    }

    // Изменить тип комнаты по ее id
    public static function changeRoomType(int $id_room, string $type): void {
        $d = Repository::getDungeon();
        $d->rooms[$id_room]->type = $type;
        if ($type === RoomType::VISITED || $type === RoomType::EMPTY) {
            $d->rooms[$id_room]->content = (object) [];
        }
    }

    // Получение графа комнат
    public function getGraphRooms(): array {
        $graph = [];
        foreach ($this->rooms as $i=>$room) {
            $graph[$i] = $room->links;
        }
        return $graph;
    }

}