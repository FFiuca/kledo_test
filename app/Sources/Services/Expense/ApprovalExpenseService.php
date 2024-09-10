<?php
namespace App\Sources\Services\Expense;

use App\Models\Approvals;
use App\Sources\Repositories\Expense\ApprovalExpenseRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApprovalStage;
use App\Sources\Repositories\Expense\ExpenseRepository;
use Illuminate\Support\Facades\DB;


class ApprovalExpenseService extends ApprovalExpenseRepository{

    protected $expense;

    function __construct(
        ExpenseRepository $expense = (new ExpenseService())
    ){
        $this->expense = $expense;
    }

    function approve($expenseId, $approverId): bool|Model{
        if($this->isCanApprove($expenseId, $approverId)==false)
            throw new Exception('There are pending approval is waiting. Contact person related.');

        $approve = Approvals::where([
            'expense_id'=> $expenseId,
            'approver_id'=> $approverId
        ])->first();

        $approve->status_id = 2;
        $approve->save();

        if($this->isApprovedByAll($expenseId))
            $this->expense->approve($expenseId);

        return $approve;
    }

    function addBatch(Model $expense): bool{
        $details = [];

        // build detail
        $approvalStage = ApprovalStage::orderBy('id', 'asc')->get();
        foreach($approvalStage as $key=>$r){
            $details[] = new Approvals([
                'approver_id' => $r->approver_id,
                'status_id' => 1
            ]);
        }

        $expense->approval()->saveMany($details);

        return true;
    }

    //NOTE - no need abstract due sublogic instead future can change
    protected function isCanApprove($expenseId, $approverId){
        $isExist = Approvals::where([
            'expense_id' => $expenseId,
            'status_id' => 1
        ])->where('approver_id', '<',$approverId)->count();

        return $isExist==0;
    }

    protected function isApprovedByAll($expenseId){
        $isExist = Approvals::where([
                'expense_id'=> $expenseId,
                'status_id' => 1
            ])->count();

        return $isExist==0;
    }

}
