# Instagram Clone - Laravel Full-Stack Project
A fully functional Instagram-inspired web application built with Laravel. This project allows users to register, log in, create posts with images, follow other users, like and comment on posts, and manage their profiles — all within a responsive and user-friendly interface. It is designed as a learning project to demonstrate full-stack web development using Laravel, Blade templates, Bootstrap, and Docker.
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

- **Backend**: Laravel 10.x, PHP 8.2
- **Frontend**: Blade templates, Bootstrap 5.x, Custom CSS
- **Icons**: Bootstrap Icons
- **Database**: SQLite (for local development)
- **Authentication**: Laravel's built-in authentication system
- **File Storage**: Local filesystem with public disk
- **JavaScript**: Vanilla JS with Bootstrap components
- **Containerization**: Docker & Docker Compose

## Prerequisites

- Docker & Docker Compose
- PHP 8.2
- Composer
- Node.js & NPM

## Installation (Docker)

1. Clone the repository:
git clone <https://github.com/hesbonangwenyi606/instagram-web-main.git>

**cd instagram-web-main**


**Copy the environment example:**
cp .env.example .env
Create the SQLite database file:


# touch database/database.sqlite
Build and start Docker containers:


# docker compose up --build -d
Set proper permissions for Laravel:


# docker compose exec app chown -R www-data:www-data database
Run migrations to create database tables:

**docker compose exec app php artisan migrate**
(Optional) Install Node.js dependencies and build frontend assets:
**docker compose exec app npm install**
**docker compose exec app npm run build**

Open your browser:
## arduino
http://localhost:8000

## Author
**Hesbon Angwenyi**  
- Email: hesbonangwenyi@example.com  
- Phone: +254 (0)743 573 380


## License
MIT License
Copyright (c) 2025 Hesbon Angwenyi

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
