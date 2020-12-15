
## Description
Simple project management application with chat.
Chat websocket source code: [https://github.com/rufaidulk/duck-chat](https://github.com/rufaidulk/duck-chat)

## Project Setup
- Clone the repository
- Copy .env.example file to .env and edit database credentials there
- Run ``composer install``
- Run ``php artisan key:generate``
- Run ``php artisan migrate --seed`` remove ``--seed`` option if you don't want test data in DB
