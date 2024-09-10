<?php
namespace App\Sources\Services\Expense;

use App\Models\Expense;
use App\Sources\Repositories\Expense\ApprovalExpenseRepository;
use App\Sources\Repositories\Expense\ExpenseRepository;
use Illuminate\Database\Eloquent\Model;

class ExpenseService extends ExpenseRepository{
    protected $approvalExpense;

    function __construct(
        ApprovalExpenseRepository $approvalExpense= (new ApprovalExpenseService)
    ){
        $this->approvalExpense = $approvalExpense;
    }

    function add(array $data): bool|Model{
        $add = Expense::create($data);

        $this->approvalExpense->addBatch($add);

        return $add;
    }

    function detail($id): array|Model{
        $data = Expense::where('id', $id)->with([
            'status',
            'approval' => function($q){
                $q->with([
                    'status',
                    'approver',
                ]);
            }
        ])->first();

        return $data;
    }

    function approve($id): bool{
        $approve = Expense::where('expense_id', $id)->update(['status_id'=> 2]);

        return $approve;
    }
}
