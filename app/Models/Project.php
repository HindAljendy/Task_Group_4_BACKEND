<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'year',
        'image',
        'category',
    ];

    public function getCategoryAttribute($value)
    {
        return ucfirst($value);
    }
    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = ucfirst($value);
    }
   
}
