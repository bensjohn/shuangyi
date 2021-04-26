<?php

namespace App\Admin\Controllers;

use App\InsureData;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InsureDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '保险记录表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InsureData());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('repairName', __('维修厂名称'));
        $grid->column('repairManagerTel', __('维修厂经理电话'));

        $grid->column('status', __('当前维修厂状态'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '合作中';
                    break;
                case 2 :
                    $return = '解除合作';
                    break;
            }
            return $return;
        });


        $grid->filter(function ($filter) {

            // 设置created_at字段的范围查询
            $filter->like('repairName', '维修厂名称');
        });

        $grid->column('usercreate.name', __('创建人'))->hide();
        $grid->column('userupdate.name', __('修改人'))->hide();
        $grid->paginate(20);

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(InsureData::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new InsureData());



        return $form;
    }
}
