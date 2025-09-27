<?php

namespace Modules\Expenses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Expenses\Enums\ExpenseCategory;

/**
 * @OA\Schema(
 *     title="UpdateExpenseRequest",
 *     description="Update expense request body data",
 *     @OA\Xml(
 *         name="UpdateExpenseRequest"
 *     )
 * )
 */
class UpdateExpenseRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     title="Title",
     *     description="Title of the expense",
     *     example="Groceries"
     * )
     * @var string
     */
    public string $title;

    /**
     * @OA\Property(
     *     title="Amount",
     *     description="Amount of the expense",
     *     format="float",
     *     example="50.25"
     * )
     * @var float
     */
    public float $amount;

    /**
     * @OA\Property(
     *     title="Category",
     *     description="Category of the expense",
     *     ref="#/components/schemas/ExpenseCategory"
     * )
     * @var string
     */
    public string $category;

    /**
     * @OA\Property(
     *     title="Expense Date",
     *     description="Date of the expense",
     *     format="date",
     *     example="2025-09-27"
     * )
     * @var string
     */
    public string $expense_date;

    /**
     * @OA\Property(
     *     title="Notes",
     *     description="Additional notes for the expense",
     *     nullable=true,
     *     example="Weekly grocery shopping"
     * )
     * @var string|null
     */
    public ?string $notes;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'amount' => ['sometimes', 'required', 'numeric', 'min:0'],
            'category' => ['sometimes', 'required', new Enum(ExpenseCategory::class)],
            'expense_date' => ['sometimes', 'required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
