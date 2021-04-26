<?php

    namespace App\Admin\Controllers;

    use App\UpDataList;
    use Encore\Admin\Controllers\AdminController;
    use Encore\Admin\Form;
    use Encore\Admin\Grid;
    use Encore\Admin\Show;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Validation\Rule;

    class UpDataListController extends AdminController
    {
        /**
         * Title for current resource.
         *
         * @var string
         */
        protected $title = '上游记录';

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
            $grid->column('upHealthName', __('上游保养负责人'));
            $grid->column('upHealthTel', __('上游保养负责人电话'));
            $grid->column('upBreakRuleName', __('上游违章负责人'));
            $grid->column('upBreakRuleTel', __('上游违章负责人电话'));
            $grid->column('upCheckName', __('上游年检负责人'));
            $grid->column('upCheckTel', __('上游年检负责人电话'));

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
            $form = new Form(new UpDataList());

            $name = isset(request()->all()['upperName']) ? request()->all()['upperName'] : '';

            $form->text('upperName', __('上游名称'))
                 ->creationRules(['required', Rule::unique('sy_updatalist')->where(function ($query)use($name){
                     return $query->where(['upperName' =>$name,'deleted_at'=>null]);
                 })], [
                'required' => '上游名称必填',
                'unique'   => '上游名称重复',
            ])->updateRules(['required', Rule::unique('sy_updatalist')->where(function ($query)use($name){
                    return $query->where(['upperName' =>$name,'deleted_at'=>null]);
                })->ignore(@request()->route()->parameters()['up_data_list'])], [
                    'required' => '上游名称必填',
                    'unique'   => '上游名称重复',
                ]);



            $form->text('upAccidentName', __('上游事故负责人'));
            $form->mobile('upAccidentTel', __('上游事故负责人电话'));
            $form->text('upRepairName', __('上游维修负责人'));
            $form->mobile('upRepairTel', __('上游维修负责人电话'));
            $form->text('upHealthName', __('上游保养负责人'));
            $form->mobile('upHealthTel', __('上游保养负责人电话'));
            $form->text('upBreakRuleName', __('上游违章负责人'));
            $form->mobile('upBreakRuleTel', __('上游违章负责人电话'));
            $form->text('upCheckName', __('上游年检负责人'));
            $form->mobile('upCheckTel', __('上游年检负责人电话'));

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
