<?php
namespace App\Sources\Forms\Expense;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExpenseForm{

    static $rule = [
        'amount' => [
            'required',
            'number',
            'min:1'
        ]
    ];

    public static function add($data){
        return Validator::make($data, static::$rule);
    }
}
