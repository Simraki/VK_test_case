<?php


class MoveController {

    public const CANT_MOVE = -1;
    public const CAN_MOVE = 1;
//    public const FINAL_MOVE = 0;

    public static function move(object $player): int {
        $cur_pos = Player::getCurrentPosition();
        $cur_room = Dungeon::getRoomById($cur_pos);
        $id_room_to = Player::createFromObj($player)->getDirectionTo();

        if (!$cur_room->isPathExistTo($id_room_to)) {
            return self::CANT_MOVE;
        }

        Player::setCurrentPosition($id_room_to);
        if ($id_room_to === Dungeon::ID_FINAL_ROOM) {
            return self::CAN_MOVE;
        }
        $room = Dungeon::getRoomById($id_room_to);

        $reward = 0;
        if ($room->hasChest()) {
            $reward = $room->getChest()->open();
        } elseif ($room->hasMonster()) {
            $reward = Player::attack($room->getMonster());
        }
        Player::addScore($reward);

        $room->setVisited();

        return self::CAN_MOVE;
    }

}