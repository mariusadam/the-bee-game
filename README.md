# Steps

1. Install dependencies:
    
    `docker-compose run --rm --user ${UID} php composer install`
2. Run tests:
   
   `docker-compose run --user ${UID} php vendor/bin/phpunit`
   
3. Start the container:
   
   `docker-compose up # without -d so that we can see the access logs`

4. Login into the running container

   `docker-compose exec --user ${UID} php sh`
