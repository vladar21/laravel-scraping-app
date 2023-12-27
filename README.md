# Web Scraping API - Laravel Application

## Description

This Laravel application is designed to manage and execute web scraping tasks. It allows users to create scraping jobs by specifying URLs and HTML/CSS selectors, and then it retrieves the required data from these URLs.

## Key Features

- Create Scraping Jobs: Submit a list of URLs along with the HTML/CSS selectors.
- View Job Details: Access the detailed results and status of each scraping job.
- Delete Jobs: Remove scraping jobs from the system.
- Asynchronous Processing: Jobs are processed in the background, ensuring efficient handling of multiple tasks.

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL or SQLite database
- Optional, for containerized setup:
  * Docker Compose version v2.22.0
  * Docker version 24.0.6

### Installation

1. Clone the Repository
    ```
   git clone https://github.com/vladar21/laravel-scraping-app.git

2. Navigate to the Project Directory
    ```
   cd your-repository

3. Install Dependencies
    ```
   composer install

4. Setup Environment

- Create .env file

    Example:
    ```bash
    APP_NAME=Laravel
    APP_ENV=development
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://lsa.local
    
    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug
    
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=lsa
    DB_USERNAME=lsa_user
    DB_PASSWORD=lsa_password
    DB_ROOT_PASSWORD=root
    
    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=database
    SESSION_DRIVER=file
    SESSION_LIFETIME=120
    ```

5. Generate Application Key
    ```
   php artisan key:generate

6. Run Database Migrations
    ```
   php artisan migrate

### Running the Application

- Start the Laravel server:
    ```
  php artisan serve

- Access the application at: http://localhost:8000

### Using Docker

Build and start the containers:
```
docker-compose up --build
```

### API Usage

#### Create a Scraping Job

- Endpoint: POST /api/jobs
- Payload:
    ```json
  {
      "urls": ["https://example.com"],
      "selectors": ["div.content", ".header"]
  }

#### Retrieve a Job

- Endpoint: GET /api/jobs/{job_id}

#### Delete a Job

- Endpoint: DELETE /api/jobs/{job_id}

### Testing

- Run automated tests with PHPUnit:
    ```
  ./vendor/bin/phpunit

### License

This project is licensed under the MIT License - see the LICENSE.md file for details.
