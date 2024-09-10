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

    /**
     * @OA\Post(
     *     path="/api/expense",
     *     tags={"Expense Form"},
     *     summary="Add Expense",
     *     description="Add a new expense entry",
     *     operationId="addExpense",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(
     *                 property="amount",
     *                 type="integer",
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
     *                     property="amount",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="status_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

/**
 * @OA\Get(
 *     path="/api/expense/{id}",
 *     tags={"Expense Form"},
 *     summary="Get Expense Details",
 *     description="Retrieve detailed information of a specific expense by its ID",
 *     operationId="detailExpense",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
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
 *                 example={}
 *             )
 *         )
 *     )
 * )
 */

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
