# Web Scraping API - Laravel Application

## Description

This Laravel application is designed to manage and execute web scraping tasks. It allows users to create scraping jobs by specifying URLs and HTML/CSS selectors, and then it retrieves the required data from these URLs.

## Key Features

- Create Scraping Jobs: Submit a list of URLs along with the HTML/CSS selectors.
- View Job Details: Access the detailed results and status of each scraping job.
- Delete Jobs: Remove scraping jobs from the system.

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL or SQLite database

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

    Copy the .env.example file to .env and configure your database settings.
    ```
   cp .env.example .env

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
