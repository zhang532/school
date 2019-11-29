<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Widgets\Box;

class HomeController extends AdminController
{
      /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('控制台')
            ->body(new Box('Bar chart', view('admin.chartjs')));
    }    
}
