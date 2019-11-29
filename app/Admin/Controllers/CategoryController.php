<?php
 
namespace App\Admin\Controllers;
 
use App\Models\Category;
 
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Controllers\AdminController;

class CategoryController extends AdminController
{
    use ModelForm;
 
    protected $header = '分类列表';
 
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
 
            $content->header($this->header);
            $content->description('列表');
 
            $content->row(function (Row $row) {
 
                $row->column(6, $this->treeView()->render());
 
                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
 
                    $form->text('name','分类名称')->rules('required');
                    $form->number('order','排序序号')->rules('required')->default(0);
                    $form->text('title','标题')->rules('required');
                    $form->textarea('keywords','关键字')->rules('required');
                    $form->textarea('description','描述')->rules('required');
                    $form->select('parent_id','父级分类')->options(Category::selectOptions());
                    
                    $form->hidden('_token')->default(csrf_token());
 
                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
            });
 
 
 
        });
    }
 
 
    protected function treeView()
    {
        return Category::tree(function (Tree $tree) {
            $tree->disableCreate();
            return $tree;
        });
    }
    
 
    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
 
            $content->header($this->header);
            $content->description('编辑分类');
 
            $content->body($this->form()->edit($id));
        });
    }
 
    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
 
            $content->header($this->header);
            $content->description('添加分类');
 
            $content->body($this->form());
        });
    }
 
 
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {
 
            $form->display('id', 'ID');
 
            $form->text('name','分类名称');
            $form->number('order','排序');
            $form->text('title','标题');
            $form->textarea('keywords','关键字');
            $form->textarea('description','描述');
            $form->select('parent_id','父类名称')->options(Category::selectOptions());
 
 
        });
    }
 

}