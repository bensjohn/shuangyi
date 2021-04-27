<?php

namespace App\Admin\Controllers;

use App\InsureClassData;
use App\InsureData;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Validation\Rule;

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
        $grid->column('InsureClassData.name', __('保险字典名称'));
        $grid->column('insureNumber', __('保单号'));
        $grid->column('insureStartDate', __('保险起保时间'));
        $grid->column('insureEndDate', __('保险停保时间'));
        $grid->column('insureCost', __('保险费用'));

        $grid->column('insureClass', __('保险类型'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '强险';
                    break;
                case 2 :
                    $return = '商业险';
                    break;
            }
            return $return;
        });


        $grid->filter(function ($filter) {

            // 设置created_at字段的范围查询
            $filter->like('insureNumber', '保单号');
            $filter->like('InsureClassData.name', '保险字典名称');
        });

        $grid->column('remark', __('创建人'))->备注();
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

        $show->field('id', __('Id'));
        $show->field('InsureClassData', __('保险字典名称'))->as(function ($content) {
            return @$content->name;
        });

        $show->field('insureNumber', __('保单号'));
        $show->field('insureStartDate', __('保险起保时间'));
        $show->field('insureEndDate', __('保险停保时间'));
        $show->field('insureCost', __('保险费用'));
        $show->field('insureClass', __('保险类型'))->using(['1'=>'强险',2=>'商业险']);
        $show->field('remark', __('备注'));
        $show->insureFile( __('保险文件和图片'))->as(function ($content) {
            $img = '';
            foreach (json_decode($content,true) as $v){
                $img .= public_path('/uploads/'.$v);
            }
            return $img;
        })->image();

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
        $form = new Form(new InsureData());

        $name = isset(request()->all()['insureNumber']) ? request()->all()['insureNumber'] : '';
        $upperData = InsureClassData::pluck('name','id')->toArray();

        $form->select('insureDataID', __('保险字典名称'))->options($upperData);

        $form->text('insureNumber', __('保单号'))
             ->creationRules(['required', Rule::unique('sy_insuredata')->where(function ($query)use($name){
                 return $query->where(['insureNumber' =>$name,'deleted_at'=>null]);
             })], [
                 'required' => '保单号必填',
                 'unique'   => '保单号重复',
             ])->updateRules(['required', Rule::unique('sy_insuredata')->where(function ($query)use($name){
                return $query->where(['insureNumber' =>$name,'deleted_at'=>null]);
            })->ignore(@request()->route()->parameters()['insure_data'])], [
                'required' => '保单号必填',
                'unique'   => '保单号重复',
            ]);



        $form->date('insureStartDate', __('保险起保时间'));
        $form->date('insureEndDate', __('保险停保时间'));

        $form->text('insureCost', __('保险费用'));
        $form->select('insureClass', __('保险类型'))->options(['1'=>'强险',2=>'商业险']);
        $form->text('remark', __('备注'));
        $form->multipleFile('insureFile', __('保险文件或者图片'))->removable()->retainable();

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
