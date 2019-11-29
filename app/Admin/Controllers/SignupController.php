<?php
namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use App\Models\Signup;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
class SignupController extends AdminController
{
    use ModelForm;
     public function index(Content $content)
    {
        // 选填
        $content->header('报名列表')->body($this->grid());
        return $content;
    }

       /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Signup);
        $grid->model()->orderBy('id', 'desc');
        $grid->id('ID');
        $grid->name('姓名');
        $grid->mobile('电话');
        $grid->data('附件')->display(function($data){
            if($data) return '<a href="/static/uploads/'.$data.'" target="_blank">下载</a>';
        });;
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');
        $grid->quickSearch('name','mobile');
        $grid->paginate(15);
        return $grid;
    }

      /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('详情')
            ->body($this->detail($id));
    }
 
    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
            return Admin::content(function (Content $content) use ($id) {
 
                $content->header('编辑');
                $content->body($this->form()->edit($id));
            });    
    }
 
    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        
            return Admin::content(function (Content $content) {
                $content->header('创建');
                $content->body($this->form());
            });   
    }
    
    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Signup::findOrFail($id));
 
        $show->name('姓名');
        $show->mobile('电话');
        $show->data('附件')->image();
        $show->created_at('创建时间');
        $show->updated_at('修改时间');
        return $show;


    }
 
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Signup::class, function (Form $form) {
            $form->text('name','姓名')->rules('required');
            $form->text('mobile','电话')->rules('required');
            $form->image('data','附件')->rules('required')->name(function ($file) {
                return request('name').'_'.request('mobile').'.'.$file->guessExtension();
            });
           
         });
    }
}