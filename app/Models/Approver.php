<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Approver",
 *     type="object",
 *     title="Approver",
 *     description="Approver person",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=150,
 *         example="Lorem",
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *     )
 * )
 */

class Approver extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    //SECTION - rel
    public function approvalStage(){
        return $this->hasOne(ApprovalStage::class, 'approver_id', 'id');
    }
}
