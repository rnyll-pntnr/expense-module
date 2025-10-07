<?php

namespace Modules\Expenses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Expenses\Enums\ExpenseCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 *     title="StoreExpenseRequest",
 *     description="Store expense request body data",
 *     @OA\Xml(
 *         name="StoreExpenseRequest"
 *     )
 * )
 */
class StoreExpenseRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'category' => ['required', new Enum(ExpenseCategory::class)],
            'expense_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
