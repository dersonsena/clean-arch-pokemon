# Use Case: COMPRAR ITENS

O jogador poderá comprar items para serem colocados na bolsa para usá-los durante sua jornada.

É preciso verificar se o jogador tem dinheiro suficiente para poder fazer a compra.

Ele também poderá comprar Poké bolas, que serão um tipo especial de item, para serem colocados na bolsa e ser usado durante sua jornada para capturar pokemons.

![Pokémon Gold Logo](./pokemon-mart.png)

## Informações Adicionais

### Mochila (BAG)

Na mochila do jogador poderá conter:

#### Items

Elixir, Potions, Antidotes e etc. Uma lista mais completa pode ser vista [neste link](https://www.ign.com/wikis/pokemon-red-blue-yellow-version/Items).

#### PokeBall

As pokébolas são:

- Pokeball: Catches Pokemon
- Great Ball: Greater chance of catching Pokemon than a Pokeball
- Ultra Ball: Greater chance of catching Pokemon than a Great Ball
- Master Ball: Always catches Pokemon
- Safari Ball: A special ball for use in the Safari Zone

#### Pokémons (Party)

Aqui ficarão os pokémons que ele poderá utilizar na sua jornada. Conforme é chamado de Deck em jogos de cartas, aqui essa lista limitada de pokemons é chamada de **Party**.

O jogador só poderá ter **no máximo 6 pokémons** em sua Party, conforme imagem abaixo:

![Pokémon Gold Logo](./pokemon-list.png)

# Como Testar

## Request

```
POST /market/purchase
```

### Payload

```json
{
    "player_id": 1,
    "items": [
        {
            "id": 1,
            "price": 50.00,
            "quantity": 2,
            "total": 50.00
        },
        {
            "id": 2,
            "price": 20.00,
            "quantity": 1,
            "total": 20.00
        },
        {
            "id": 3,
            "price": 350.00,
            "quantity": 1,
            "total": 350.00
        },
        {
            "id": 4,
            "price": 200.00,
            "quantity": 5,
            "total": 1000.00
        },
        {
            "id": 5,
            "price": 600.00,
            "quantity": 5,
            "total": 3000.00
        },
        {
            "id": 6,
            "price": 200.00,
            "quantity": 2,
            "total": 400.00
        }
    ]
}
```

## Response

```json
{
    "status": "success",
    "data": {
        "name": "Ash Ketchum",
        "avatar": "https://i1.sndcdn.com/avatars-000740962879-t7ox4k-t500x500.jpg",
        "gender": "MALE",
        "bag": {
            "items": [
                {
                    "name": "Antidote",
                    "price": 100,
                    "category": "DEFAULT",
                    "isSalable": true,
                    "id": 1
                },
                {
                    "name": "Burn Heal",
                    "price": 250,
                    "category": "DEFAULT",
                    "isSalable": true,
                    "id": 2
                },
                {
                    "name": "Dire Hit",
                    "price": 650,
                    "category": "DEFAULT",
                    "isSalable": true,
                    "id": 3
                },
                {
                    "name": "Escape Rope",
                    "price": 550,
                    "category": "DEFAULT",
                    "isSalable": true,
                    "id": 4
                },
                {
                    "name": "Fresh Water",
                    "price": 200,
                    "category": "DEFAULT",
                    "isSalable": true,
                    "id": 5
                }
            ],
            "pokeballs": [
                {
                    "name": "Poke Ball",
                    "price": 200,
                    "category": "POKEBALL",
                    "isSalable": true,
                    "id": 6
                }
            ]
        },
        "party": {
            "pokemons": []
        },
        "xp": 100,
        "money": 260,
        "id": 1
    },
    "meta": []
}
```
