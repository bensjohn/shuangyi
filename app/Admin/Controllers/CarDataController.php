<?php

namespace App\Admin\Controllers;

use App\CarData;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CarDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '车辆基本信息';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CarData());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('carClassData.carName', __('车辆字典'));
        $grid->column('InsureClassData.carName', __('carFrameNumber'));
        $grid->column('carNumber', __('车牌号'));
        $grid->column('engineNumber', __('发动机号'));
        $grid->column('carFrameNumber', __('车架号'));
        $grid->column('carFrameNumber', __('车架号'));


        $grid->filter(function ($filter) {

            // 设置created_at字段的范围查询
            $filter->like('upperName', '上游名称');
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
        $show = new Show(CarData::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CarData());



        return $form;
    }
}
