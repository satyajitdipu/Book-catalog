"# Book Catalog API

A comprehensive Laravel-based API for managing a book catalog system with user authentication, reviews, ratings, wishlists, comments, and admin moderation features.

## Features

- **User Management**: Registration, login, profile management
- **Book Management**: CRUD operations for books and authors
- **Reviews & Ratings**: Users can review and rate books
- **Wishlist**: Users can add books to their wishlist
- **Comments**: Users can comment on books
- **Admin Panel**: Moderation tools for managing content
- **API Authentication**: Sanctum-based authentication

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL database
- Node.js & npm (for frontend)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/satyajitdipu/Book-catalog.git
cd Book-catalog
```

2. Install PHP dependencies:
```bash
cd books
composer install
```

3. Install Node.js dependencies:
```bash
cd ../frontend
npm install
```

4. Environment setup:
```bash
cd ../books
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookcatalog
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

7. Seed the database (optional):
```bash
php artisan db:seed
```

## Running the Application

### Backend (API)
```bash
cd books
php artisan serve
```

### Frontend
```bash
cd frontend
npm start
```

### Running Tests
```bash
cd books
php artisan test
```

## API Endpoints

### Authentication
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `GET /api/user` - Get authenticated user

### Books
- `GET /api/books` - List all books
- `GET /api/book/{id}` - Get book details
- `POST /api/book` - Create book (authenticated)
- `PUT /api/book/{id}` - Update book (authenticated)
- `DELETE /api/book/{id}` - Delete book (authenticated)

### Authors
- `GET /api/allauthor` - List all authors
- `GET /api/author/{id}` - Get author details
- `POST /api/author` - Create author (authenticated)
- `PUT /api/author/{id}` - Update author (authenticated)
- `DELETE /api/author/{id}` - Delete author (authenticated)

### Reviews
- `GET /api/books/{bookId}/reviews` - Get reviews for a book
- `POST /api/reviews` - Create review (authenticated)
- `PUT /api/reviews/{id}` - Update review (authenticated)
- `DELETE /api/reviews/{id}` - Delete review (authenticated)

### Ratings
- `GET /api/books/{bookId}/ratings` - Get ratings for a book
- `POST /api/ratings` - Create rating (authenticated)
- `PUT /api/ratings/{id}` - Update rating (authenticated)
- `DELETE /api/ratings/{id}` - Delete rating (authenticated)

### Wishlists
- `GET /api/wishlists` - Get user wishlist (authenticated)
- `POST /api/wishlists` - Add to wishlist (authenticated)
- `DELETE /api/wishlists/{id}` - Remove from wishlist (authenticated)

### Comments
- `GET /api/books/{bookId}/comments` - Get comments for a book
- `POST /api/comments` - Create comment (authenticated)
- `PUT /api/comments/{id}` - Update comment (authenticated)
- `DELETE /api/comments/{id}` - Delete comment (authenticated)

### Admin (Admin role required)
- `GET /api/admin/dashboard` - Admin dashboard stats
- `GET /api/admin/users` - List users
- `GET /api/admin/books` - List books
- `GET /api/admin/authors` - List authors
- `DELETE /api/admin/users/{id}` - Delete user
- `DELETE /api/admin/books/{id}` - Delete book
- `DELETE /api/admin/authors/{id}` - Delete author
- `POST /api/admin/users/{id}/promote` - Promote user to admin
- `POST /api/admin/books/{id}/approve` - Approve book
- `POST /api/admin/authors/{id}/approve` - Approve author

## Testing

Run the test suite:
```bash
php artisan test
```

Run with coverage:
```bash
php artisan test --coverage
```

## Deployment

### Railway

1. Connect your GitHub repository to Railway
2. Set environment variables in Railway dashboard:
   - `APP_ENV=production`
   - `APP_KEY` (generate with `php artisan key:generate --show`)
   - Database credentials (Railway provides these automatically)
   - `DB_CONNECTION=mysql` (or postgres depending on Railway's database)
3. Railway will auto-detect Laravel and deploy
4. Run migrations in Railway's shell:
   ```bash
   php artisan migrate
   ```

### Other Platforms

Ensure:
- PHP 8.2+
- Database configured
- Environment variables set
- `composer install --no-dev --optimize-autoloader` in production

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This project is licensed under the MIT License.

```bash
npm test
```

## CI/CD

This project uses GitHub Actions for continuous integration.

## Contributing

Please ensure all tests pass before submitting a PR.
composr i
```

## env

```
cp .env.example .env 
```
## Migration

```
php artisan migrate
```

## Run server

```
php artisan serve
```

## redirected frontend
```
cd frontend
```
## Installation Npm Package

```
npm i
```