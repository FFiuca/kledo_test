<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Approver;

/**
 * @OA\Schema(
 *     schema="ApprovalStage",
 *     type="object",
 *     title="Approval Stage",
 *     description="Approval order",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *     ),
 *     @OA\Property(
 *         property="approver_id",
 *         type="integer",
 *         format="int64",
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
 *     )
 * )
 */

class ApprovalStage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //SECTION - rel
    public function approver(){
        return $this->belongsTo(Approver::class, 'approver_id',  'id');
    }
}
