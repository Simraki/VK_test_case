# VK_test_case

## Контакты
- :mailbox: *simraki@mail.ru*
- :iphone: *8 (923) 515-85-44*
- :speech_balloon: *vlad0kg*

**Желательный тип связи:** ВК, почта

## Комментарии
Выход создается в подземелье путем вставки в room->links числа -1.

-1 обозначает выход

____

## Пример

**Схема подземелья:**
![Схема подземелья](https://github.com/Simraki/VK_test_case/blob/master/OPENME/example.png)

## Примеры JSON-запросов 
### setDungeon

```json
{
    "method": "setDungeon",
    "params": {
        "dungeon": {
            "rooms": [
                {
                    "id": 1,
                    "type": "empty",
                    "links": [2]
                },
                {
                    "id": 2,
                    "type": "treasure",
                    "links": [1,3,4],
                    "content": {"chest": {"rarity":"common"}}
                },
                {
                    "id": 3,
                    "type": "empty",
                    "links": [2,4]
                },
                {
                    "id": 4,
                    "type": "monster",
                    "links": [2,3,5,7],
                    "content": {"monster": {"type":"mob"}}
                },
                {
                    "id": 5,
                    "type": "empty",
                    "links": [4,6,7,8]
                },
                {
                    "id": 6,
                    "type": "monster",
                    "links": [5,9],
                    "content": {"monster": {"type":"boss","strength":42,"reduction":4}}
                },
                {
                    "id": 7,
                    "type": "treasure",
                    "links": [4,5],
                    "content": {"chest": {"rarity":"uncommon"}}
                },
                {
                    "id": 8,
                    "type": "treasure",
                    "links": [5],
                    "content": {"chest": {"rarity":"rare"}}
                },
                {
                    "id": 9,
                    "type": "empty",
                    "links": [6, -1]
                }
            ]
        }
    }
}
```

### setStart

```json
{
    "method": "setStart",
    "params": {
        "dungeon": {
            "id_start_room": 1
        }
    }
}
```

### setPlayer

```json
{
    "method": "setPlayer",
    "params": {
        "player": {
            "name": "ss2"
        }
    }
}
```

### movePerson

```json
{
    "method": "movePerson",
    "params": {
        "player": {
            "direction_to": 2
        }
    }
}
```
