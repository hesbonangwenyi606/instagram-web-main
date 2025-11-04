# Instagram Clone

A full-featured Instagram clone built with Laravel, featuring user authentication, posts, comments, likes, and follows.

## Features

- **User Authentication**
  - User registration and login
  - Profile management
  - Secure password reset
  - Email verification

- **Posts**
  - Create and share posts with images
  - View posts in a feed
  - Delete posts
  - Image upload with storage

- **Social Interactions**
  - Like and unlike posts (toggle functionality)
  - Comment on posts
  - Follow/unfollow other users
  - View followers/following counts

- **User Profiles**
  - Custom usernames and bios
  - Profile pictures with upload
  - Post count, followers, and following stats
  - Profile editing

- **UI/UX**
  - Fully responsive design (mobile-first)
  - Instagram-like interface
  - Smooth animations for comments
  - Bootstrap-based components

## Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade templates, Bootstrap 5.x, Custom CSS
- **Icons**: Bootstrap Icons
- **Database**: MySQL
- **Authentication**: Laravel's built-in authentication system
- **File Storage**: Local filesystem with public disk
- **JavaScript**: Vanilla JS with Bootstrap components

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7+
- Node.js & NPM (for frontend dependencies)

## Installation

1. Clone the repository:
   ```bash
   git clone the repostory
   cd instagram-clone

2. Install PHP dependencies:
   ```bash
   composer install

3. Install NPM dependencies:
   ```bash
   npm install
   npm run build

4. Copy the environment file:
   ```bash
   cp .env.example .env

5. Generate application key:
   ```bash
   php artisan key:generate

6. Configure your database in the `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=instagram_clone
   DB_USERNAME=your_db_username
   DB_PASSWORD=your_db_password

7. Create storage link:
   ```bash
   php artisan storage:link

8. Run migrations:
   ```bash
   php artisan migrate

9. Start the development server:
   ```bash
   php artisan serve

10. Open your browser and visit: [http://localhost:8000](http://localhost:8000)
# instagram-web-main
