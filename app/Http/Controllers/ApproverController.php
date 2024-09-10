<?php

namespace App\Http\Controllers;

use App\Sources\Services\Approver\ApproverService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Helpers\MainHelper;
use App\Sources\Forms\Approver\ApproverForm;
use Illuminate\Support\Facades\DB;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Approver",
 *         version="1.0.0",
 *         description="Approver Management"
 *     )
 * )
 */

class ApproverController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/approver",
     *     tags={"Approver Form"},
     *     summary="Create a new approver form",
     *     description="Handles the creation of a new approver",
     *     operationId="createApproverForm",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="The name of the approver form"
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
     *                 description="resul",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description=""
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description=""
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description=""
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description=""
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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
