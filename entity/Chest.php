<?php


class Chest {
    public const rarities = [
        'common' => [
            'name' => 'common',
            'k' => 1
        ],
        'uncommon' => [
            'name' => 'uncommon',
            'k' => 2
        ],
        'rare' => [
            'name' => 'rare',
            'k' => 3
        ],
    ];

    private $rarity;

    private function __construct(string $rarity) {
        $this->rarity = $rarity;
    }

    // Создание экземпляра из объекта
    public static function createFromObj(object $chest): Chest {
        return new self($chest->rarity);
    }

    // Каст в объект
    public function toObj(): object {
        return (object) [
            'rarity' => $this->rarity
        ];
    }

    // Действие "открыть"
    public function open(): int {
        $k = self::rarities[$this->rarity]['k'] ?? 1;
        return Utils::getRandomInt(4 * $k - 3, 4 * $k);
    }
}