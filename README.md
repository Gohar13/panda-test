<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>


## Project Deployment
Steps to Set Up the Project
Follow the steps below to get the project running on your local environment.

1. Clone the Repository
   Clone the project from the repository URL:
    ```
    git clone <projectUrl>
    ```
2. Navigate to the Project Folder
   Change into the project directory:
    ```
    cd <projectFolder>
    ```

3. Copy the Environment File
   Create a new .env file from the example:

    ```
    cp .env.example .env
    ```

4. Build Docker Containers
   Build the Docker containers using Docker Compose:

    ```
    docker-compose build
    ```

5. Start Docker Containers
   Start the Docker containers in the background:

    ```
    docker-compose up -d
    ```

6. Verify the Containers are Running
   Check the running containers to ensure everything is up:

    ```
    docker ps
    ```

7. Access the Docker Container
   Get a shell inside the running Docker container:

    ```
    docker exec -it <containerId> bash
    ```

   Replace <containerId> with the actual container ID from the docker ps output.

8. Install Project Dependencies
   Inside the Docker container, run the following to install PHP dependencies:

    ```
    composer install
    ```

9. Generate Application Key
   Generate the Laravel application key:

    ```
    php artisan key:generate
    ```

10. Run Migrations
    Run the database migrations:

    ```
    php artisan migrate
    ```

11. Set Up Queue Configuration
    I will use database as my queue driver. Eensure that your .env file is properly configured for queueing
    ```
    QUEUE_CONNECTION=database
    ```

   To process the queued jobs, use the following command inside your Docker container:
    ```
    php artisan queue:table
    php artisan migrate
    php artisan queue:work

    ```
12. Configure the Mailer
    For email functionality, you need to configure the mailer. In the .env file, update the following settings:
    ```
    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME=

    ```

13. Access the Application
    You can access to swagger doc and make a request via Swagger UI, where you can test the subscribeToPriceChange endpoint

    ```
    http://localhost:8080/api/documentation#/Subscription/subscribeToPriceChange
    ```

14. Configure Laravel Scheduler
    Run the Laravel Scheduler Manually: To run the scheduled commands manually (like `price:track-changes every `five minutes), you can use this command inside your Docker container:
    ```
    php artisan schedule:run

    ```
15. Testing the Application
     You can run the tests to ensure everything is working as expected:
    ```
    php artisan test

    ```
