
# Welcome to Newsy Application
## Overview
This application fetches news articles from various sources and displays them in a user-friendly interface.
## Main Pages
- **Login/Signup**: This page allows users to login or signup to the system.
- **News Feed**: This page shows the top headlines of news from different categories and publishers.
- **Articles**: This page shows all the articles available in the system, and allows users to search and filter them by keyword, date, category, and source.
- **User Profile**: This page allows users to customize the type of news shown in their News Feed by selecting their preferred sources, categories, and authors.
## User Roles
- **Guest**: A guest user can access the News Feed page (without any customization) and the Articles page, and view the news articles from various sources.
- **User**: A registered user can access the News Feed page (with customization) and the Articles page, and view, save, and share the news articles from their preferred sources, categories, and authors.
## Frontend React Project Features
- **Mobile-responsive design**: The website is optimized for viewing on mobile devices of different sizes and orientations.
- **Pagination and filters**: The website allows users to navigate through multiple pages of news articles, and filter them by various criteria.
- **Search functionality**: The website allows users to search for articles by their titles, and see the matching results.
- **Optimized code**: The website uses best practices and standards to ensure high performance and readability of the code.
## Backend Laravel Framework Features
- **Login log**: The system records all the login operations to the system, and stores them in a log file.
- **Error log**: The system records all the failed actions on the system, and stores them in a log file.
## How to Run the Projects
- **Frontend**:
    - Build the Docker image by running the following command in the terminal: `docker build -t news-app-react-js`.
    - Start the Docker containers by running the following command: `docker-compose up`
    - The React JS application will be available at http://localhost:3000
- **Backend**:
    - Build the Docker image by running the following command in the terminal: `docker build -t news-app-laravel`.
    - Start the Docker containers by running the following command: `docker-compose up`
    - The Laravel application will be available at http://localhost:8000
- **Database**:
    - Create a new database in MySQL and put the name of the database in the `.env` file in the Laravel application.
    - Execute the following commands in the same order in the terminal of the Laravel project:
        - To create the tables: `php artisan migrate`
        - To integrate with NewsAPI and NewsAPI.org: `php artisan db:seed --class="SyncNewsAPI"`
        - To integrate with GuardianNewsAPI: `php artisan db:seed --class="SyncGuardianNewsAPI"`
        - To implement user authentication and generate the APP key: `php artisan passport:install` and `php artisan key:generate`
    - Go to the following URL: http://localhost:8000 and start exploring.
## Additional Info
- You can customize your authentication keys for the integration news websites by adding the key in the .env file in the Laravel application as follows:
    - `NEWS_API_TOKEN=YOUR_TOKEN_HERE`
    - `GUARDIAN_NEWS_TOKEN=YOUR_TOKEN_HERE`
- **Note**: There are available tokens already existing in the project you can use them without inserting any authentication keys for the integration news websites, but it could happen to see this error about too many requests (the integration news websites allow a limited number of requests per day).
