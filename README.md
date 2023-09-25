# Intro

1. Install dependencies:
    
    `docker-compose run --rm --user ${UID} php composer install`
2. Run tests:
   
   `docker-compose run --rm --user ${UID} php vendor/bin/phpunit`
   
3. Start the container:
   
   `docker-compose up # without -d so that we can see the access logs`

Now the game should be available in the browser at http://localhost:8080/

# Notes
* this may seem a bit over-engineered, but I had some fun creating it from scratch
* the idea of the game is that you can randomly hit a bee until the queen dies,
when the queen dies, all the bees die, and the game restarts itself.