First of all set .env params. Also set QUEUE_CONNECTION=database to use queries through DB.

Install composer:

    composer install

Start docker via:

    docker compose run -d

Run migrations at testjob-app container:

    docker exec testjob-app php artisan migrate

You can check DB by phpMyAdmin running at:

    http://localhost:8088/

Start query worker with:

    docker exec testjob-app php artisan queue:work --queue=submission-submit

Send a POST request to: 

    http://localhost:8000/api/submit

    {
      "name": "John Doe",
      "email": "john.doe@example.com",
      "message": "This is a test message."
}

To start UnitTest use:

     docker exec testjob-app php artisan test
