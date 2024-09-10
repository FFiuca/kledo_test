<?php
namespace App\Sources\Repositories\Expense;

use Illuminate\Database\Eloquent\Model;

abstract class ApprovalExpenseRepository{
    abstract public function approve($expenseId, $approverId): Model|bool;

    abstract public function addBatch(Model $expense):bool;
}
