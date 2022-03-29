# Slim Boilerplate
Slim Framework boilerplate, start project with ``ORM``, ``dotenv`` support, and some magic features.

### List of Packages
Here is a list of packages used in this boilerplate:
- Slim v4
- PHP-DI Slim Bridge
- Symfony Console
- Eloquent ORM
- DotENV
- Latte View Engine

## Installation & Setup
You need a [composer](https://getcomposer.org) and [git](https://git-scm.com) for download and install the repository and all dependencies
```bash
git clone https://github.com/irsyaduliad/slim-boilerplate
composer install
```
After this repository is cloned and all dependencies have been installed, then copy the ``.env.example`` file to ``.env`` file.
```bash
cp .env.example .env
```
The application is ready to use, run ``php bolt serve`` to start the development server

### Notes
- For the ORM Documentation, see at [laravel docs](https://laravel.com/docs/9.x/eloquent)
- For the Latte usage and documentation, check here at [latte docs](https://latte.nette.org/en/)
