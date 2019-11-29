<?php
 
namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Support\Str;

class ArticleController extends AdminController
{
    use ModelForm;
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('文章')
            ->description('列表')
            ->body($this->grid());
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
            ->header('内容')
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
 
                $content->header('编辑文章');
                $content->description('编辑文章');
     
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
                $content->header('创建文章');
                $content->body($this->form());
            });   
    }
 
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);
        $grid->model()->orderBy('id', 'desc');
        $grid->id('ID');
        $grid->title('标题');
        $grid->category_id('分类')->display(function($category_id){
            return Category::where('id',$category_id)->value('name');
        });;
        $grid->doc('附件')->display(function($doc){
            if($doc) return '<a href="/static/uploads/'.$doc.'" target="_blank">下载</a>';
        });
        $grid->image('缩略图')->display(function($image){
            if($image) return '<img src="/static/uploads/'.$image.'"  width="80px" heigth="50px" />';
        });
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');
        $grid->quickSearch('title');
        $grid->paginate(15);
        return $grid;
    }
 
    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));
 
        $show->id('文章ID');
        $show->title('标题');
        $show->category_id('分类')->as(function($category_id){
            return Category::where('id',$category_id)->value('name');
        });
        $show->content('文章内容');
        $show->doc('附件');
        $show->image('缩略图');
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
        return Admin::form(Article::class, function (Form $form) {
            $form->text('title','标题')->rules('required');
            $form->select('category_id','选择分类')->rules('required')->options(Category::selectOptions());
            $form->file('doc','附件')->uniqueName();
            $form->image('image','缩略图')->uniqueName();
            $form->UEditor('content','文章内容')->options(['initialFrameHeight' => 300])->rules('required');
            // $form->display('id', '文章ID');
            // $form->display('created_at', '创建时间');
            // $form->display('updated_at', '修改时间');
         });
    }
  

     public function upload(Request $request)
    {
        $urls = [];

        foreach ($request->file() as $file) {
            $urls[] = Storage::url($file->store('images'));
        }

        return [
            "errno" => 0,
            "data"  => $urls,
        ];
    }
}