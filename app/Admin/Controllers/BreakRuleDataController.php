<?php

namespace App\Admin\Controllers;

use App\BreakRuleData;
use App\CarData;
use App\SyUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BreakRuleDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '违章记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BreakRuleData());

        $grid->column('id', __('Id'));
        $grid->column('carData.carNumber', __('车牌号'));
        $grid->column('userid_.name', __('司机'));
        $grid->column('dealid_.name', __('经办人'));

        $grid->column('reduceGrade', __('扣分数'));
        $grid->column('fineCost', __('罚款费用'));
        $grid->column('dealClass', __('处理方式'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '公司处理';
                    break;
                case 2 :
                    $return = '驾驶人处理';
                    break;
            }
            return $return;
        });;
        $grid->column('dealDate', __('经办时间'));


        $grid->column('reamrk', __('备注'))->hide();

        $grid->filter(function ($filter) {
            $filter->like('carData.carNumber', '车牌号');
            $filter->like('userid_.name', '司机');
            $filter->like('dealid_.name', '经办人');
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
        $show = new Show(BreakRuleData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('carData', __('车牌号'))->as(function ($content) {
            return @$content->carNumber;
        });

        $show->field('userid_', __('司机'))->as(function ($content) {
            return @$content->name;
        });

        $show->field('dealid_', __('经办人'))->as(function ($content) {
            return @$content->name;
        });

        $show->field('breakrulecontent', __('违章内容(图片)'))->image();
        $show->field('reduceGrade', __('扣分数'));
        $show->field('fineCost', __('罚款费用'));
        $show->field('dealClass', __('处理方式'))->using([1=>'公司处理',2=>'驾驶人处理']);
        $show->field('breakpicture', __('违章处理截图'))->image();

        $show->field( 'remark',__('备注'));

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
        $form = new Form(new BreakRuleData());

        $data1 = CarData::pluck('carNumber','id')->toArray();
        $data2 = SyUser::pluck('name','id')->toArray();

        $form->select('carID', __('车牌号'))->options($data1);
        $form->select('userID', __('司机'))->options($data2);
        $form->select('dealID', __('经办人'))->options($data2);
        $form->multipleImage('breakrulecontent', __('违章内容(图片)'))->removable()->retainable()->sortable()->uniqueName();

        $form->text('reduceGrade', __('扣分数'));
        $form->text('fineCost', __('罚款费用'));
        $form->select('dealClass', __('处理方式'))->options([1=>'公司处理',2=>'驾驶人处理']);
        $form->multipleImage('breakpicture', __('违章处理截图'))->removable()->retainable()->sortable()->uniqueName();
        $form->date('dealDate', __('经办时间'));
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
