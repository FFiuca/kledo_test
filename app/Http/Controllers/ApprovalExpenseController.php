<?php

namespace App\Http\Controllers;

use App\Helpers\MainHelper;
use App\Sources\Forms\Expense\ApprovalExpenseForm;
use App\Sources\Services\Expense\ApprovalExpenseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApprovalExpenseController extends Controller
{
    public function approve(Request $request, $id){
        $form = null;
        $data = $request->only([
            'approver_id'
        ]);

        try{
            DB::beginTransaction();

            $form = ApprovalExpenseForm::approve([
                ...$data,
                'expense_id' => $id
            ]);
            if($form->fails())
                throw new ValidationException($form);

            $data = (new ApprovalExpenseService)->approve($id, $data['approver_id']);

            DB::commit();
        }catch(ValidationException $e){
            return response()->json([
                'status' => 400,
                'data' => $form->getMessageBag()
            ], 400);
        }catch(Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'data' => [
                    'message' => MainHelper::messageError($e)
                ]
            ], 500);
        }

        return response()->json([
            'status' => 200,
            'data'=> $data
        ], 200);
    }
}
