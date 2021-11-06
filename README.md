# Pré-requisitos
## Banco de Dados
- Docker
## PHP
- Versão superior a 7.
## Servidor
nginx

# Tecnologias Utilizadas 
- nginx
- Laravel
- VS Code
- Composer
- Npm
- Docker
- Vue.js
- Rest API com PHP
- Postman


# Intalação
```bash
git clone https://github.com/brunoverdan/oderco.git oderco
cd oderco
composer install
mv .env.example .env
php artisan key:generate

```

##Configurar arquivo .env para os banco da dados
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=cotacaodb
DB_USERNAME=root
DB_PASSWORD=root
```
##bash
```bash
php artisan migrate
npm install
npm run dev
php artisan serv
```
Suba os containers do projeto
```sh
docker-compose up -d
```
##Teste com Postman
##listar
```sh
Get -> http://localhost:8000/cotacao 
```
#Gravar
```sh
Post- >http://localhost:8000/cotacao [JSON]
{
    "uf" : "PR",
    "porcentual_cotacao" : 2.95,
    "valor_extra": 14.35,
    "transportadora_id": 5
}
```
#executar Calculo
```sh
Put -> http://localhost:8000/cotacao [JSON]
{
   "uf": "PR",
   "valor_pedido": 600
}
```
##Acessar o Sistema
#Browser
http://localhost:8000/

# Autor

Bruno Verdan

# oderco
