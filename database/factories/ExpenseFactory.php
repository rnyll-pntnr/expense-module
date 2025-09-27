<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Expenses\Models\Expense;
use Modules\Expenses\Enums\ExpenseCategory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(1000, 10000),
            'category' => $this->faker->randomElement(array_column(ExpenseCategory::cases(), 'value')),
            'expense_date' => $this->faker->date(),
        ];
    }
}
