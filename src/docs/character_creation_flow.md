# Fluxo de Criacao de Personagem (Tormenta20)

Este backend expoe um fluxo de criacao em 3 fases:

1. Carregar opcoes e regras.
2. Validar a ficha antes de salvar.
3. Salvar personagem final.

## Referencias utilizadas para estruturar o fluxo

- Kit Introdutorio oficial da Jambo (estrutura geral de entrada no sistema).
- Compendios comunitarios de T20 para estrutura de passos e dados de origem:
  - Construção de personagem T20 (TSRD/Fandom)
  - Origens T20 (TSRD/Fandom)

## Endpoints

### 1) Opcoes de criacao

GET /api/character-creation/options

Retorna:

- steps: etapas da criacao.
- attribute_rules: regras de distribuicao por pontos e por rolagem.
- races: lista de racas.
- classes: lista de classes.
- origins: lista de origens com features (itens, pericias, poderes, status).

### 2) Pre-validacao da ficha

POST /api/character-creation/preview

Valida:

- Dados obrigatorios de raca, classe, origem, atributos e usuario.
- Coerencia de atributos por metodo:
  - point_buy: custo total ate 10 e faixa de -1 a 4.
  - rolled: faixa de -2 a 4 e soma minima 6.
- Beneficios de origem: ate 2 e pertencentes a origem escolhida.

### 3) CRUD de personagens

- GET /api/characters
- GET /api/characters/{id}
- POST /api/characters
- PUT/PATCH /api/characters/{id}
- DELETE /api/characters/{id}

A criacao/edicao usa a mesma validacao da pre-visualizacao.

## Exemplo de payload para criacao

{
  "name": "Arthos",
  "user_id": 1,
  "race_id": 2,
  "class_id": 1,
  "origin_id": 4,
  "level": 1,
  "deity": "Wynna",
  "concept": "Mago timido e estudioso",
  "attribute_method": "point_buy",
  "strength": 0,
  "dexterity": 1,
  "constitution": 1,
  "intelligence": 4,
  "wisdom": 2,
  "charisma": 0,
  "origin_benefits": ["Percepcao", "Sentidos Aguçados"],
  "trained_skills": ["Misticismo", "Conhecimento", "Percepcao"],
  "powers": ["Sentidos Aguçados"],
  "equipment": ["Bastao", "Mochila", "Livro"],
  "spells": ["Seta Infalivel", "Armadura Arcana"],
  "max_hp": 11,
  "max_mp": 3,
  "defense": 11,
  "size": "Médio",
  "displacement": "9m"
}

## Campos adicionados na tabela characters

- origin_id
- deity
- concept
- attribute_method
- strength, dexterity, constitution, intelligence, wisdom, charisma
- origin_benefits (json)
- trained_skills (json)
- powers (json)
- equipment (json)
- spells (json)
- max_hp, max_mp, defense
- size, displacement
