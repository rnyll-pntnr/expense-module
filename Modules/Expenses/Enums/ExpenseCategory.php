<?php

namespace Modules\Expenses\Enums;

/**
 * @OA\Schema(
 *     title="ExpenseCategory",
 *     description="Expense category enum",
 *     type="string",
 *     enum={"travel", "food", "supplies", "other"}
 * )
 */
enum ExpenseCategory: string
{
    case TRAVEL = 'travel';
    case FOOD = 'food';
    case SUPPLIES = 'supplies';
    case OTHER = 'other';
}
