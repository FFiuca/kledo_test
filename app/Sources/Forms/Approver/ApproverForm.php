<?php
namespace App\Sources\Forms\Approver;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Approver;

class ApproverForm{

    static $rule = [
        'name' => [
            'required',
            Rule::unique((new Approver())->getTable(), 'name')
        ]
    ];

    //SECTION - func
    public static function add(array $data){
        return Validator::make($data, static::$rule);
    }

}
