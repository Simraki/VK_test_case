<?php


class Monster {
    public const types = [
        'mob' => [
            'name' => 'mob',
            'k' => 1
        ],
        'boss' => [
            'name' => 'boss',
            'k' => 2
        ],
    ];

    private $type;
    private $strength;
    private $reduction;

    private function __construct(string $type, int $strength = null, int $reduction = null) {
        $k = self::types[$type]['k'] ?? 1;

        $this->type = $type;
        $this->strength = $strength ?? Utils::getRandomInt(10 * $k, 20 * $k);
        $this->reduction = $reduction ?? Utils::getRandomInt(1 * $k, 4 * $k);
    }

    // Создание экземпляра из объекта
    public static function createFromObj(object $monster): Monster {
        return new self($monster->type, $monster->strength, $monster->reduction);
    }

    // Каст в объект
    public function toObj(): object {
        return (object) [
            'type' => $this->type,
            'strength' => $this->strength,
            'reduction' => $this->reduction
        ];
    }

    // Действие "нанесение урона"
    public function hit(int $damage): int {
        if ($damage > $this->strength) {
            // "Смерть"
            return $this->strength;
        }

        // "Ослабление"
        $this->strength -= $this->reduction;
        if ($this->strength < 0) {
            $this->strength = 0;
        }

        return -1;
    }

}