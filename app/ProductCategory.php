<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Resource;
use App\ResourcesUsers;

class ProductCategory extends Model
{
    protected $fillable = [
        'title',
        'description',
        'photo',
        'icon',
        'parent_id',
        'for_service'
    ];

    protected $table = 'products__categories';

    public function parent() {
        return $this->belongsTo('App\ProductCategory', 'parent_id');
    }

    public function getAllParents() {
        $allParents = [];
        self::getAllParentsRecursive($this, $allParents);
        $allParents = array_reverse($allParents);
        return $allParents;
    }

    private static function getAllParentsRecursive($current, &$allParents) {
        if(!$current->parent) return;
        $allParents[] = $current->parent->id;
        self::getAllParentsRecursive($current->parent, $allParents);
    }

    public function getNeighbours() {
        return ProductCategory::where('parent_id', $this->parent_id)->where('for_service', $this->for_service)->get();
    }

    public function hasProducts() {
        $productsCount = Product::where('category_id', $this->id)
            ->where('is_confirmed', true)->count();
        if($productsCount){
            return true;
        } else {
            $childCategories = self::where('parent_id', $this->id)->get();
            foreach($childCategories as $childCategory){
                if($childCategory->hasProducts()) return true;
            }
            return false;
        }
    }

    public function children()
    {
        return $this->hasMany('App\ProductCategory', 'parent_id');
    }

    public function resources()
    {
        return $this->hasMany('App\Resources', 'category_id');
    }

}