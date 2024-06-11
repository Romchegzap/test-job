First of all set .env params. Also set QUEUE_CONNECTION=database to use queries through DB.

Install composer:

    composer install

Start project via:

    vendor/bin/sail up

Run migrations in container:

    vendor/bin/sail shell
    php artisan migrate

You can check DB by phpMyAdmin running at:

    http://localhost:8088/

Start query worker with:

    vendor/bin/sail shell
    php artisan queue:work --queue=submission-submit

Send a POST request to:

    http://localhost:8000/api/submit

    {
      "name": "John Doe",
      "email": "john.doe@example.com",
      "message": "This is a test message."

}

To start UnitTest use:

    vendor/bin/sail shell
    php artisan test
