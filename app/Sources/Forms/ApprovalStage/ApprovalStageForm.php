<?php
namespace App\Sources\Forms\ApprovalStage;

use Illuminate\Support\Facades\Validator;
use App\Models\ApprovalStage;
use Illuminate\Validation\Rule;

class ApprovalStageForm {

    static $rule = [
        'approver_id' => [
            'required',
            Rule::unique((new ApprovalStage())->getTable(), 'approver_id')
        ]
    ];

    public static function add($data){
        return Validator::make($data, static::$rule);
    }

    public static function update($data){
        return Validator::make($data, [
            ...static::$rule, // why still use. if there any case future for additional global rule

            'id' => ['required'],
            'approver_id' => [
                'required',
                Rule::unique((new ApprovalStage())->getTable(), 'approver_id')->ignore($data['id'])
            ]
        ]);
    }
}
