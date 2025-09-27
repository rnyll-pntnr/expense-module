<?php

namespace Modules\Expenses\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Expenses\Models\Expense;

class ExpenseRepository
{
    public function getAll(array $filters = []): Collection
    {
        $query = Expense::query();

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['start_date'])) {
            $query->whereDate('expense_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->whereDate('expense_date', '<=', $filters['end_date']);
        }

        return $query->get();
    }

    public function findById(string $id): ?Expense
    {
        return Expense::find($id);
    }

    public function create(array $data): Expense
    {
        return Expense::create($data);
    }

    public function update(string $id, array $data): bool
    {
        return Expense::find($id)->update($data);
    }

    public function delete(string $id): bool
    {
        return Expense::find($id)->delete();
    }
}
