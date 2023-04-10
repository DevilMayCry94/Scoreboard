## Run Application
- docker-compose build app
- docker-compose up -d app nginx redis
- Enter to console: docker-compose exec app bash
- composer install
- cp .env.example .env
- php artisan key:generate
- check application in browser http://localhost:8000/


## How does it work
- Add football match
- Start match
- Update score
- Finish match
- go to the game statistic page and check statistics of finished matches
