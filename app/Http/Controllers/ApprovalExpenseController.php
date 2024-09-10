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

    /**
 * @OA\Patch(
 *     path="/api/expense/{id}/approve",
 *     tags={"Expense Form"},
 *     summary="Approve Expense",
 *     description="Approve an expense by a specific approver",
 *     operationId="approveExpense",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the expense",
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
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example=2
 *                 ),
 *                 @OA\Property(
 *                     property="expense_id",
 *                     type="integer",
 *                     example=2
 *                 ),
 *                 @OA\Property(
 *                     property="approver_id",
 *                     type="integer",
 *                     example=1
 *                 ),
 *                 @OA\Property(
 *                     property="status_id",
 *                     type="integer",
 *                     example=2
 *                 ),
 *                 @OA\Property(
 *                     property="created_at",
 *                     type="string",
 *                     format="date-time",
 *                     example="2024-09-10T15:53:46.000000Z"
 *                 ),
 *                 @OA\Property(
 *                     property="updated_at",
 *                     type="string",
 *                     format="date-time",
 *                     example="2024-09-10T15:56:17.000000Z"
 *                 )
 *             )
 *         )
 *     )
 * )
 */
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
