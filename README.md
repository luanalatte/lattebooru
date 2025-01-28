# Lattebooru

Imageboard software built in Laravel 11.

This is a hobby project, and a Laravel playground for me. It is likely never going to be ready for widespread use, and that's fine.

## Current features

- Simple image posts
- Tags and tag-based search
- Comments
- User profiles
- Hidden and private posts

## Planned features

- All of the usual booru stuff (ratings, favorites, collections, a comprehensive tag search, tag wiki, etc.)
- API? maybe.

## Contributing

Suggestions and bug reports are the most welcome at the moment, you can do so in the Issues tab.

You can also contribute code if you want, but keep in mind this is my personal project and I will be _very_ picky with the style of code and features I add. Code contributions will most likely be taken as suggestions with no pressure to be merged into main.

## Setting up the project

1. Clone the repo and install the dependencies. A `shell.nix` file is provided for those who use it. It can also be read as a system dependencies file (php version and extensions, pnpm, etc.)

```bash
  composer install
  pnpm install
```

2. Copy `.env.example` to `.env` and set it up. Remember to generate the Laravel encryption key:

```bash
cp .env.example .env
php artisan key:generate
```

3. Create the database (sqlite by default), execute migrations, and seed roles and permissions.

```bash
php artisan migrate
php artisan db:seed RoleSeeder
```

4. Create an administrator account.

```bash
php artisan setup:admin
```

5. Start the server(s)

Note: A vscode `tasks.json` example file is provided to execute these commands in parallel

```bash
  php artisan serve
  pnpm vite
```
