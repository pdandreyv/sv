<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductCategory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{    

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'cooperative_price',
        'category_id',
        'quantity',
        'weight', 
        'user_id',
        'is_service',
        'is_confirmed',
        'production_place'
    ];    

    protected $dates = ['deleted_at'];

    protected $table = 'products__products';

    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getAllCategories() {
        $allCategories = [];
        self::getAllCategoriesRecursive($this->category_id, $allCategories);
        $allCategories = array_reverse($allCategories);
        return $allCategories;
    }

    private static function getAllCategoriesRecursive($current_id, &$allCategories){
        $currentCategory = ProductCategory::find($current_id);        
        if(!$currentCategory) return;
        $allCategories[] = $currentCategory->id;
        self::getAllCategoriesRecursive($currentCategory->parent_id, $allCategories);
    } 

    public function image()
    {
        return $this->hasMany('App\ProductImage');
    }   

    
}