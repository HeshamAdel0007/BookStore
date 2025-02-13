# API Routes Explanation

This document explains the API routes defined in the provided PHP code. The routes are organized into two main groups: **Publisher Routes** and **Guest Routes**. The routes are prefixed with `api/v1` and are protected by middleware to ensure only authenticated, verified users with the appropriate roles and abilities can access them.

---

## Middleware

### Publisher Routes
These routes are wrapped in the following middleware:

- **`auth:sanctum`**: Ensures that the user is authenticated using Sanctum.
- **`verified`**: Ensures that the user's email has been verified.
- **`role:super-admin|publisher`**: Ensures that the user has either the `super-admin` or `publisher` role.
- **`ability:publisher`**: Ensures that the user has the `publisher` ability.

### Guest Routes
These routes are accessible to unauthenticated users (guests).

---

## Publisher Routes

These routes handle operations related to publishers and are accessible only to users with the `super-admin` or `publisher` role.

| **Method** | **Route**                     | **Function**            | **Description**                                                                 |
|------------|-------------------------------|-------------------------|---------------------------------------------------------------------------------|
| `GET`      | `/publisher/publisher`        | `getPublisher`          | Retrieves information about the authenticated publisher.                        |
| `GET`      | `/publisher/publisher/books`  | `getPublisherBooks`     | Retrieves a list of books associated with the authenticated publisher.          |
| `GET`      | `/publisher/publisher/orders` | `getPublisherOrders`    | Retrieves a list of orders associated with the authenticated publisher.         |
| `GET`      | `/publisher/publisher/order/info/{orderID}` | `getOrdersInfo` | Retrieves detailed information about a specific order.                          |
| `POST`     | `/publisher/edit/{id}`        | `editPublisher`         | Updates the details of a specific publisher.                                    |
| `DELETE`   | `/publisher/delete/{id}`      | `delete`                | Deletes a specific publisher.                                                   |

---

## Guest Routes

These routes are accessible to unauthenticated users (guests).

| **Method** | **Route**                     | **Function**            | **Description**                                                                 |
|------------|-------------------------------|-------------------------|---------------------------------------------------------------------------------|
| `GET`      | `/user/show/publisher/{id}`   | `showPublisher`         | Displays details of a specific publisher.                                       |

---

## Summary

The routes are organized into two groups:

- **Publisher Routes**: Handles operations related to publishers, including retrieving publisher information, books, orders, and updating or deleting publisher details. These routes are accessible only to users with the `super-admin` or `publisher` role.
- **Guest Routes**: Displays details of a specific publisher and is accessible to unauthenticated users.

All routes are prefixed with `api/v1` for proper organization and clarity. The Publisher Routes are secured with middleware to ensure only authenticated, verified users with the appropriate roles and abilities can access them.
