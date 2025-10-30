## Passos para rodar o projeto

1. **Crie o arquivo `.env`**
   Caso não existir:

```bash

cp .env.example .env
```

2. **Crie o banco de dados**

```bash

 mkdir -p database
 touch database/database.sqlite
```

_No arquivo .env, confirme que a configuração está assim:_

**DB_CONNECTION=sqlite**

**DB_DATABASE=/var/www/html/database/database.sqlite**

3. **Suba o container no Docker**

```bash

 docker-compose up --build
```

4. **Gere uma chave de aplicação**

```bash

 docker exec -it laravel_app php artisan key:generate
```

5. **Rode migrations**

```bash

 docker exec -it laravel_app php artisan migrate
```

6. **Acesso ao projeto**

 *http://localhost:8000*
