# Test Task Project

Test Task Project

## Symfony 4 Backend API and postgres database

Enter the symfony4_backend folder and run the following command to create a docker container with the api and postgres database:
`docker-compose up -d`
No other commands are required to run the api and postgres database in docker container.

The api will be available at the following address: `http://localhost:8080/`.

The data file is in the following path: `/var/data/orders.json`
Data can be imported with the following command: `php bin/console app:import-orders`
Data can be imported with the following request: GET http://localhost:8000/orders/import

When making the request or command, the api imports the following data file: `/var/data/orders.json`

Note: Orders can also be imported using the upload button on the frontend.

## Angular Frontend
Enter the angular-frontend folder and run the following command to create a docker container with the angular frontend:
`docker-compose up -d`
No other commands are required to run the angular frontend in docker container.

The api will be available at the following address: `http://localhost:4200/`.