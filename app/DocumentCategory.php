<?php

namespace DocumentController;
namespace App;
use Illuminate\Database\Eloquent\Model;
class DocumentCategory extends Model
{
    protected $fillable = [
        'code', 'name'
    ];

    protected $table = 'doc_category';

    public function roles()
    {
        return $this->belongsToMany('App\UserRole', 'doc_access',  'doc_category_id', 'role_id');
    }
    public function getRolesDisplay()
    {
        $rolesList = $this->belongsToMany('App\UserRole', 'doc_access',  'doc_category_id', 'role_id')->get()->pluck('name')->toArray();
        return implode(', ', $rolesList);
    }
}
