# Publisher Module Documentation

## Overview
The Publisher module provides functionality for managing publishers, including retrieving publisher details, managing books, and editing publisher information. The module is designed to be used by both administrators and publishers, with role-based access control.

## Routes

[Routes File](https://github.com/HeshamAdel0007/BookStore/blob/main/Modules/Publisher/routes)

## Models

### Publisher Model
The `Publisher` model represents a publisher in the system. It includes attributes such as `name`, `email`, `phone`, `about`, and `status`. The model also supports soft deletion and email verification.

#### Relationships
- **Books**: Each publisher can have multiple books.

## Repositories

### PublisherRepository
The `PublisherRepository` handles the data access logic for publishers. It includes methods for retrieving, updating, and deleting publishers.

#### Methods
- `publisherDetails(int $id)`: Retrieves details of a specific publisher by its ID.
- `publisherBooks(int $id)`: Retrieves books associated with a publisher.
- `show(int $id)`: Retrieves publisher information including published books.
- `edit($request, int $id)`: Updates an existing publisher.
- `softDeleted(int $id)`: Soft deletes a publisher and associated tokens.

## Requests

### EditPublisherRequest
The `EditPublisherRequest` class handles the validation rules for editing an existing publisher.

#### Validation Rules
- `name`: Required, string, minimum 3 characters, maximum 255 characters.
- `email`: Required, string, lowercase, valid email format, maximum 255 characters.
- `phone`: Required, minimum 7 characters, maximum 16 characters.
- `about`: Required, string.

## Service Providers

### PublisherServiceProvider
The `PublisherServiceProvider` registers the necessary bindings and configurations for the Publisher module.

#### Key Features
- Registers the `PublisherRepositoryInterface` binding to `PublisherRepository`.
- Loads migrations, translations, and views for the module.
- Registers command schedules and routes.

## Database Migrations

### CreatePublishersTable
The `CreatePublishersTable` migration creates the `publishers` table in the database.

#### Columns
- `id`: Primary key.
- `name`: The name of the publisher.
- `email`: The email of the publisher (unique).
- `about`: Description of the publisher (nullable).
- `phone`: The phone number of the publisher (unique, nullable).
- `status`: Boolean indicating the publisher's status.
- `email_verified_at`: Timestamp for email verification.
- `password`: Hashed password.
- `remember_token`: Token for "remember me" functionality.
- `softDeletes`: For soft deletion.
- `timestamps`: Automatically managed timestamps.

## Seeders

### PublisherDatabaseSeeder
The `PublisherDatabaseSeeder` class is used to seed the `publishers` table with initial data.

#### Example Data
- **Name**: Publisher
- **Email**: publisher@publisher.com
- **About**: about publisher
- **Status**: 1 (active)
- **Password**: password (hashed)
- **Email Verified At**: Current timestamp

This concludes the documentation for the Publisher module.
