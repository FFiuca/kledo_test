<?php
namespace App\Sources\Forms\Expense;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Approver;
use App\Models\Expense;

class ApprovalExpenseForm{

    private static function rule(){
        return [
            'expense_id' => [
                'required',
                Rule::exists((new Expense())->getTable(), 'id')
            ],
            'approver_id' => [
                'required',
                Rule::exists((new Approver())->getTable(), 'id')
            ]
        ];
    }

    public static function approve($data){
        $rule = static::rule();

        return Validator::make($data, $rule);
    }
}
