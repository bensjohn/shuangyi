<?php

namespace App\Admin\Controllers;

use App\SyUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SyUser());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('姓名'));
        $grid->column('sex', __('性别'))->display(function($text) {
            $return = '';
            switch ($text){
                case 2 : $return = '男';break;
                case 1 : $return = '女';break;
            }
            return $return;
        });
        $grid->column('phone', __('手机号'));
        $grid->column('isDriveCar', __('有无驾照'))->display(function($text) {
            $return = '';
            switch ($text){
                case 1 : $return = '有';break;
                case 2 : $return = '无';break;
            }
            return $return;
        });
        $grid->column('driveNumber', __('驾照编号'));
        $grid->column('driveType', __('驾驶证类型'));
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
        $show = new Show(SyUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('姓名'));
        $show->field('sex', __('性别'))->using(['0' => '未选择',1=>'女',2=>'男']);
        $show->field('identity', __('证件号'));
        $show->field('phone', __('手机号'));
        $show->field('prepareMobilePhone', __('紧急预备电话'));
        $show->field('address', __('地址'));
        $show->field('email', __('电子邮箱'));
        $show->field('job', __('职位'));
        $show->field('isDriveCar', __('有无驾照'))->using(['0' => '未选择',1=>'有',2=>'无']);
        $show->field('driveNumber', __('驾照编号'));
        $show->field('driveType', __('驾驶证类型'));
        $show->field('driveType', __('驾驶证类型'));
        $show->field('isBlack', __('是否为黑名单'))->using(['0' => '否',1=>'是']);
        $show->field('back', __('备注'));
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
        $form = new Form(new SyUser());

        $form->text('name', __('姓名'));
        $form->select('sex', '性别')->options([
            0 => '暂不选择' ,
            2 => '男',
            1 => '女' ,
        ]);
        $form->text('identity', __('身份证'));
        $form->text('phone', __('手机'));
        $form->text('prepareMobilePhone', __('紧急预备电话'));
        $form->text('address', __('地址'));
        $form->email('email', __('电子邮箱'));
        $form->text('job', __('职位'));
        $form->select('isDriveCar', __('有无驾照'))->options([
            0 => '暂不选择' ,
            1 => '有',
            2 => '无' ,
        ]);
        $form->text('driveNumber', __('驾照编号'));
        $form->text('driveType', __('驾驶证类型'));
        $form->switch('isBlack', __('是否为黑名单'));
        $form->text('back', __('备注'));
        $form->footer(function ($footer) {

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });
        return $form;
    }
}
