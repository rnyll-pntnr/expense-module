<?php

namespace Modules\Expenses\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Expenses\Enums\ExpenseCategory;

/**
 * @OA\Schema(
 *     title="Expense",
 *     description="Expense model",
 *     @OA\Xml(
 *         name="Expense"
 *     )
 * )
 */
class Expense extends Model
{
    use HasUuids, HasFactory;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the expense",
     *     format="string",
     *     readOnly=true,
     *     example="9a1d8f7e-1b2c-3d4e-5f6a-7b8c9d0e1f2a"
     * )
     * @var string
     */
    private string $id;

    /**
     * @OA\Property(
     *     title="Title",
     *     description="Title of the expense",
     *     example="Groceries"
     * )
     * @var string
     */
    private string $title;

    /**
     * @OA\Property(
     *     title="Amount",
     *     description="Amount of the expense",
     *     format="float",
     *     example="50.25"
     * )
     * @var float
     */
    private float $amount;

    /**
     * @OA\Property(
     *     title="Category",
     *     description="Category of the expense",
     *     ref="#/components/schemas/ExpenseCategory"
     * )
     * @var string
     */
    private string $category;

    /**
     * @OA\Property(
     *     title="Expense Date",
     *     description="Date of the expense",
     *     format="date",
     *     example="2025-09-27"
     * )
     * @var string
     */
    private string $expense_date;

    /**
     * @OA\Property(
     *     title="Notes",
     *     description="Additional notes for the expense",
     *     nullable=true,
     *     example="Weekly grocery shopping"
     * )
     * @var string|null
     */
    private ?string $notes;

    /**
     * @OA\Property(
     *     title="Created At",
     *     description="Date and time when the expense was created",
     *     format="datetime",
     *     readOnly=true,
     *     example="2025-09-27T10:00:00.000000Z"
     * )
     * @var string
     */
    private string $created_at;

    /**
     * @OA\Property(
     *     title="Updated At",
     *     description="Date and time when the expense was last updated",
     *     format="datetime",
     *     readOnly=true,
     *     example="2025-09-27T10:00:00.000000Z"
     * )
     * @var string
     */
    private string $updated_at;

    protected $fillable = [
        'title',
        'amount',
        'category',
        'expense_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'category' => ExpenseCategory::class,
    ];

    protected static function newFactory()
    {
        return \Database\Factories\ExpenseFactory::new();
    }
}
