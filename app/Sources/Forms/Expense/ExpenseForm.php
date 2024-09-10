<?php
namespace App\Sources\Forms\Expense;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExpenseForm{

    private static function rule(){
        return [
            'amount' => [
                'required',
                'numeric',
                'min:1'
            ]
        ];
    }

    public static function add($data){
        return Validator::make($data, static::rule());
    }
}
