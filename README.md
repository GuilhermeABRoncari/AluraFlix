## API Aluraflix

`Descrição:` 
Este projeto foi desenvolvido com o objetivo de aprimorar minhas habilidades em PHP/Laravel, focando na criação de uma API Rest. Este projeto atende aos requisitos do desafio Alura Challenge-05, conhecido como 'AluraFlix'.. Trata-se de um sistema CRUD que permite às pessoas postar e assistir a vídeos sob demanda.

`Tecnologias:`
- PHP 8.2
- Laravel 8
- MySQL
- Docker

## Funcionamento e Endpoints

Para utilizar a API e acessar a maioria de seus endpoints, é necessário realizar a autenticação, se registrando com um email, name (nome), senha (password) e confirmação de senha (password_confirmation), a senha deve conter 8 caracteres, uma letra maiuscula, um numero e um caracter especial, usando o seguinte endpoint:

`POST: /api/registrar`
```json
{
  "name": "Fulano de Tal",
  "email": "fulano@email.com",
  "password": "Pass123*",
  "password_confirmation": "Pass123*"
}
```
Resposta esperada:
```json
"1|cileIpbIzdj3yJNws2zRU5oRkY03PgTeFSbezr4X"
```

O token retornado deve ser utilizado nas requisições no cabeçalho de 'Authorization' como um Bearer token.

## Usuarios

Depois de criado um novo usuario no sistema, ele pode manipular os recursos relacionados a usuarios com os seguintes endpoints:

- `POST: /api/login` - Retorna token de autenticação valido

Exemplo de uso:
```json
{
  "email": "fulano@email.com",
  "password": "Pass123*"
}
```
Resposta esperada:
```json
"1|cileIpbIzdj3yJNws2zRU5oRkY03PgTeFSbezr4X"
```

**Requer autenticação!**

- `GET: /api/usuarios` - Retonar de forma paginada todos os usuarios
- `GET: /api/usuarios/<id do usuario>` - Retorna usuario informado no ID
- `PATCH: /api/usuarios` - Atualiza name (nome) do usuario atual

Exemplo de uso:
```json
{
  "name": "Ciclano de Tal"
}
```
Retorno esperado:
```json
{
    "id": 1,
    "name": "Ciclano de Tal",
    "email": "teste@email.com",
    "email_verified_at": null,
    "created_at": "2024-01-07T14:29:48.000000Z",
    "updated_at": "2024-01-07T15:06:33.000000Z"
}
```

- `DELETE: /api/usuario` - Deleta registro do usuario atual

Para deletar o registro do usuario autenticado atual é preciso fornecer a senha correta do usuario e uma confirmação da senha.

Exemplo de uso:
```json
{
    "password": "Test123*",
    "password_confirmation": "Test123*"
}
```
Retorno esperado é o status '204 no content'.

## Categorias

**Requer autenticação!**

As categorias são usadas para classificar os vídeos, organizando-os e facilitando a busca e navegação na API.

Aqui estão todos os endpoints relacionados aos recursos de Categoria:
- `GET: /api/categorias` - Retorna todas as categorias Salvas

Retorna de forma paginada todas as categorias armazenadas no banco de dados.

- `POST: /api/categorias` - Cria nova categoria

Deve ser fornecido um título em caixa alta e uma cor hexadecimal válida em CSS.

Exemplo de uso:
```json
{
    "titulo": "LIVRE",
    "cor": "Ffffff"
}
```
retorno esperado:
```json
{
    "mensagem": "Categoria criada com sucesso: /api/categoria/1",
    "data": {
        "titulo": "LIVRE",
        "cor": "Ffffff",
        "updated_at": "2024-01-07T14:42:04.000000Z",
        "created_at": "2024-01-07T14:42:04.000000Z",
        "id": 1
    }
}
```
- `GET: /api/categorias/<id da categoria>` - Obtem uma categoria especifica por ID

Retorna um JSON da categoria informada como id na url.
Caso não exista, será retornado o status '404 not found'.

- `PUT: /api/categorias/<id da categoria>` - Atualiza uma categoria

É possivel atualizar o titulo ou a cor de uma categoria, caso um destes atributos não seja especificado então não será atualizado.

Exemplo de uso:
```json
{
  "cor": "008000"
}
```
Retorno esperado:
```json
{
    "id": 1,
    "titulo": "LIVRE",
    "cor": "008000",
    "created_at": "2024-01-07T14:42:04.000000Z",
    "updated_at": "2024-01-07T14:58:14.000000Z"
}
```

- `GET: /api/categorias/<id da categoria>/videos` - Obtem videos por categoria

Retorna de forma paginada todos os videos relacionados a categoria informada.

- `DELETE: /api/categorias/<id da categoria>` - Deleta categira do banco de dados

## Videos

Endpoints para manipular os recursos de videos:

- `GET: /api/videos/free` - Retona lista de 5 videos diarios

Todos os dias serão retornados 5 videos aleatorios para serem consumidos de forma livre, sem a necessidade de autenticação na API.

**Requer autenticação!**

- `GET: /api/videos` - Retona paginação de videos
- `GET: /api/videos/<id do video>` - Retorna video informado por ID
- `GET: /api/videos?search=<pesquisa do usuario>` - Retorna videos relacionados a pesquisa

Esse endpoint retorna de forma paginada todos os videos cujo o titulo estiver relacionado a pesquisa fornecida pelo usuario na url no parametro 'search'.

- `POST: /api/videos` - Cria novo registro de video

Para criar um novo registro de video deve ser fornecido de forma obrigatoria um titulo, uma descrição e uma url valida.

Sempre que se cria um novo registro, não é necessario fornecer um 'categoria_id'. Caso não informado, a categoria atribuida será a 'LIVRE' de id = 1.

Exemplo de uso:
```json
{
    "titulo": "Carnaval",
    "descricao": "Teste",
    "url": "https://www.youtube.com/watch?v=zWGBfUgSpH8&ab_channel=Gaveta",
    "categoria_id": 1
}
```
- `PUT: /api/videos/<id do video>` - Atualiza video infromado por ID

O que pode ser atualizado são titulo, descrição, url e categoria. Caso algum atributo não seja informado será mantida a informação original. Caso tente atualizar a categoria para uma categoria que não existe será retornada resposta status '400 bad request'.

Exemplo de uso:
```json
{
  "categoria_id": 2
}
```
Retorno esperado:
```json
{
    "titulo": "Carnaval",
    "descricao": "Teste",
    "url": "https://www.youtube.com/watch?v=zWGBfUgSpH8&ab_channel=Gaveta",
    "categoria_id": 2
}
```

- `DELETE: /api/videos/<id do video>` - Deleta video do banco de dados

Retorno esperado é de status '204 no content'.
