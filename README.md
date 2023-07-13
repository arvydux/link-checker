# Link checker app

![alt text](Screenshot_1.png)

![alt text](Screenshot_2.png)
----------

## Setup
- `git clone https://github.com/arvydux/link-checker.git`
- `cd link-checker`
- `docker-compose up -d`
- `docker exec app composer install`
- `cp .env.example .env`
- `docker-compose exec app php artisan migrate`
- `docker-compose exec app php artisan key:generate`

Don't forget to run the scheduler locally to be able to automatically check links twice a day.

    docker-compose exec app php artisan schedule:work

Now that all containers are up, access `localhost.links` on your favorite browser

## Questions and Improvements

For any question or emprovement please send an e-mail to Arvydas Kavaliauskas [arvydas.kavaliauskas83@gmail.com](mailto:arvydas.kavaliauskas83@gmail.com).
