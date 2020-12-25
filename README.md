# Clean Architecture com Pokémon

A ideia deste repositório é praticar os conceitos da Clean Architecture de um modo divertido e prático integrando uma API com uma [API de Pokémon de Terceiros](https://pokeapi.co/).

Aqui irei tentar replicar algumas regras do clássico jogo Pokémon Gold do Gameboy.

![Pokémon Gold Logo](./docs/pokemon-gold.png)

## Pré-Requisitos

- PHP 7.4 ou superior;
- [Composer](https://getcomposer.org);
- [Slim Framework 4](https://www.slimframework.com);

## Casos de Uso

Abaixo estão listadas os casos de uso para termos uma ideia fechada de Domínio e Regras de Negócios.

### MOCHILA (BAG)

Na mochila do jogador poderá conter:

#### Items

Elixir, Potions, Antidotes e etc. Uma lista mais completa pode ser vista [neste link](https://www.ign.com/wikis/pokemon-red-blue-yellow-version/Items).

#### PokeBall

- Pokeball: Catches Pokemon
- Great Ball: Greater chance of catching Pokemon than a Pokeball
- Ultra Ball: Greater chance of catching Pokemon than a Great Ball
- Master Ball: Always catches Pokemon
- Safari Ball: A special ball for use in the Safari Zone

#### Pokémons

Aqui ficarão os pokémons que ele poderá utilizar na sua jornada. O jogador só poderá ter **no máximo 6 pokémons** consigo, conforme imagem abaixo:

![Pokémon Gold Logo](./docs/pokemon-list.png)

### INFORMAÇÕES DO JOGADOR

O jogador poderá a qualquer momento ter um breve resumo de suas posses, como:
- Dados pessoais;
- Quanto de dinheiro ele possue no momento;
- Total de XP até o momento;
- Total de Pokémons da Pokédex;

![Pokémon Gold Logo](./docs/profile.png)

### COMPRAR ITENS

O jogador poderá comprar items para serem colocados na bolsa, para que ele possa usar durante sua jornada. É preciso verificar se ele tem dinheiro suficiente para poder fazer as compras.

### COMPRAR POKEBALLS

O jogador poderá comprar Poké bolas para serem colocados na bolsa, para que ele possa usar durante sua jornada para capturar pokemon. É preciso verificar se ele tem dinheiro suficiente para poder fazer as compras.

O Jogador só poderá comprar nas lojas: **Pokeball**, **Great Ball** e **Ultra Ball**.

### AVISTAR UM POKÉMON

Quando o jogador avistar um pokémon, ele deverá verificar se ele já o viu em algum momento da sua jornada com a Pokédex. Caso ele **NÃO** tenha visto ainda, as informações básicas do pokémon deverão ir para sua Pokedéx, que servirá como um guia de consulta para este mesmo pokemon no futuro.

Caso ele já tenha visto este Pokémon anteriormente, deverá apenas mostrar as informações do pokémon.

### CAPTURAR UM POKÉMON

Para capturar um pokemon o jogador deverá verificar se ele possui pelo menos uma pokébola na sua bolsa.

Caso o pokémon seja **capturado com sucesso** (pode usar um algoritmo randomico para isso):
- Esse pokémon irá ocupar um dos Slots de pokémons do jogador;
- Deverá debitar uma pokébola da sua mochila;
- Na pokédex deverá marcar aquele pokémon como já capturado;
- O jogador deverá ganhar pontos de XP pela captura (pode usar um algoritmo randomico para isso);

Caso o pokémon **NÃO SEJA** capturado:
- Deverá debitar uma pokébola da sua mochila;

![Pokémon Gold Battle](./docs/battle.png)