# API Routes Explanation

This document explains the API routes defined in the provided PHP code. The routes are organized into two main controllers: **OrderController** and **CouponController**. All routes are prefixed with `v1` and are protected by middleware to ensure only authenticated users can access them.

---

## Middleware

All routes are wrapped in the following middleware:

- **`auth:sanctum`**: Ensures that the user is authenticated using Sanctum.

---

## OrderController Routes

These routes handle operations related to orders, payments, and discounts.

| **Method** | **Route**                     | **Function**            | **Description**                                                                 |
|------------|-------------------------------|-------------------------|---------------------------------------------------------------------------------|
| `GET`      | `/v1/customer/order/{id}`     | `order`                 | Retrieves details of a specific order for the authenticated customer.           |
| `POST`     | `/v1/order`                   | `createOrder`           | Creates a new order.                                                            |
| `GET`      | `/v1/payment/info/{id}`       | `paymentInfo`           | Retrieves payment information for a specific order.                             |
| `POST`     | `/v1/payment/{orderID}`       | `payment`               | Processes payment for a specific order.                                         |
| `POST`     | `/v1/discount/{bookID}`       | `create`                | Applies a discount to a specific book.                                          |

---

## CouponController Routes

These routes handle operations related to coupons.

| **Method** | **Route**                     | **Function**            | **Description**                                                                 |
|------------|-------------------------------|-------------------------|---------------------------------------------------------------------------------|
| `GET`      | `/v1/coupon/{code}`           | `check`                 | Checks the validity of a coupon code.                                           |
| `POST`     | `/v1/coupon/create`           | `create`                | Creates a new coupon.                                                           |

---

## Summary

The routes are organized into two controllers:

- **OrderController**: Handles operations related to orders, payments, and discounts. These routes allow customers to create orders, retrieve payment information, process payments, and apply discounts.
- **CouponController**: Handles operations related to coupons, including checking the validity of a coupon and creating new coupons.

All routes are prefixed with `v1` for proper organization and clarity. The routes are secured with the `auth:sanctum` middleware to ensure only authenticated users can access them.
