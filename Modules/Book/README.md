# Book 
The Book module provides functionality for managing books, including creating, updating, deleting, and retrieving book details. It also supports soft deletion and restoration of books. The module is designed to be used by both publishers and administrators.

## Routes

[Routes File](https://github.com/HeshamAdel0007/BookStore/blob/main/Modules/Book/routes)

## Models

### Book Model
The `Book` model represents a book in the system. It includes attributes such as `name`, `price`, `stock_quantity`, `isbn`, `published_date`, and more. The model also supports soft deletion and media handling for book covers.

#### Relationships
- **Category**: Each book belongs to a category.
- **Publisher**: Each book belongs to a publisher.
- **OrderItems**: Each book can have multiple order items.
- **Discount**: Each book can have one discount.

## Repositories

### BookRepository
The `BookRepository` handles the data access logic for books. It includes methods for creating, updating, deleting, and retrieving books. The repository also supports soft deletion and restoration of books.

#### Methods
- `allBooks()`: Retrieves a list of all books.
- `create($request)`: Creates a new book.
- `show(int $id)`: Retrieves details of a specific book by its ID.
- `edit($request, int $id)`: Updates an existing book.
- `softdelete(int $id)`: Soft deletes a book.
- `bookTrash()`: Retrieves a list of soft-deleted books.
- `restoredBook(int $id)`: Restores a soft-deleted book.
- `forceDeleteBook(int $id)`: Permanently deletes a book.

## Requests

### CreateBookRequest
The `CreateBookRequest` class handles the validation rules for creating a new book.

#### Validation Rules
- `name`: Required, string, max 255 characters, unique.
- `price`: Required, numeric, minimum value of 1.
- `stock_quantity`: Required, numeric, minimum value of 1.
- `isbn`: Required, string, unique.
- `published_date`: Required, date.
- `category_id`: Required, integer, exists in categories table.
- `description`: Optional, string.
- `book_cover`: Optional, image, mimes: jpg, jpeg, png, max size 5120 KB.

### EditBookRequest
The `EditBookRequest` class handles the validation rules for editing an existing book.

#### Validation Rules
- `name`: Required, string, max 255 characters.
- `price`: Required, numeric, minimum value of 1.
- `stock_quantity`: Required, numeric, minimum value of 1.
- `isbn`: Required, string, max 18 characters.
- `published_date`: Required, date.
- `category_id`: Required, integer, exists in categories table.
- `description`: Optional, string.

## Resources

### BookResource
The `BookResource` class transforms the `Book` model into an array for API responses.

#### Fields
- `id`: The ID of the book.
- `name`: The name of the book.
- `slug`: The slug of the book.
- `published_date`: The published date of the book.
- `price`: The price of the book.
- `average_rating`: The average rating of the book.
- `review_count`: The number of reviews for the book.
- `book_cover`: The URL of the book cover image.
- `description`: The description of the book.

### ShowPublisherBooksResource
The `ShowPublisherBooksResource` class transforms the `Book` model into an array for API responses, including publisher and category details.

#### Fields
- `id`: The ID of the book.
- `name`: The name of the book.
- `slug`: The slug of the book.
- `publisher`: The name of the publisher.
- `category`: The name of the category.
- `published_date`: The published date of the book.
- `isbn`: The ISBN of the book.
- `price`: The price of the book.
- `sku`: The SKU of the book.
- `stock_quantity`: The stock quantity of the book.
- `book_cover`: The URL of the book cover image.
- `description`: The description of the book.

## Service Providers

### BookServiceProvider
The `BookServiceProvider` registers the necessary bindings and configurations for the Book module.

#### Key Features
- Registers the `BookRepositoryInterface` binding to `BookRepository`.
- Loads migrations, translations, and views for the module.
- Registers command schedules and routes.

## Database Migrations

### CreateBooksTable
The `CreateBooksTable` migration creates the `books` table in the database.

#### Columns
- `id`: Primary key.
- `category_id`: Foreign key referencing the `categories` table.
- `publisher_id`: Foreign key referencing the `publishers` table.
- `name`: The name of the book.
- `slug`: The slug of the book.
- `price`: The price of the book.
- `stock_quantity`: The stock quantity of the book.
- `isbn`: The ISBN of the book.
- `published_date`: The published date of the book.
- `sku`: The SKU of the book.
- `average_rating`: The average rating of the book.
- `review_count`: The number of reviews for the book.
- `description`: The description of the book.
- `softDeletes`: Supports soft deletion.
- `timestamps`: Automatically managed timestamps.
