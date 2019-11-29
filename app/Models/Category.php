<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree, AdminBuilder;

    protected $table = 'category';
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('order');
        $this->setTitleColumn('name');
    }

    public function articles()
    {
        //反向关联
        return $this->hasMany(Article::class);
    }

      /**
     * 获取分类列表-select-option
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
     public static function getCategoryOptions()
     {
         $options = self::select('id','name as text')->get();
         $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
     }
}