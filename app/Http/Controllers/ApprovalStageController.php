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

    /**
     * @OA\Post(
     *     path="/api/approval-stages",
     *     tags={"Approval Stage Form"},
     *     summary="Create a new approver stage",
     *     description="Add approver stage which uses ascending sort by ID",
     *     operationId="addApproverStage",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(
     *                 property="approver_id",
     *                 type="integer",
     *                 description="ID of the approver"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Result of the operation",
     *                 @OA\Property(
     *                     property="approver_id",
     *                     type="integer",
     *                     description="ID of the approver"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Timestamp when the record was last updated"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Timestamp when the record was created"
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Unique identifier of the approver stage"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/approval-stages/{id}",
     *     tags={"Approval Stage Form"},
     *     summary="Update an approver stage",
     *     description="Updates an approver stage using the specified ID",
     *     operationId="updateApproverStage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the approver stage to update",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(
     *                 property="approver_id",
     *                 type="integer",
     *                 description="ID of the approver"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="boolean",
     *                 description="Result of the update operation",
     *                 example=true
     *             )
     *         )
     *     )
     * )
     */
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
