<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    protected $table = 'members';
    protected $guarded = ['id'];
    protected $hidden = [];

    public function department()
    {
        return $this->belongsTo(Department::class, "departments");
    }
}
