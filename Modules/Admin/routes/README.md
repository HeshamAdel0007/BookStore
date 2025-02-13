### **Route Details Table**
This document explains the API routes defined in the `Route-Api.md` file. The routes are organized into two main controllers: **AdminController** and **AdminSoftDeleteController**. All routes are prefixed with `api/v1/admin` and are protected by middleware to ensure only authenticated, verified users with the appropriate roles and abilities can access them.

---

## Middleware

All routes are wrapped in the following middleware:

- **`auth:sanctum`**: Ensures that the user is authenticated using Sanctum.
- **`verified`**: Ensures that the user's email has been verified.
- **`role:admin|super-admin`**: Ensures that the user has either the `admin` or `super-admin` role.
- **`ability:admin`**: Ensures that the user has the `admin` ability.

/*
 *--------------------------------------------------------------------------
 * API Routes
 *  Routes Prefix('api/v1/admin/etc...')
 *--------------------------------------------------------------------------
*/

#### **AdminController Routes**

| **Method** | **Route**                     | **Function**       | **Description**                                                                 |
|------------|-------------------------------|--------------------|---------------------------------------------------------------------------------|
| `GET`      | `/profile`                    | `adminProfile`     | Displays the authenticated user's profile.                                      |
| `GET`      | `/all-admins`                 | `getAdmins`        | Retrieves a list of all admins.                                                 |
| `GET`      | `/all-publishers`             | `getPublishers`    | Retrieves a list of all publishers.                                             |
| `GET`      | `/all-customers`              | `getCustomers`     | Retrieves a list of all customers.                                              |
| `GET`      | `/show/{type}/{id}`           | `showUser`         | Displays details of a specific user (admin, publisher, or customer).            |
| `POST`     | `/create`                     | `createAdmin`      | Creates a new admin.                                                            |
| `POST`     | `/edit/{id}`                  | `editAdmins`       | Updates the details of a specific admin.                                        |
| `POST`     | `/edit/publisher/{id}`        | `editPublishers`   | Updates the details of a specific publisher.                                    |
| `POST`     | `/edit/customer/{id}`         | `editCustomers`    | Updates the details of a specific customer.                                     |
| `DELETE`   | `/delete/{id}`                | `deleteAdmin`      | Deletes a specific admin.                                                       |

#### **AdminSoftDeleteController Routes**

| **Method** | **Route**                     | **Function**            | **Description**                                                                 |
|------------|-------------------------------|-------------------------|---------------------------------------------------------------------------------|
| `DELETE`   | `/publisher/delete/{id}`      | `softDeletePublisher`   | Soft deletes a publisher.                                                       |
| `DELETE`   | `/customer/delete/{id}`       | `softDeleteCustomer`    | Soft deletes a customer.                                                        |
| `GET`      | `/publishers/trash`           | `publisherTrashed`      | Retrieves a list of soft-deleted publishers.                                    |
| `GET`      | `/customers/trash`            | `customerTrashed`       | Retrieves a list of soft-deleted customers.                                     |
| `GET`      | `/publisher/restore/{id}`     | `restorePublisher`      | Restores a soft-deleted publisher.                                              |
| `GET`      | `/customer/restore/{id}`      | `restoreCustomer`       | Restores a soft-deleted customer.                                               |
| `DELETE`   | `/publisher/destroy/{id}`     | `destroyPublisher`      | Permanently deletes a publisher.                                                |
| `DELETE`   | `/customer/destroy/{id}`      | `destroyCustomer`       | Permanently deletes a customer.                                                 |

## Summary

The routes are organized into two controllers:

- **AdminController**: Handles CRUD operations for admins, publishers, and customers.
- **AdminSoftDeleteController**: Handles soft delete, restore, and permanent delete operations for publishers and customers.

All routes are secured with middleware to ensure only authenticated, verified users with the appropriate roles and abilities can access them. The routes are named for easy reference and follow RESTful conventions. The prefix `admin` has been added to all routes to ensure proper organization and clarity.
