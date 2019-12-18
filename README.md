## Smart House Monitoring System - SHMS

API construida em Laravel para uma Casa Inteligente automatizada com dispositivos IoT, onde é possível cadastrar sensores e registrar medições dos sensores cadastrados. API desenvolvida como atividade avaliativa para a displina de Desenvolvimento para Web II.

## Como rodar

clone do projeto:

**`git clone https://github.com/K0rgana/api_SHMS`**

Entre no diretorio e rode o makefile:

**`cd api_SHMS/; make conf`**

Altere as seguintes informações do arquivo .env colocando o nome do seu banco, usuario e senha.

> DB_DATABASE=laravel

> DB_USERNAME=root

> DB_PASSWORD=

Crie as tabelas do banco com o seguinte comando:

 **`php artisan migrate`**

Rode o servidor:

**`php artisan serve`**


## Collab

- [Juciele Fernandes](https://github.com/jucielefernandes)
- [Morgana Albuquerque](https://github.com/K0rgana)
- [Tamires Silva](https://github.com/siilvatamires)

[![Bless](https://cdn.rawgit.com/LunaGao/BlessYourCodeTag/master/tags/bacon.svg)](http://lunagao.github.io/BlessYourCodeTag/)
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
