# rides-for-drivers-and-stores
O objetivo do projeto é criar uma plataforma de entregas que permita aos lojistas gerenciar pedidos, motoristas e corridas, enquanto oferece aos clientes uma experiência de rastreamento em tempo real e aos motoristas uma forma eficiente de gerenciar e concluir entregas.

## Conta para loja teste
- **E-mail:** `store@test.com`  
- **Senha:** `password`

## Como Rodar o Projeto

### Inicie o banco de dados
```bash
docker-compose up -d
```
Se for a primeira vez rodando, construa os containers:
```bash
docker-compose logs -f
```

### Prepare o .env
```bash
cp .env.example .env
```

### Instale o projeto
```bash
composer install
```

```bash
npm install && npm run dev
```

### Gere uma chave
```bash
php artisan key:generate
```

### Migre o banco de dados
```bash
php artisan migrate --seed
```

### Gere cache para o filament
```bash
php artisan optimize
```

### Inicie um projeto
```bash
php artisan serve
```

### Limpar cache
```bash
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear
```

### Rodar filament
```bash
php artisan filament:install
```
