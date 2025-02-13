# Category Routes

## Admin Category Routes

| Method     | Route                     | Controller           | Function   | Description                     |
|------------|---------------------------|----------------------|------------|---------------------------------|
| `POST`     | `/category/create`        | `CategoryController` | `store`    | Create a new category.          |
| `GET`      | `/show/category/{id}`     | `CategoryController` | `show`     | Show category details.          |
| `POST`     | `/category/edit/{id}`     | `CategoryController` | `update`   | Edit a category.                |
| `DELETE`   | `/category/delete/{id}`   | `CategoryController` | `destroy`  | Delete a category.              |

## Public Category Routes

| Method     | Route                     | Controller           | Function   | Description                     |
|------------|---------------------------|----------------------|------------|---------------------------------|
| `GET`      | `/categories`             | `CategoryController` | `index`    | Retrieve all categories.        |
