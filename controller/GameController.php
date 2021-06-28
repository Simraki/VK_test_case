<?php


class GameController {

    public static function newGame(): bool {
        $id_start = Dungeon::create()->getStartRoom();
        $load = Player::setCurrentPosition($id_start);
        $load = $load && Player::setScore(0);
        return $load;
    }

    public static function setDungeon(object $dungeon): bool {
        return Dungeon::setDungeon($dungeon);
    }

    public static function setPlayer(object $player): bool {
        return Player::setPlayer($player);
    }

    public static function setStartRoom(int $id_room): bool {
        return Dungeon::create()->setStartRoom($id_room);
    }

    public static function movePerson(object $player): object {
        // TODO: GameController не должен знать про формирование ответа => interface?
        $load = null;
        if (self::isGameFinished()) {
            $load = (object) [
                'error' => ERR_FINISHED_GAME
            ];
            return $load;
        }

        $canMove = MoveController::move($player);
        if ($canMove === MoveController::CANT_MOVE) {
            $load = (object) [
                'error' => ERR_CANT_MOVE
            ];
            return $load;
        }

        if (Player::atFinalRoom()) {
            return self::finishGame();
        }

        $score = Player::getScore();
        $room = Dungeon::getRoomById(Player::getCurrentPosition())->toObj();
        $load = (object) [
            'isFinal' => false,
            'score' => $score,
            'room' => $room
        ];
        return $load;
    }

    public static function finishGame(): object {
        $name = Player::create()->getName();
        $score = Player::getScore();

        Repository::saveInPlayersFile((object) [
            'nickname' => $name,
            'score' => $score
        ]);

        return (object) [
            'isFinal' => true,
            'score' => $score
        ];
    }

    public static function isGameFinished(): bool {
        return Player::atFinalRoom();
    }

}