# Laravel 11 Project Task

### Requirements
    Laravel >= 11
    PHP >= 8.2

### Additional Requirements
    Laravel Breeze >= 2.1
    Tailwindcss >= 3.0.24

## Setup

1. Clone the repository:
    ```
    git clone https://github.com/emilijus-sileikis/kinfirm-app
    ```
2. Navigate to the downloaded directory:
    ```
    cd kinfirm-app/
    ```
3. Install npm dependencies:
    ```
    npm install
    ```
4. Install composer dependencies:
    ```
    composer install
    ```
5. Connect to your database (inside the .env file), make sure ```DB_CONNECTION``` is ```mysql``` and make migration:
    ```
    php artisan migrate
    ```
6. Generate the app key:
    ```
    php artisan key:generate
    ```
7. Build the required frontend files:
    ```
    npm run build
    ```
8. Launch the app:
    ```
    php artisan serve
    ```
    
## Product and stock import:

1. For products (the products won't import unless you have Laravel queues running: ```php artisan queue:work```):
    ```
    php artisan app:import-products
    ```
2. For stock (stock data is also configured to run via cron job, you just have to [set it up](#cron-job-example) on your server):
    ```
    php artisan app:import-stock
    ```

## Main URLs:

Products URL:
    ```
    YOUR_LOCAL_URL/products
    ```
Specific product URL:
    ```
    YOUR_LOCAL_URL/products/{$id}
    ```
Products export API URL (for testing purposes):
    ```
    YOUR_LOCAL_URL/api/products?token=strongtoken3
    ```

## Cron Job Example:

1. Open the server's crontab:
   ```
   crontab -e
   ```
2. Add command execution:
   ```
   * * * * * /usr/bin/php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
   ```
