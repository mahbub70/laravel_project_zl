<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Relation with category table
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand',
        'model',
        'title',
        'description',
        'price',
        'phone',
        'optional_phone',
        'thumbnail',
        'images',
        'status',
        'discount',
        'position',
    ];
}
