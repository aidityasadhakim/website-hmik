<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      required={"name","description","department","imgUrl","position"},
 *      description="Action Plans",
 *      title="Action Plan Schema"
 * )
 */

class Members extends Model
{


    /**
     * 
     *      @OA\Property(
     *      description="name",
     *      property="name",
     *      type="string",
     *      format="Aidityas",
     *      )
     *      @OA\Property(
     *      description="Moto Hidup",
     *      property="description",
     *      type="string",
     *      format="string",
     *      )
     *      @OA\Property(
     *      description="Department HMIK",
     *      property="department",
     *      type="string",
     *      format="1",
     *      )
     *      @OA\Property(
     *      description="Link to the profile Image",
     *      property="imgUrl",
     *      type="string",
     *      format="string",
     *      )
     *      @OA\Property(
     *      description="Position in HMIK",
     *      property="position",
     *      type="string",
     *      format="string",
     *      )
     *      @OA\Property(
     *      description="Link to LinkedIn Profile",
     *      property="linkedin",
     *      type="string",
     *      format="string",
     *      )
     *      @OA\Property(
     *      description="Link to Instagram",
     *      property="instagram",
     *      type="string",
     *      format="string",
     *      )
     *      @OA\Property(
     *      description="Link to github",
     *      property="github",
     *      type="string",
     *      format="string",
     *      )
     *      
     *  */

    use HasFactory;

    protected $table = 'members';
    protected $guarded = ['id'];
    protected $hidden = [];

    public function department()
    {
        return $this->belongsTo(Department::class, "departments");
    }
}
