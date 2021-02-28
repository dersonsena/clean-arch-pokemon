# Use case: INFORMAÇÕES DO JOGADOR

O jogador poderá a qualquer momento ter um breve resumo de suas informações e posses, como:
- Dados pessoais;
- Quanto de dinheiro ele possui no momento;
- Total de XP até o momento;
- Total de Pokémons da Pokédex;

Algo semelhante a imagem do jogo abaixo:

![Pokémon Gold Logo](./profile.png)

# Como Testar

## Request

```
GET /player/<player_id>/profile
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
            "items": [],
            "pokeballs": []
        },
        "party": {
            "pokemons": []
        },
        "xp": 100,
        "money": 5130,
        "id": 1
    },
    "meta": []
}
```
