<?php

namespace App\Admin\Controllers;

use App\CarData;
use App\HealthData;
use App\SyUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HealthDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '保养记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HealthData());


        $grid->column('id', __('Id'));
        $grid->column('carData.carNumber', __('车牌号'));
        $grid->column('userid_.name', __('司机'));

        $grid->column('healthContent', __('保养内容'));
        $grid->column('payer', __('付款方'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '上游支付';
                    break;
                case 2 :
                    $return = '公司自费';
                    break;
            }
            return $return;
        });;
        $grid->column('healthCost', __('保养费用'));
        $grid->column('lastTimeHealthNumber', __('上次保养公里数'));
        $grid->column('healthNumber', __('保养里程数'));
        $grid->column('healthDate', __('保养时间'));
        $grid->column('nextTimeKeep', __('下次保养公里数'));
        $grid->column('remark', __('备注'))->hide();

        $grid->filter(function ($filter) {
            $filter->like('carData.carNumber', '车牌号');
            $filter->like('userid_.name', '司机');
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
        $show = new Show(HealthData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('carData', __('车牌号'))->as(function ($content) {
            return @$content->carNumber;
        });

        $show->field('userid_', __('司机'))->as(function ($content) {
            return @$content->name;
        });
        $show->field('mileagefile', __('里程数照片'))->image();

        $show->field('healthContent', __('保养内容'));
        $show->field('payer', __('付款方'))->using([1=>'上游支付',2=>'公司自费']);
        $show->field('healthCost', __('保养费用'));
        $show->field('lastTimeHealthNumber', __('上次保养公里数'));
        $show->field('healthNumber', __('保养里程数'));
        $show->field('healthDate', __('保养时间'));
        $show->field('nextTimeKeep', __('下次保养公里数'));
        $show->field('remark', __('备注'));

        $show->field('usercreate', __('创建人'))->as(function ($content) {
            return @$content->name;
        });
        $show->field('userupdate', __('修改人'))->as(function ($content) {
            return @$content->name;
        });
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HealthData());


        $data1 = CarData::pluck('carNumber','id')->toArray();
        $data2 = SyUser::pluck('name','id')->toArray();

        $form->select('carID', __('车牌号'))->options($data1);
        $form->select('userID', __('司机'))->options($data2);
        $form->multipleImage('mileagefile', __('里程数照片'))->removable()->retainable()->sortable()->uniqueName();


        $form->text('healthContent', __('保养内容'));
        $form->select('payer', __('付款方'))->options([1=>'上游支付',2=>'公司自费']);
        $form->text('healthCost', __('保养费用'));
        $form->text('lastTimeHealthNumber', __('上次保养公里数'));
        $form->text('healthNumber', __('保养里程数'));
        $form->date('healthDate', __('保养时间'));
        $form->text('nextTimeKeep', __('下次保养公里数'));
        $form->text('remark', __('备注'));

        $form->footer(function ($footer) {

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        $form->saving(function (Form $form) {

            if ($form->isCreating()) {
                $form->create_by = LOGIN_UID;
            }

            $form->update_by = LOGIN_UID;

        });

        $form->hidden('create_by');
        $form->hidden('update_by');

        return $form;
    }
}
