# Category 
The Category module provides functionality for managing categories, including creating, updating, deleting, and retrieving category details. The module is designed to be used by both administrators and publishers.

## Routes

[Routes File](https://github.com/HeshamAdel0007/BookStore/blob/main/Modules/Category/routes)

| Method     | Route                     | Controller           | Function   | Description                     |
|------------|---------------------------|----------------------|------------|---------------------------------|
| `GET`      | `/categories`             | `CategoryController` | `index`    | Retrieve all categories.        |

## Models

### Category Model
The `Category` model represents a category in the system. It includes attributes such as `name` and `slug`. The model also supports automatic slug generation based on the category name.

#### Relationships
- **Books**: Each category can have multiple books.

## Repositories

### CategoryRepository
The `CategoryRepository` handles the data access logic for categories. It includes methods for creating, updating, deleting, and retrieving categories.

#### Methods
- `getAllCategories()`: Retrieves a list of all categories.
- `getCategoryById(int $id)`: Retrieves details of a specific category by its ID.
- `createCategory($request)`: Creates a new category.
- `updateCategory(int $id, $request)`: Updates an existing category.
- `deleteCategory(int $id)`: Deletes a category.

## Requests

### CreateCategoryRequest
The `CreateCategoryRequest` class handles the validation rules for creating a new category.

#### Validation Rules
- `name`: Required, string, minimum 3 characters, maximum 255 characters, unique.

### EditCategoryRequest
The `EditCategoryRequest` class handles the validation rules for editing an existing category.

#### Validation Rules
- `name`: Required, string, minimum 3 characters, maximum 255 characters.

## Service Providers

### CategoryServiceProvider
The `CategoryServiceProvider` registers the necessary bindings and configurations for the Category module.

#### Key Features
- Registers the `CategoryRepositoryInterface` binding to `CategoryRepository`.
- Loads migrations, translations, and views for the module.
- Registers command schedules and routes.

## Database Migrations

### CreateCategoriesTable
The `CreateCategoriesTable` migration creates the `categories` table in the database.

#### Columns
- `id`: Primary key.
- `name`: The name of the category.
- `slug`: The slug of the category.
- `timestamps`: Automatically managed timestamps.

## Seeders

### CategoryDatabaseSeeder
The `CategoryDatabaseSeeder` class is used to seed the `categories` table with initial data.
