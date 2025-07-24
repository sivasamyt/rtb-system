# Real-Time Bidding System

## Overview
This is a Laravel-based backend for a Real-Time Bidding (RTB) system. It allows authenticated users to bid on advertisement slots during a specified time window. The system automatically evaluates bids after the slot closes and awards the highest bid (or earliest in case of a tie). The application uses Laravel Sanctum for authentication, MySQL for data storage, Redis for queue management, and Laravel Scheduler for bid evaluation.

## Setup Instructions
### Prerequisites
- Docker and Docker Compose
- PHP 8.1+
- Composer
- Redis (optional)
- Git

### Steps to Run
1. **Clone the Repository**
   ```bash
   git clone https://github.com/sivasamyt/rtb-system.git
   cd rtb-system
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment File**
   - git have .env file also.

4. **Set Up Docker**
   - Ensure Docker is running.
   - Update `.env` with:
     ```
     DB_CONNECTION=mysql
     DB_HOST=mysql
     DB_PORT=3306
     DB_DATABASE=your_db_name
     DB_USERNAME=your_db_user_name
     DB_PASSWORD=your_db_password
     REDIS_HOST=redis
     REDIS_PORT=6379
     ```
   - Update `docker-compose.yml` with:
     ```
     MYSQL_DATABASE: your_db_name
     MYSQL_ROOT_PASSWORD: your_db_password
     ```
   - Run Docker Compose:
     ```bash
     docker-compose up -d
     ```

5. **Generate Application Key**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. **Run Migrations and Seeders**
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

7. **Start Queue Worker**
   ```bash
   docker-compose exec app php artisan queue:work redis
   ```

8. **Run Laravel Scheduler**
   - Add a cron job to run the scheduler every minute:
     ```bash
     * * * * * cd /path/to/rtb-system && php artisan schedule:run >> /dev/null 2>&1
     ```
   - Alternatively, for local testing:
     ```bash
     docker-compose exec app php artisan schedule:work
     ```

9. **Access the Application**
   - The API is available at `http://localhost:8000`.
   - Use the sample user credentials below to test authentication.

## Sample User Credentials
- **Admin**: `admin@example.com` / `password`
- **User**: `user@example.com` / `password`

## Running Queue Worker and Scheduler
- **Queue Worker**: Handles bid submissions asynchronously using Redis.
  ```bash
  docker-compose exec app php artisan queue:work redis
  ```
- **Scheduler**: Evaluates bids for closed slots every minute.
  ```bash
  docker-compose exec app php artisan schedule:work
  ```

## Approach
- **Authentication**: Laravel Sanctum provides token-based authentication for users.
- **Ad Slot Management**: Ad slots are managed with a status (`upcoming`, `open`, `closed`, `awarded`) updated via a scheduled command.
- **Bid Placement**: Bids are queued using Laravel’s Redis queue to handle concurrent submissions efficiently.
- **Bid Evaluation**: A scheduled command runs every minute to close slots, evaluate bids, and award the highest (or earliest in case of a tie).
- **API Design**: RESTful APIs for listing slots, placing bids, viewing bids, and checking winners.
- **Docker**: Containers for Laravel app, MySQL, and Redis ensure a consistent environment.

## API Documentation
A Postman collection is included in `postman_collection.json` for testing the APIs:
- `POST /api/login`: Authenticate and get a token.
- `GET /api/slots`: List ad slots with optional status filter.
- `POST /api/slots/{slot_id}/bid`: Place a bid on an open slot.
- `GET /api/slots/{slot_id}/bids`: View all bids for a slot.
- `GET /api/slots/{slot_id}/winner`: View the winning bid (if awarded).
- `GET /api/user/bids`: View the authenticated user’s bid history.
- `POST /api/slots` (Admin): Create a new ad slot.
