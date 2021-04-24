<?php

namespace App\Admin\Controllers;

use App\UpDataList;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UpDataListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\UpDataList';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UpDataList());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('upperName', __('上游名称'));
        $grid->column('upAccidentName', __('上游事故负责人'));
        $grid->column('upAccidentTel', __('上游事故负责人电话'));
        $grid->column('upRepairName', __('上游维修负责人'));
        $grid->column('upRepairTel', __('上游维修负责人电话'));
        $grid->column('upHealthTel', __('上游保养负责人电话'));
        $grid->column('upBreakRuleName', __('上游违章负责人'));
        $grid->column('upBreakRuleTel', __('上游违章负责人电话'));
        $grid->column('upCheckName', __('上游年检负责人'));
        $grid->column('upCheckTel', __('上游年检负责人电话'));

        $grid->filter(function ($filter) {

            // 设置created_at字段的范围查询
            $filter->like('upperName', '上游名称');
        });

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
        $show = new Show(UpDataList::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('upperName', __('上游名称'));
        $show->field('upAccidentName', __('上游事故负责人'));
        $show->field('upAccidentTel', __('上游事故负责人电话'));
        $show->field('upRepairName', __('上游维修负责人'));
        $show->field('upRepairTel', __('上游维修负责人电话'));
        $show->field('upHealthName', __('上游保养负责人'));
        $show->field('upHealthTel', __('上游保养负责人电话'));
        $show->field('upBreakRuleName', __('上游违章负责人'));
        $show->field('upBreakRuleTel', __('上游违章负责人电话'));
        $show->field('upCheckName', __('上游年检负责人'));
        $show->field('upCheckTel', __('上游年检负责人电话'));

        $show->create_by( __('创建人'),function ($author) {
            return $author->name;
        });

        $show->update_by( __('修改人'),function ($author) {
            return $author->name;
        });
        $show->field('create_by', __('创建人'));
        $show->field('update_by', __('修改人'));
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
        $form = new Form(new UpDataList());

        $form->text('name', __('姓名'));
        if ($form->isEditing()) {
            $form->text('username', __('登录名'))->readonly();
        } else {
            $form->text('username', __('登录名'))->creationRules(['required', "unique:sy_userdata"],[
                'required' => '登录名必填',
                'unique' => '登录名重复',
            ]);
        }
        if ($form->isEditing()) {

        } else {
            $form->password('password', __('密码'))->rules('confirmed|required',[
                'required' => '密码必填',
            ]);
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required',[
                'required' => '确认密码必填',
            ])->default(function ($form) {
                return $form->model()->password;
            });
            $form->ignore(['password_confirmation']);
        }
        $form->select('sex', '性别')->options([
            1 => '男',
            2 => '女',
        ]);
        $form->text('idsNumber', __('身份证号码'));
        $form->text('tel', __('电话'));
        $form->text('address', __('家庭地址'));
        $form->select('userType', __('人员类型'))->options([
            1 => '员工',
            2 => '司机',
        ]);
        $form->text('job', __('职位'));
        $form->select('isDrive', __('有无驾照'))->options([
            0 => '无',
            1 => '有',
        ]);
        $form->text('driveType', __('驾驶证类型'));
        $form->text('isManage', __('是否为管理员'));
        $form->text('urgentName', __('紧急联系人姓名'));
        $form->text('urgentRelation', __('紧急联系人关系'));
        $form->text('urgentTel', __('紧急联系人电话'));

        $form->switch('isBlackList', __('是否为黑名单'));
        $form->textarea('remark', __('备注'));
        $form->footer(function ($footer) {

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        $form->saving(function (Form $form) {

            if ($form->isCreating()){
                $form->create_by = LOGIN_UID;
            }

            $form->update_by = LOGIN_UID;

        });

        return $form;
    }
}
