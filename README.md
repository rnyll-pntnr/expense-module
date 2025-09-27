# Expense Module
## Setup Instructions

1.  **Environment Configuration**:
    *   Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    *   Generate an application key:
        ```bash
        php artisan key:generate
        ```
    *   Configure your database connection in the `.env` file. Ensure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` are correctly set. Otherwise don't change the configuration as it will use **`SQLite`** as default database.

2.  **Database Migrations**:
    *   Run the database migrations to create the necessary tables, including the `expenses` table:
        ```bash
        php artisan migrate
        ```

3.  **Module Discovery**:
    *   Ensure the `ExpenseServiceProvider` is registered. If you are using a module management system, it should handle this automatically. Otherwise, you might need to add `Modules\Expenses\Providers\ExpenseServiceProvider::class,` to the `providers` array in `config/app.php`.


## Module Structure Overview

The Expense Module is organized within the `Modules/Expenses` directory, following a modular approach. Below is an overview of its key components:

*   **`Modules/Expenses/Controllers/ExpenseController.php`**: Handles incoming HTTP requests and returns responses. It orchestrates the interaction between the service layer and the client.
*   **`Modules/Expenses/Models/Expense.php`**: The Eloquent model representing an expense in the database. It defines the table, relationships, and fillable attributes.
*   **`Modules/Expenses/Services/ExpenseService.php`**: Contains the business logic for expense-related operations. It acts as an intermediary between the controller and the repository.
*   **`Modules/Expenses/Repositories/ExpenseRepository.php`**: Abstracts the data storage layer. It handles database interactions for the `Expense` model, providing methods for CRUD operations.
*   **`Modules/Expenses/Requests/`**:
    *   **`StoreExpenseRequest.php`**: Handles validation rules for creating a new expense.
    *   **`UpdateExpenseRequest.php`**: Handles validation rules for updating an existing expense.
*   **`Modules/Expenses/routes/api.php`**: Defines the API routes for the Expense module, mapping URLs to controller actions.
*   **`Modules/Expenses/Enums/ExpenseCategory.php`**: Defines an enumeration for different expense categories, ensuring consistency and type safety.
*   **`Modules/Expenses/Providers/ExpenseServiceProvider.php`**: Registers the module's services, repositories, and other components with the Laravel application container.
*   **`Modules/Expenses/swagger.json`**: OpenAPI/Swagger definition for the Expense module's API endpoints.

