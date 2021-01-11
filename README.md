# Clean Architecture com Pokémon

A ideia deste repositório é praticar os conceitos da Clean Architecture de um modo divertido e prático integrando uma API com uma [API de Pokémon de Terceiros](https://pokeapi.co/).

Aqui irei tentar replicar algumas regras do clássico jogo Pokémon Gold do Gameboy.

![Pokémon Gold Logo](./docs/pokemon-gold.png)

## Pré-Requisitos

- PHP 7.4 ou superior;
- [Composer](https://getcomposer.org);
- [Slim Framework 4](https://www.slimframework.com);
- [Docker](https://www.docker.com); 
- Sistema de Migrations com [PHINX](https://phinx.org);
- Sistema de Cache com [Redis](https://redis.io);
- Especificação de Respostas JSON com [JSend](https://github.com/omniti-labs/jsend);

## Desenho Macro da Arquitetura

Montei um diagrama mostrando como está arquitetado a aplicação baseado nos meus estudos e no meu entendimento da Clean Architecture. Esse diagrama pode ser atualizado (e com certeza será) no decorrer do desenvolvimento desse estudo:

![Arquitetura App](./docs/brainstorms/clean-arch-app-flow.png)

## Referências e Links

- [Introdução a Arquitetura de Software](https://blog.taller.net.br/introducao-a-arquitetura-de-software)
- [Clean Architecture I – Overview](https://blog.taller.net.br/clean-architecture-overview)
- [erandirjunior/vehicle-backend](https://github.com/erandirjunior/vehicle-backend)
- [erandirjunior/fortbrasil-backend](https://github.com/erandirjunior/fortbrasil-backend)
- [rmanguinho/clean-ranking-loader](https://github.com/rmanguinho/clean-ranking-loader)
- [In Clean Architecture, where to put validation logic?](https://ikenox.info/blog/where-to-put-validation-in-clean-architecture/#:~:text=Just%20as%20Clean%20Architecture%20splits,differrent%20depending%20on%20its%20context.)
- [REST, GraphQL, Clean Architecture e TypeScript com Rodrigo Manguinho // Live #69](https://www.youtube.com/watch?v=P0gpCCA8ZPs)

## Casos de Uso

Abaixo estão listadas os casos de uso para termos uma ideia fechada de Domínio e Regras de Negócios:

- [Inicar uma Batalha (Battle Start)](./docs/usecases/battle-start);
- [Capturar um Pokémon (Catch Pokemon)](./docs/usecases/catch-pokemon);
- [Informações do Jogador (Player Info)](./docs/usecases/player-info);
- [Comprar Items (Purchase)](./docs/usecases/purchase);