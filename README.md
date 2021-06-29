# VK_test_case

## Оглавление
1. [Контакты](#contacts)
2. [Комментарии](#comments)
3. [Пример](#example)
    1. [Подземелье](#example)
    2. [JSON-запросы](#json-example)
        - [setDungeon](#set-dungeon)
        - [setStart](#set-start)
        - [setPlayer](#set-player)
        - [movePlayer](#move-player)

____

<a name="contacts"></a>
## Контакты
- :mailbox: *simraki@mail.ru*
- :iphone: *8 (923) 515-85-44*
- :speech_balloon: *vlad0kg*

**Желательный тип связи:** ВК, почта

<a name="comments"></a>
## Комментарии
Порядок: setDungeon -> setStart -> setPlayer -> movePerson

Выход создается в подземелье путем вставки в room->links числа -1.

-1 обозначает выход

____
<a name="example"></a>
## Пример
### Подземелье

**Схема подземелья:**
![Схема подземелья](https://github.com/Simraki/VK_test_case/blob/master/EXAMPLE/example.png)

<a name="json-example"></a>
### JSON-запросы 
<a name="set-dungeon"></a>
#### setDungeon

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

<a name="set-start"></a>
#### setStart

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

<a name="set-player"></a>
#### setPlayer

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

<a name="move-player"></a>
#### movePlayer

```json
{
    "method": "movePlayer",
    "params": {
        "player": {
            "direction_to": 2
        }
    }
}
```
