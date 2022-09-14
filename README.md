## Getting Started

This is how you can set up this project locally. To get a local copy up and running follow these simple example steps.

### Installation

1. Clone the repo
    ```sh
    git clone
    ```
2. Install all the packages of new application
    ```sh
    composer install
    ```
3. Create the env file
    ```sh
    cp .env.example .env
    ```
4. Generate a key
    ```sh
    php artisan key:generate
    ```
5. Modify the env file with your database credentials
    ```sh
    DB_DATABASE = example_db_name
    DB_USERNAME = example_user
    DB_PASSWORD = example_password
    ```
6. Modify the env file with your SMTP credentials (_MailTrap recommended_)
    ```sh
    MAIL_MAILER = smtp
    MAIL_HOST = example_host
    MAIL_PORT = example_port
    MAIL_USERNAME = example_username
    MAIL_PASSWORD = example_password
    MAIL_ENCRYPTION = example_encryption
    MAIL_FROM_ADDRESS = "no-reply@example.com"
    MAIL_FROM_NAME = "${APP_NAME}"
    ```
7. Modify the 'QUEUE_CONNECTION' in the env file
    ```sh
    QUEUE_CONNECTION=database
    ```

8. Create the tables in the database

    ```sh
    php artisan migrate
    ```

9. Fill the tables with the data
    
    ```sh
    php artisan db:seed
    ```

10. Install package manager for the JavaScript

    ```sh
    npm install & npm run dev
    ```

11. Add this code in your env file

    ```sh
    L5_SWAGGER_CONST_HOST=http://localhost:8000/
    ```
    
    then run
    ```sh
    php artisan l5-swagger:generate
    ```

12. Serve the project

    ```sh
    php artisan serve
    ```

    or if there is some other project running at port 8000

    ```sh
    php artisan serve --port=8001
    ```

13. Enable Queue work in the background
    ```sh
    php artisan queue:work
    ```

    so the jobs could be processed in the background

14. Access the project at http://localhost:8000/ or the custom port that you set up

15. Access the api documentation at http://localhost:8000/api/documentation
