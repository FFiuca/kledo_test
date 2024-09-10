<?php
namespace App\Sources\Forms\Expense;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Approver;

class ApprovalExpenseForm{

    private static function rule(){
        return [
            'expense_id' => ['required'],
            'approver_id' => [
                'required',
            ]
        ];
    }

    public static function approve($data){
        $rule = static::rule();

        array_push(
            $rule['approver_id'],
            Rule::unique((new Approver())->getTable())->where(function($q) use($data){
                return $q->where('id', $data['approver_id']);
            })
        );

        return Validator::make($data, $rule);
    }
}
