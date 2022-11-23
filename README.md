# API REST de gerenciamento de Imóveis

 Modelo de API Rest responsável por servir uma plataforma de gerenciamento de imóveis.  
 A aplicação conta com os seguintes métodos:  

* Cadastro de usuário - Senhas criptografadas com **Hash**.
* Login de usuário - Autenticação via **Json Web Token**.
* Cadastro de imóvel.
* Busca de um imóvel.
* Busca de lista de imóveis com paginação.
* Edição de um ou mais dados de um imóvel.
* Exclusão de um imóvel.

## Principais técnologias

* **PHP**
* **Laravel**
* **JWT**

## Instalação 

Após baixar os arquivos, será necessário crir um arquivo .env onde serão configuradas as variávies de ambiente.  
Utilize o seguinte formato:  

APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=host
DB_PORT=porta
DB_DATABASE=nome_da_base_de_dados
DB_USERNAME=usuário
DB_PASSWORD=senha

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

Após a configuração das variáveis basta instalar as dependências com:

```
composer install
```

## Execução

A aplicação utiliza **Dotenv** para carregar o arquivo .env com as variávies de ambiente.  
Esta requisição é feita atráves da execução da api no terminal.  
Para inicar a aplicação, basta ir ao diretório raiz e executar o seguinte comando:

```
node -r dotenv/config ./src/app.js
```

Ao iniciar, o Sequelize fará a consulta das tabelas de usuários e imóveis no banco. Caso não existam, irá criá-las automaticamente.
Caso esteja em ambiente de desenvolvimento, é possível forçar a criação de novas tabelas vazias, toda vez que a API é iniciada. Basta alterar o parâmetro *force* para *true* no app.js

```
sequelize.sync({ force: true }).then(() => {
    const port = process.env.PORT || 3000;

    app.set('port', port);

    const server = http.createServer(app);

    server.listen(port, () => console.log('Server online on http://localhost:' + port));
});
```

## Métodos

### Cadastro de usuário

| Método   |           Rota             |
| -------- |:--------------------------:|
| POST     | /api/usuarios/cadastro     |  

##### Requisição

```
body:
{
    "name": "Nome completo do usuário",
    "cpf": "000.111.222-00",
    "email": "email@dominio.com",
    "pwd": "senha"
}
```

##### Resposta

###### Status Code 201

```
{
    "id": 1
}
```

---

### Login de usuário

| Método   |           Rota             |
| -------- |:--------------------------:|
| POST     | /api/usuarios/login        |  

##### Requisição

```
body:
{
    "email": "email@dominio.com",
    "pwd": "senha"
}
```

##### Resposta

###### Status Code 200

```
{
    "id": 1,
    "email": "email@dominio.com",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiZW1haWwiOiJyYWZhZWxmZXJyZWlyYUBob3RtYWlsLmNvbSIsImlhdCI6MTYyMzAxMTI2NSwiZXhwIjoxNjIzMDEyMTY1fQ.BEfNCd7g4QYNBrQOzAeRuuT35qXUZjReD3y55bZbG0E"
}
```

---

### Cadastrar imóvel

| Método   |           Rota             |
| -------- |:--------------------------:|
| POST     | /api/imoveis               |  

##### Requisição

```
header:
{
    Authorization: Bearer {token}
}
body:
{
    "cep": "12345-123",
    "number": 100,
    "complement": "complemento",
    "price": 150000,
    "rooms": 2,
    "available": true
}
```

##### Resposta

###### Status Code 201

```
{
    "available": true,
    "id": 1,
    "cep": "12345-123",
    "number": 100,
    "complement": "complemento",
    "price": 150000,
    "rooms": 2,
    "updatedAt": "2021-06-07T16:21:41.369Z",
    "createdAt": "2021-06-07T16:21:41.369Z"
}
```

---

### Buscar imóvel

| Método   |           Rota             |
| -------- |:--------------------------:|
| GET      | /api/imoveis/:id           |  

##### Requisição

```
header:
{
    Authorization: Bearer {token}
}
```

##### Resposta

###### Status Code 200

```
{
    "available": true,
    "id": 1,
    "cep": "12345-123",
    "number": 100,
    "complement": "complemento",
    "price": 150000,
    "rooms": 2,
    "updatedAt": "2021-06-07T16:21:41.369Z",
    "createdAt": "2021-06-07T16:21:41.369Z"
}
```

---

### Buscar imóveis

Neste método, por questões de performace, o resultado é dividido em páginas, sendo necessário passar o limite de itens por página, e qual intervalo buscar. Também retorna o número total de registros.

| Método   |           Rota             |
| -------- |:--------------------------:|
| GET      | /api/imoveis/?page=""&limit=""           |  

##### Requisição

###### Exemplo com rota api/imoveis/?page=1&limit=5

```
header:
{
    Authorization: Bearer {token}
}
```

##### Resposta:

###### Status Code 200

