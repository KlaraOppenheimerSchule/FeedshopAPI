# Feedshop API
***
## Project structure
### Directories
* `/docker` All dockerfiles and the config files necessary for the containers
* `/code/src` All necessary php source files for the application
* `/code/public` The public directory of the web server
* `/code/test`
***
## Setup Project Development 

### Working Way to Setup:
- Requieres: Docker, Docker-Compose
* run `docker-compose up -d`
* run `docker exec feedshopAPI_php php composer.phar install`

### Use Postman with the provided Collection in the Project Directory
***
## Development API-Key Use
* Use Software like Postman with the following Header - api-token defined in code/src/config/development/application.ini
* KEY: api-token
* VALUE: User 6e176cba-e137-475a-b3b4-c199b6ta756x
***
## Development database connection
For Software like MySqlWorkbench or DBEaver
* url: `localhost` 
* user: `root`
* password: `123456`
