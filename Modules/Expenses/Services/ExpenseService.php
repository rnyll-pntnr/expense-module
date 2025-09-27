<?php

namespace Modules\Expenses\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Expenses\Models\Expense;
use Modules\Expenses\Repositories\ExpenseRepository;

class ExpenseService
{
    public function __construct(private readonly ExpenseRepository $expenseRepository)
    {
    }

    public function getAllExpenses(array $filters = []): Collection
    {
        return $this->expenseRepository->getAll($filters);
    }

    public function getExpenseById(string $id): ?Expense
    {
        return $this->expenseRepository->findById($id);
    }

    public function createExpense(array $data): Expense
    {
        return $this->expenseRepository->create($data);
    }

    public function updateExpense(string $id, array $data): bool
    {
        return $this->expenseRepository->update($id, $data);
    }

    public function deleteExpense(string $id): bool
    {
        return $this->expenseRepository->delete($id);
    }
}
