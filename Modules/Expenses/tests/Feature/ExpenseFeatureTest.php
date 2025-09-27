<?php

namespace Modules\Expenses\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Expenses\Models\Expense;
use Modules\Expenses\Enums\ExpenseCategory;
use Carbon\Carbon;

class ExpenseFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the database with necessary data if any
        // Example: $this->artisan('db:seed', ['--class' => 'UserSeeder']);
    }

    /**
     * Test that a user can create an expense.
     */
    public function test_user_can_create_expense(): void
    {
        $this->withoutExceptionHandling();

        $expenseData = [
            'title' => 'Lunch with client',
            'amount' => 50.00,
            'category' => ExpenseCategory::FOOD->value,
            'expense_date' => '2025-09-27',
        ];

        $response = $this->postJson('/v1/api/expenses', $expenseData);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'title' => 'Lunch with client',
                         'amount' => '50.00',
                         'category' => ExpenseCategory::FOOD->value,
                         'expense_date' => Carbon::parse('2025-09-27')->toISOString(),
                     ],
                 ]);

        $this->assertDatabaseHas('expenses', [
            'title' => 'Lunch with client',
            'amount' => 50.00,
            'category' => ExpenseCategory::FOOD->value,
            'expense_date' => '2025-09-27 00:00:00',
        ]);
    }

    /**
     * Test that a user can retrieve a list of expenses.
     */
    public function test_user_can_retrieve_expenses(): void
    {
        Expense::factory()->count(3)->create();

        $response = $this->getJson('/v1/api/expenses');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data')
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'amount', 'category', 'expense_date', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    /**
     * Test that a user can retrieve a single expense.
     */
    public function test_user_can_retrieve_single_expense(): void
    {
        $expense = Expense::factory()->create();

        $response = $this->getJson('/v1/api/expenses/' . $expense->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $expense->id,
                         'title' => $expense->title,
                         'amount' => number_format($expense->amount, 2, '.', ''),
                         'category' => $expense->category->value,
                         'expense_date' => $expense->expense_date->toISOString(),
                     ],
                 ]);
    }

    /**
     * Test that a user can update an expense.
     */
    public function test_user_can_update_expense(): void
    {
        $expense = Expense::factory()->create();

        $updatedData = [
            'title' => 'Updated lunch description',
            'amount' => 75.50,
            'category' => ExpenseCategory::TRAVEL->value,
            'expense_date' => '2025-09-28',
        ];

        $response = $this->putJson('/v1/api/expenses/' . $expense->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $expense->id,
                         'title' => 'Updated lunch description',
                         'amount' => '75.50',
                         'category' => ExpenseCategory::TRAVEL->value,
                         'expense_date' => Carbon::parse('2025-09-28')->toISOString(),
                     ],
                 ]);

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'title' => 'Updated lunch description',
            'amount' => 75.50,
            'category' => ExpenseCategory::TRAVEL->value,
            'expense_date' => '2025-09-28 00:00:00',
        ]);
    }

    /**
     * Test that a user can delete an expense.
     */
    public function test_user_can_delete_expense(): void
    {
        $expense = Expense::factory()->create();

        $response = $this->deleteJson('/v1/api/expenses/' . $expense->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
    }

    /**
     * Test validation for creating an expense.
     */
    public function test_create_expense_validation(): void
    {
        $expenseData = [
            'title' => '', // Invalid: empty
            'amount' => -10.00, // Invalid: negative
            'category' => 'INVALID_CATEGORY', // Invalid: not in enum
            'expense_date' => 'not-a-date', // Invalid: wrong format
        ];

        $response = $this->postJson('/v1/api/expenses', $expenseData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'amount', 'category', 'expense_date']);
    }
}
