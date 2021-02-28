# Use case: AVISTAR UM POKÉMON

Quando o jogador avistar um pokémon, ele deverá verificar se ele já o viu em algum momento da sua jornada com a Pokédex. Caso ele **NÃO** tenha visto ainda, as informações básicas do pokémon deverão ir para sua Pokedéx, que servirá como um guia de consulta para este mesmo pokemon no futuro.

Caso ele já tenha visto este Pokémon anteriormente, deverá apenas mostrar as informações do pokémon.

![Pokémon Gold Logo](./pokemon-appears.jpg)

# Como Testar

# Request

```
POST /battle/start
```

## Payload

```json
{
    "trainer" : {
        "id" : 1,
        "pokemon_alias": "pikachu"
    },
    "challenger": {
        "id": null,
        "pokemon_alias": "voltorb"
    }
}
```

# Response

```json
{
    "status": "success",
    "data": {
        "id": 1,
        "xpEarned": 0,
        "moneyEarned": 0,
        "status": "STARTED",
        "createdAt": "2021-02-28T11:47:16-03:00",
        "endedAt": null,
        "challenger": null,
        "challengerPokemon": {
            "name": "Electabuzz",
            "alias": "electabuzz",
            "number": 191,
            "height": 11,
            "weight": 300,
            "image": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/125.png",
            "type": [],
            "level": 27,
            "captured": false,
            "id": 8
        }
    },
    "meta": []
}
```
