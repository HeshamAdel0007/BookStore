# Auth Module Documentation

## Overview
The Auth module is responsible for handling authentication, user registration, password reset, and email verification for admins, publishers, and customers. It supports role-based access control and provides secure email notifications for password reset and email verification.

## Routes

All routes are prefixed with `/auth`.

### Guest Routes

| Method     | Route                     | Controller           | Function         | Description                     |
|------------|---------------------------|----------------------|------------------|---------------------------------|
| `POST`     | `/auth/login/{type}`      | `AuthenticatedSessionController` | `login` | Authenticate users and generate a token. |
| `POST`     | `/auth/register/publisher`| `RegisteredUserController` | `storePublisher` | Register a new publisher.       |
| `POST`     | `/auth/register/customer` | `RegisteredUserController` | `storeCustomer`  | Register a new customer.        |
| `POST`     | `/auth/forgot-password/{type}` | `ResetCodePasswordController` | `forgotPassword` | Send a password reset code to the user's email. |
| `POST`     | `/auth/reset-password/{type}` | `ResetCodePasswordController` | `resetPassword`  | Reset the user's password using the provided code. |

### Authenticated Routes

| Method     | Route                     | Controller           | Function         | Description                     |
|------------|---------------------------|----------------------|------------------|---------------------------------|
| `GET`      | `/auth/verify-email/{id}/{hash}` | `VerifyEmailController` | `__invoke`     | Mark the user's email as verified. |
| `GET`      | `/auth/email/verification`| `EmailVerificationNotificationController` | `store` | Resend the email verification link. |
| `POST`     | `/auth/logout`            | `AuthenticatedSessionController` | `userLogout` | Log out the user by deleting their tokens. |

### Info Routes

| Method     | Route                     | Controller           | Function         | Description                     |
|------------|---------------------------|----------------------|------------------|---------------------------------|
| `GET`      | `/auth/info/admin`        | `AuthController`     | `admin`          | Retrieve admin information (requires `admin` role). |
| `GET`      | `/auth/info/publisher`    | `AuthController`     | `publisher`      | Retrieve publisher information (requires `publisher` role). |
| `GET`      | `/auth/info/customer`     | `AuthController`     | `customer`       | Retrieve customer information (requires `customer` role). |

## Database

### Migrations
The module includes the following migrations:
- **`create_personal_access_tokens_table`**: Creates the table for storing personal access tokens.
- **`create_sessions_table`**: Creates the table for storing user sessions.
- **`create_reset_code_passwords_table`**: Creates the table for storing password reset codes.

## Emails

### SendCodeResetPassword
This email class sends a password reset code to the user.

#### Key Features
- **`$code`**: The reset code to be sent.

### SendLinkEmailVerification
This email class sends an email verification link to the user.

