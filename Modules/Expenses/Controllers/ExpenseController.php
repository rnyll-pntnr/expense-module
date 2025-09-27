<?php

namespace Modules\Expenses\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Expenses\Requests\StoreExpenseRequest;
use Modules\Expenses\Requests\UpdateExpenseRequest;
use Modules\Expenses\Services\ExpenseService;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Expense Module API Documentation",
 *      description="API documentation for the Expense module",
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 * @OA\Tag(
 *     name="Expenses",
 *     description="API Endpoints for Expenses"
 * )
 */
class ExpenseController extends Controller
{
    public function __construct(private readonly ExpenseService $expenseService) { }

    /**
     * @OA\Get(
     *     path="/v1/api/expenses",
     *     tags={"Expenses"},
     *     summary="Get all expenses",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Expense"))
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->expenseService->getAllExpenses($request->all())
        ]);
    }

    /**
     * @OA\Get(
     *     path="/v1/api/expenses/{id}",
     *     tags={"Expenses"},
     *     summary="Get a single expense by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the expense to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Expense")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        $expense = $this->expenseService->getExpenseById($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $expense,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/v1/api/expenses",
     *     tags={"Expenses"},
     *     summary="Create a new expense",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Expense data",
     *         @OA\JsonContent(ref="#/components/schemas/StoreExpenseRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Expense created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Expense")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = $this->expenseService->createExpense($request->validated());

        return response()->json([
            'data' => $expense,
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/v1/api/expenses/{id}",
     *     tags={"Expenses"},
     *     summary="Update an existing expense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the expense to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated expense data",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateExpenseRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Expense")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateExpenseRequest $request, string $id): JsonResponse
    {
        $updated = $this->expenseService->updateExpense($id, $request->validated());

        if (!$updated) {
            return response()->json(['message' => 'Expense not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $this->expenseService->getExpenseById($id),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/v1/api/expenses/{id}",
     *     tags={"Expenses"},
     *     summary="Delete an expense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the expense to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Expense deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->expenseService->deleteExpense($id);

        if (!$deleted) {
            return response()->json(['message' => 'Expense not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