```
"count": 20,
    "propertiesFound": [
    {
        "id": 6,
        "cep": "12345-123",
        "number": 100,
        "complement": "complemento",
        "price": "150000.00",
        "rooms": 2,
        "available": true,
        "createdAt": "2021-06-07T16:22:32.000Z",
        "updatedAt": "2021-06-07T16:22:32.000Z"
    },
    {
        "id": 7,
        "cep": "12345-123",
        "number": 100,
        "complement": "complemento",
        "price": "150000.00",
        "rooms": 2,
        "available": true,
        "createdAt": "2021-06-07T16:22:33.000Z",
        "updatedAt": "2021-06-07T16:22:33.000Z"
    },
    {
        "id": 8,
        "cep": "12345-123",
        "number": 100,
        "complement": "complemento",
        "price": "150000.00",
        "rooms": 2,
        "available": true,
        "createdAt": "2021-06-07T16:22:33.000Z",
        "updatedAt": "2021-06-07T16:22:33.000Z"
    },
    {
        "id": 9,
        "cep": "12345-123",
        "number": 100,
        "complement": "complemento",
        "price": "150000.00",
        "rooms": 2,
        "available": true,
        "createdAt": "2021-06-07T16:22:34.000Z",
        "updatedAt": "2021-06-07T16:22:34.000Z"
    },
    {
        "id": 10,
        "cep": "12345-123",
        "number": 100,
        "complement": "complemento",
        "price": "150000.00",
        "rooms": 2,
        "available": true,
        "createdAt": "2021-06-07T16:22:34.000Z",
        "updatedAt": "2021-06-07T16:22:34.000Z"
    }
]

```

---

### Editar imóvel

Neste método é possível atualizar, um ou mais dados do imóvel.

| Método   |           Rota             |
| -------- |:--------------------------:|
| PATCH      | /api/imoveis/:id         |  

##### Requisição:

```
header:
{
    Authorization: Bearer {token}
}
body:
{
    "cep": "678901-321",
    "available": false
}

```

##### Resposta

###### Status Code 200

### Editar imóvel

Neste método é possível atualizar, um ou mais dados do imóvel.

| Método   |           Rota             |
| -------- |:--------------------------:|
| PATCH      | /api/imoveis/:id         |  

##### Requisição

```
header:
{
    Authorization: Bearer {token}
}
body:
{
    "cep": "678901-321",
    "available": false
}

```

##### Resposta

###### Status Code 200

---

### Deletar imóvel

| Método   |           Rota             |
| -------- |:--------------------------:|
| DELETE   | /api/imoveis/:id           |  

##### Requisição

```
header:
{
    Authorization: Bearer {token}
}

```

##### Resposta:

###### Status Code 200

## Principais camadas da aplicação

As requisições possuem três etapas, cada uma com sendo executada em camadas distintas.
A execução poressegue nesta ordem: Route -> Controller -> Service.

### Route

É Responsável por identificar os métodos e rotas da requisição, e então direcionar ao controller. Também fica responsável por chamar o middleware de validação do token.

Exemplo de rota de cadastro de imóveis:

```
router.post('/imoveis', login.validate, controller.registerNewProperty);
```

### Controller

A principal função da camada controller é receber as requisições e enviar as respostas. Ela apenas organiza as informações do corpo da requisição e envia para camada service. Então responde conforme o retorno.

Exemplo de controller do cadastro de imóveis:
```
exports.registerNewProperty = async (request, response, next) => {
    try {
        const property = {
            cep: request.body.cep,
            number: request.body.number,
            complement: request.body.complement,
            price: request.body.price,
            rooms: request.body.rooms
        };

        const newProperty = await service.registerNewProperty(property);
        response.status(Status.CREATED).send(newProperty);
    } catch (error) {
        next(error);
    }
}
```

### Service

Aqui que acontece de fato a regra de negócio. É na camada service que toda a lógica acontece e onde são chamadas as funções de conexão do banco de dados.

Exemplo do service de login de usuário:
```
exports.login = async (data) => {
    const user = await findUser(data.email);
    if (user) {
        const isPwdValid = await security.comparePassword(data.pwd, user.pwd);
        if (isPwdValid) {
            const token = security.generateToken(user);
            return {
                id: user.id, email: user.email,
                token: token
            };
        } else {
            return 'UNAUTHORIZED';
        }
    } else {
        return 'UNAUTHORIZED';
    }
}
```
## Testes automatizados

A aplicação possui uma rotina de teste que utiliza **Jest** para execução.
Ela conta com onze etapas que testam todas os métodos e o tratamento de alguns possíveis erros.

São eles:

|Teste|Retorno|
|--|--|
|Should create a user|Deve retornar o Id do usuário cadastrado|
|Should not duplicated email|Deve retornar Status 409 por e-mail duplicado|
|Should not validate cpf|Deve retornar Status 400 por formato de CPD inválido|
|Should login|Deve retornar Status 200. Também registra o token para os próximos testes|
|Should not login|Deve retornar Status 401 por senha inválida|
|Should save a property|Deve retornar Status 201|
|Should get a property|Deve retornar Status 200|
|Should update one item in a property|Deve retornar Status 200 e o campo CEP deve ser igual ao requisitado|
|Should recieve bad request status|Deve retonar Status 400 por formato inválido no CEP|
|Should delete a property|Deve retornar Status 200|
|Should save, get and delete many properties|Deve retornar todos os três imóveis cadastrados e então apaga-los|

Para executar os testes, as tabelas precisam estar vazias. Então entre na pasta test execute o comando:
```
jest --env node

```

### Contato
Para mais informações entre em contato:

* Email: rafael.j.ferreira@hotmail.com
* LinkedIn: <https://www.linkedin.com/in/rafael-juliano-ferreira-991084169>
