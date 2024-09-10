<?php

namespace App\Http\Controllers;

use App\Sources\Services\Approver\ApproverService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Helpers\MainHelper;
use App\Sources\Forms\Approver\ApproverForm;
use Illuminate\Support\Facades\DB;


class ApproverController extends Controller
{

    public function create(Request $request){
        $data = $request->only([
            'name'
        ]);
        $form = null;

        try{
            DB::beginTransaction(); // place oustide service due any possibility controller will call more than 1 service

            $form = ApproverForm::add($data);
            if($form->fails())
                throw new ValidationException($form);

            $data = (new ApproverService)->add($data);

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
