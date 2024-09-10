<?php
namespace App\Sources\Forms\ApprovalStage;

use Illuminate\Support\Facades\Validator;
use App\Models\ApprovalStage;
use App\Models\Approver;
use Illuminate\Validation\Rule;

class ApprovalStageForm {

    private static function rule(){
        return [
            'approver_id' => [
                'required',
                Rule::unique((new ApprovalStage())->getTable(), 'approver_id'),
            ]
        ];
    }

    public static function add($data){
        $rule = static::rule();

        array_push(
            $rule['approver_id'],
            Rule::exists((new Approver())->getTable(), 'id')
        );

        return Validator::make($data, $rule);
    }

    public static function update($data){
        return Validator::make($data, [
            ...static::rule(), // why still use. if there any case future for additional global rule

            'id' => ['required'],
            'approver_id' => [
                'required',
                Rule::unique((new ApprovalStage())->getTable(), 'approver_id')->ignore($data['id']),
                Rule::exists((new Approver())->getTable(), 'id')
            ]
        ]);
    }
}
