## Setup

### Git Clone

```bash
$ git clone https://github.com/repo-owner/repo-name.git teste_fernandohcorrea
```
---

### Composer Install

```bash
$ cd teste_fernandohcorrea
$ composer.phar install
```
---

### Npm install

```bash
$ npm install
```
---

### Npm install

```bash
$ npm install
```

---

### Env

```bash
$ cp .env.example .env
```
É necessário editar esse arquivo para definir o ##CAMINHO_COMPLETO##
DB_DATABASE=/##CAMINHO_COMPLETO##/teste_fernandohcorrea/database/database.sqlite

---

### Migration (database)

```bash
$ php artisan migrate:install
$ php artisan migrate:refresh
```

---

### Testes

```bash
$ phpunit.phar
```




