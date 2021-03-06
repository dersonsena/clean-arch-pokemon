# Clean Architecture com Pokémon

A ideia deste repositório é praticar os conceitos da Clean Architecture de um modo divertido e prático integrando uma API com uma [API de Pokémon de Terceiros](https://pokeapi.co/).

Aqui irei tentar replicar algumas regras do clássico jogo Pokémon Gold do Gameboy.

![Pokémon Gold Logo](./docs/pokemon-gold.png)

## Pré-Requisitos

- PHP 7.4 ou superior;
- [Composer](https://getcomposer.org);
- [Docker](https://www.docker.com);

## Tecnologias

- [Slim Framework 4](https://www.slimframework.com);
- Migrations com [PHINX](https://phinx.org);
- Cache com [Redis](https://redis.io);
- Especificação de Respostas JSON com [JSend](https://github.com/omniti-labs/jsend);
- Container Injeção de Dependência com [PHPDI](https://php-di.org);

## Desenho Macro da Arquitetura

Montei um diagrama mostrando como está arquitetado a aplicação baseado nos meus estudos e no meu entendimento da Clean Architecture. Esse diagrama pode ser atualizado (e com certeza será) no decorrer do desenvolvimento desse estudo:

![Arquitetura App](./docs/brainstorms/clean-arch-app-flow.png)

# Camadas e Decisões

## Domain / Entities (Camada Amarela)

Definição do autor:

> Representam seus objetos de domínio, elas reúnem as **Regras Cruciais de Negócios** da aplicação como um todo. Elas podem ser objetos com métodos ou um conjunto de estrutura de dados e funções.

Uma prática que utilizei aqui é que toda Entity deverá ter sua própria Factory, pois não se sabe como as entitdades podem ser criadas no futuro. As factories nos permite ter essa flexibilidade.

Um exemplo prático pode ser visto no [BattleFactory](src/Battle/Domain/Factory/BattleFactory.php).

## Use Cases (Camada Vermelha)

Definição do autor:

> São ações do seu negócio, nelas você terá as **Regras de Negócio Específicas** da sua aplicação. Esses casos de uso orquestram o fluxo de dados a partir das Entidades, e orientam as mesmas para execução de alguma funcionalidade da sua aplicação. As mudanças nessa camada NÃO DEVEM afetar em **absolutamente nada** na camada Entities!

Os use cases são separados por suas respectivas pastas e devem ter pelo menos 3 classes:

- `UseCase.php`: classe principal onde será implementado o caso de uso;
- `InputBoundary.php`: um [DTO](https://pt.wikipedia.org/wiki/Objeto_de_Transfer%C3%AAncia_de_Dados) que representa os dados que serão passados para o caso de uso;
- `OutputBoundary.php`: um [DTO](https://pt.wikipedia.org/wiki/Objeto_de_Transfer%C3%AAncia_de_Dados) que representa os dados de saída que o caso de uso deverá retornar;

Dentro dessa camada também terá os contratos necessários para que as camadas mais externas possam se comunicar com esta.

## Adapters (Camada Verde)

Definição do autor:

> Aqui teremos adaptadores que devem converter os dados no formato que seja mais conveniente para as camadas de Use Case e Entities como também para os agentes externos, como Banco de Dados, Web e etc.

Nessa camada estarão as implementações e adaptações necessárias para que a camada de Use Cases e Entities possam se comunicar com o mundo externo.

## Infra (Camada Azul)

Definição do autor:

> Aqui deverá ter todos os detalhes da sua aplicação como: banco de dados, bibliotecas de terceiros e frameworks. Aqui você deve escrever componentes de associação entre esses mecanismos e a camada/círculo mais interno seguinte.

Aqui terão as classes que farão acesso ao mundo externo: Frameworks, bibliotecas, UI, WEB, CLI e etc.

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

- [Iniciar uma Batalha (Battle Start)](./docs/usecases/battle-start);
- [Capturar um Pokémon (Catch Pokemon)](./docs/usecases/catch-pokemon);
- [Informações do Jogador (Player Info)](./docs/usecases/player-info);
- [Comprar Items (Purchase)](./docs/usecases/purchase);
