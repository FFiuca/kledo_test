<?php

namespace App\Http\Controllers;

use App\Helpers\MainHelper;
use App\Sources\Forms\ApprovalStage\ApprovalStageForm;
use App\Sources\Services\ApprovalStage\ApprovalStageService;
use App\Sources\Services\Approver\ApproverService;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalStageController extends Controller
{
    public function create(Request $request){
        $form = null;
        $data = $request->only([
            'approver_id'
        ]);

        try{
            DB::beginTransaction();

            $form = ApprovalStageForm::add($data);
            if($form->fails())
                throw new ValidationException($form);

            $data = (new ApprovalStageService)->add($data);

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

    public function update(Request $request, $id){
        $form = null;
        $data = $request->only([
            'approver_id'
        ]);

        try{
            DB::beginTransaction();

            $form = ApprovalStageForm::update([...$data, 'id'=>$id]);
            if($form->fails())
                throw new ValidationException($form);

            $data = (new ApprovalStageService)->update($id, $data);

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
