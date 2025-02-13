# API Routes Explanation

This document explains the API routes defined in the provided PHP code. The routes are organized into two main groups: **Publisher Book Routes** and **Public Book Routes**. The routes are prefixed with `api/v1` and are protected by middleware to ensure only authenticated, verified users with the appropriate roles and abilities can access them.

---

## Middleware

### Publisher Book Routes
These routes are wrapped in the following middleware:

- **`auth:sanctum`**: Ensures that the user is authenticated using Sanctum.
- **`verified`**: Ensures that the user's email has been verified.
- **`role:super-admin|publisher`**: Ensures that the user has either the `super-admin` or `publisher` role.
- **`ability:publisher`**: Ensures that the user has the `publisher` ability.

/*
 *--------------------------------------------------------------------------
 * API Routes
 * Routes Prefix('api/v1/etc...')
 *--------------------------------------------------------------------------
*/

---

## Publisher Book Routes

These routes handle operations related to books and are accessible only to users with the `super-admin` or `publisher` role.

| **Method** | **Route**                     | **Function**       | **Description**                                                                 |
|------------|-------------------------------|--------------------|---------------------------------------------------------------------------------|
| `POST`     | `/publisher/book/create`      | `store`            | Creates a new book.                                                             |
| `GET`      | `/publisher/book/show/{id}`   | `show`             | Displays details of a specific book.                                            |
| `POST`     | `/publisher/book/edit/{id}`   | `edit`             | Updates the details of a specific book.                                         |
| `DELETE`   | `/publisher/book/delete/{id}` | `softDelete`       | Soft deletes a book (marks it as trashed).                                      |
| `GET`      | `/publisher/book/trash`       | `trash`            | Retrieves a list of soft-deleted books.                                         |
| `GET`      | `/publisher/book/restore/{id}`| `restore`          | Restores a soft-deleted book.                                                   |
| `DELETE`   | `/publisher/book/destroy/{id}`| `destroy`          | Permanently deletes a book.                                                     |

---

## Public Book Routes

These routes are accessible to all users, including unauthenticated users.

| **Method** | **Route**                     | **Function**       | **Description**                                                                 |
|------------|-------------------------------|--------------------|---------------------------------------------------------------------------------|
| `GET`      | `/books`                      | `books`            | Retrieves a list of all books.                                                  |

---

## Summary

The routes are organized into two groups:

- **Publisher Book Routes**: Handles CRUD operations for books, including soft delete, restore, and permanent delete. These routes are accessible only to users with the `super-admin` or `publisher` role.
- **Public Book Routes**: Retrieves a list of all books and is accessible to all users.

All routes are prefixed with `api/v1` for proper organization and clarity. The Publisher Book Routes are secured with middleware to ensure only authenticated, verified users with the appropriate roles and abilities can access them.
