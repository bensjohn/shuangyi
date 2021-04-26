<?php

namespace App\Admin\Controllers;

use App\RepairClassData;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Validation\Rule;

class RepairClassDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '维修厂字典';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RepairClassData());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('repairName', __('维修厂名称'));
        $grid->column('repairAddress', __('维修厂地址'));
        $grid->column('repairManagerName', __('维修厂经理名称'));
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
        $show = new Show(RepairClassData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('repairName', __('维修厂名称'));
        $show->field('repairAddress', __('维修厂地址'));
        $show->field('repairManagerName', __('维修厂经理名称'));
        $show->field('repairManagerTel', __('维修厂经理电话'));
        $show->field('status', __('当前维修厂状态'))->using(['1'=>'合作中',2=>'解除合作']);

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
        $form = new Form(new RepairClassData());

        $name = isset(request()->all()['repairName']) ? request()->all()['repairName'] : '';

        $form->text('repairName', __('维修厂名称'))
             ->creationRules(['required', Rule::unique('sy_repairclassdata')->where(function ($query)use($name){
                 return $query->where(['repairName' =>$name,'deleted_at'=>null]);
             })], [
                 'required' => '维修厂名称必填',
                 'unique'   => '维修厂名称重复',
             ])->updateRules(['required', Rule::unique('sy_repairclassdata')->where(function ($query)use($name){
                return $query->where(['repairName' =>$name,'deleted_at'=>null]);
            })->ignore(@request()->route()->parameters()['repair_class_data'])], [
                'required' => '维修厂名称必填',
                'unique'   => '维修厂名称重复',
            ]);



        $form->text('repairAddress', __('维修厂地址'));
        $form->text('repairManagerName', __('维修厂经理名称'));

        $form->mobile('repairManagerTel', __('维修厂经理电话'));
        $form->select('status', __('当前维修厂状态'))->options(['1'=>'合作中',2=>'解除合作']);

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
