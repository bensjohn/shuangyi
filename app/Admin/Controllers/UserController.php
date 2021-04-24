<?php

    namespace App\Admin\Controllers;

    use App\SyUser;
    use Encore\Admin\Controllers\AdminController;
    use Encore\Admin\Form;
    use Encore\Admin\Grid;
    use Encore\Admin\Show;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Validation\Rule;

    class UserController extends AdminController
    {

        use AuthenticatesUsers;
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
            $grid->column('username', __('登录名'));
            $grid->column('sex', __('性别'))->filter([
                1 => '男',
                2 => '女',
            ])->display(function ($text) {
                $return = '';
                switch ($text) {
                    case 1 :
                        $return = '男';
                        break;
                    case 2 :
                        $return = '女';
                        break;
                }
                return $return;
            });
            $grid->column('tel', __('电话'));
            $grid->column('userType', __('人员类型'))->display(function ($text) {
                $return = '';
                switch ($text) {
                    case 1 :
                        $return = '员工';
                        break;
                    case 2 :
                        $return = '司机';
                        break;
                }
                return $return;
            })->filter([
                1 => '员工',
                2 => '司机',
            ]);
            $grid->column('job', __('职位'));
            $grid->column('isDrive', __('有无驾照'))->display(function ($text) {
                $return = '';
                switch ($text) {
                    case 0 :
                        $return = '无';
                        break;
                    case 1 :
                        $return = '有';
                        break;
                }
                return $return;
            })->filter([
                0 => '无',
                1 => '有',
            ]);
            $grid->column('lastLoginTime', __('最后一次登录时间'));
            $grid->column('usercreate.name', __('创建人'));
            $grid->column('userupdate.name', __('修改人'));

            $grid->filter(function ($filter) {

                // 设置created_at字段的范围查询
                $filter->like('name', '姓名');
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
            $show = new Show(SyUser::findOrFail($id));

            $show->field('id', __('Id'));
            $show->field('name', __('姓名'));
            $show->field('username', __('登录名'));
            $show->field('avatar', __('头像'))->image();
            $show->field('sex', __('性别'))->using([1 => '男', 2 => '女']);
            $show->field('idsNumber', __('身份证号码'));
            $show->field('tel', __('手机号'));
            $show->field('address', __('手机号'));
            $show->field('userType', __('人员类型'))->using([1 => '员工', 2 => '司机']);
            $show->field('job', __('职位'));
            $show->field('isDrive', __('有无驾照'))->using(['0' => '无', 1 => '有']);
            $show->field('driveType', __('驾驶证类型'));
            $show->field('isManage', __('是否为管理员'))->using(['0' => '否', 1 => '是']);
            $show->field('urgentName', __('紧急联系人姓名'));
            $show->field('urgentRelation', __('紧急联系人关系'));
            $show->field('urgentTel', __('紧急联系人电话'));
            $show->field('lastLoginTime', __('最后一次登录时间'));
            $show->field('isBlackList', __('是否为黑名单'))->using(['0' => '否', 1 => '是']);
            $show->field('remark', __('备注'));
            $show->field('usercreate', __('创建人'))->as(function ($content) {
                return $content->name;
            });
            $show->field('userupdate', __('修改人'))->as(function ($content) {
                return $content->name;
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
            $form = new Form(new SyUser());

            $form->text('name', __('姓名'));
            if ($form->isEditing()) {
                $form->text('username', __('登录名'))->readonly();
            } else {
                $name = isset(request()->all()['name']) ? request()->all()['name'] : '';
                $form->text('username', __('登录名'))->creationRules(['required', Rule::unique('sy_userdata')
                ->where(function ($query)use($name){
                    return $query->where(['username' =>$name,'deleted_at'=>0]);
                })], [
                    'required' => '登录名必填',
                    'unique'   => '登录名重复',
                ]);
            }
            if ($form->isEditing()) {

            } else {
                $form->password('password', __('密码'))->rules('confirmed|required', [
                    'required' => '密码必填',
                ]);
                $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required', [
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
            $form->hidden('create_by');
            $form->hidden('update_by');
            $form->footer(function ($footer) {

                // 去掉`查看`checkbox
                $footer->disableViewCheck();

                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();

                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();

            });

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }

                if ($form->isCreating()) {
                    $form->create_by = LOGIN_UID;
                }

                $form->update_by = LOGIN_UID;

            });

            return $form;
        }
    }
