# Local Development with Docker!
Docker allows us to develop locally using containerized services.

## Instructions
1. Download and install [Docker](https://www.docker.com/products/docker-desktop).
2. Clone this repository.
3. Run these commands to change into the `docker` directory and start the application.
    ```shellsession 
    cd .docker/
    docker-compose up -d
    ```
4. Visit [localhost:8080](localhost:8080) to view the Adminer database management tool. Log in with server: "mysql", username: "root", and password: "password" (no quotes for any).
5. Click SQL Command on the left panel and copy and paste the `data.sql` file. Check the box "Stop on error" so you can see any errors that come up. This creates the `masmall_c` directory and seed the i4 with some data for development.
6. Now visit [localhost:80](localhost:80) and you should see the i4 running! Log in with credentials "Test User" and "password" (again, no quotes).

# Acknowledgements
The `Dockerfile` and `docker-compose.yml` come from [this site](https://dev.to/truthseekers/setup-a-basic-local-php-development-environment-in-docker-kod).