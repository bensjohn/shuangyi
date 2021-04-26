<?php

    namespace App\Admin\Controllers;

    use App\InsureClassData;
    use Encore\Admin\Controllers\AdminController;
    use Encore\Admin\Form;
    use Encore\Admin\Grid;
    use Encore\Admin\Show;
    use Illuminate\Validation\Rule;

    class InsureClassDataController extends AdminController
    {
        /**
         * Title for current resource.
         *
         * @var string
         */
        protected $title = '保险字典';

        /**
         * Make a grid builder.
         *
         * @return Grid
         */
        protected function grid()
        {
            $grid = new Grid(new InsureClassData());

            $grid->column('id', __('Id'))->sortable();
            $grid->column('insureName', __('保险公司名称'));

            $grid->column('created_at', __('创建时间'));

            $grid->column('usercreate.name', __('创建人'))->hide();
            $grid->column('userupdate.name', __('修改人'))->hide();

            $grid->filter(function ($filter) {

                // 设置created_at字段的范围查询
                $filter->like('insureName', '保险公司名称');
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
            $show = new Show(InsureClassData::findOrFail($id));

            $show->field('id', __('Id'));
            $show->field('insureName', __('保险公司名称'));

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
            $form = new Form(new InsureClassData());

            $name = isset(request()->all()['insureName']) ? request()->all()['insureName'] : '';

            $form->text('insureName', __('上游名称'))
                 ->creationRules(['required', Rule::unique('sy_insureClassData')->where(function ($query)use($name){
                     return $query->where(['insureName' =>$name,'deleted_at'=>null]);
                 })], [
                     'required' => '保险公司名称必填',
                     'unique'   => '保险公司名称重复',
                 ])->updateRules(['required', Rule::unique('sy_insureClassData')->where(function ($query)use($name){
                    return $query->where(['insureName' =>$name,'deleted_at'=>null]);
                })->ignore(@request()->route()->parameters()['insure_class_data'])], [
                    'required' => '保险公司名称必填',
                    'unique'   => '保险公司名称重复',
                ]);

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

                if ($form->isCreating()) {
                    $form->create_by = LOGIN_UID;
                }

                $form->update_by = LOGIN_UID;

            });

            return $form;
        }
    }
