<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categoryRelation()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subcategoryRelation()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id','id');
    }

    public function userRelation()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
