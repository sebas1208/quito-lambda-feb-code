# quito-lambda-feb-code
Repositorio con el codigo para el Quito Lamda del mes de Febrero 2022

## Instrucciones para instalar PHP 8.1

*Notas: Para este demo usaremos Ubuntu 20.04

* Vamos a compilar PHP desde 0 aunque tambien hay como instalar desde los repositorios oficiales de Ubuntu o la distro/OS que tengas instalado.

- Install `asdf`
```
git clone https://github.com/asdf-vm/asdf.git ~/.asdf --branch v0.9.0 
```
or
```
brew install asdf
```
- `sudo apt install autoconf mlocate gcc curl git bison re2c libxml2-dev openssl libssl-dev sqlite3 libsqlite3-dev zlib1g-dev libcurl4-openssl-dev libgd-dev g++ libonig-dev libpq-dev libreadline-dev libzip-dev build-essential`
- `asdf plugin-add php https://github.com/asdf-community/asdf-php.git`
- `asdf install php latest`
