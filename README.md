1. Install Docker and Docker-compose in your machine
2. Create a custom docker network (pub_sub_network) for this tutorial. This will enable external communication between two microservices.
docker network create pub_sub_network
3. Ensure that KAFKA_BROKERS=kafka:9092 added to .env file
4. Run docker-compose up -d inside the repo directory.
5. Log in to the microservice 1 container
docker-compose exec kafka_producer_php sh
6. Install composer packages
composer install
7. Run the database migrations
php artisan migrate
8. Browse http://localhost:8787 to verify that microservice 1 is up and running.
