<?php

namespace App\Http\Controllers;

use App\Helpers\MainHelper;
use App\Sources\Forms\Expense\ExpenseForm;
use App\Sources\Services\Expense\ExpenseService;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function create(Request $request){
        $data = $request->only([
            'amount'
        ]);
        $form = null;

        try{
            DB::beginTransaction();

            $form = ExpenseForm::add($data);
            if($form->fails())
                throw new ValidationException($form);

            $data = (new ExpenseService)->add($data);

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

    public function detail(Request $request, $id){
        $data = null;
        try{
            $data = (new ExpenseService)->detail($id);
        }catch(Exception $e){
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
