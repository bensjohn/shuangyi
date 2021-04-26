<?php

namespace App\Admin\Controllers;

use App\carClassData;
use App\UpDataList;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Validation\Rule;

class carClassDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '车辆字典';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new carClassData());
        $grid->column('id', __('Id'))->sortable();
        $grid->column('upDataList.upperName', __('上游名称'));
        $grid->column('carRegisterDate', __('车辆注册日期'));
        $grid->column('carFactory', __('汽车厂家'));
        $grid->column('carBrand', __('车辆品牌'));
        $grid->column('carName', __('车辆名称'));
        $grid->column('carModel', __('车辆型号'));
        $grid->column('carClass', __('车辆类型'));
        $grid->column('carColor', __('车辆颜色'));
        $grid->column('status', __('车辆使用性质'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '营运';
                    break;
                case 2 :
                    $return = '非营运';
                    break;
                case 3 :
                    $return = '租赁';
                    break;
            }
            return $return;
        });;


        $grid->filter(function ($filter) {

            $filter->like('upDataList.upperName', '上游名称');
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
        $show = new Show(carClassData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('upDataList', __('上游名称'))->as(function ($content) {
            return @$content->upperName;
        });
        $show->field('carRegisterDate', __('车辆注册日期'));
        $show->field('carFactory', __('汽车厂家'));
        $show->field('carBrand', __('车辆品牌'));
        $show->field('carName', __('车辆名称'));
        $show->field('carModel', __('车辆型号'));
        $show->field('carClass', __('车辆类型'));
        $show->field('carColor', __('车辆颜色'));
        $show->field('status', __('车辆使用性质'))->using([1 => '营运', 2 => '非营运',3=>'租赁']);


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
        $form = new Form(new carClassData());

        $name = isset(request()->all()['carName']) ? request()->all()['carName'] : '';
        $upperData = UpDataList::pluck('upperName','id')->toArray();

        $form->select('upperID', __('上游名称'))->options($upperData);

        $form->text('carName', __('车辆名称'))
             ->creationRules(['required', Rule::unique('sy_carclassdata')->where(function ($query)use($name){
                 return $query->where(['carName' =>$name,'deleted_at'=>null]);
             })], [
                 'required' => '车辆名称必填',
                 'unique'   => '车辆名称重复',
             ])->updateRules(['required', Rule::unique('sy_carclassdata')->where(function ($query)use($name){
                return $query->where(['carName' =>$name,'deleted_at'=>null]);
            })->ignore(@request()->route()->parameters()['car_class_data'])], [
                'required' => '车辆名称必填',
                'unique'   => '车辆名称重复',
            ]);



        $form->date('carRegisterDate', __('车辆注册日期'));
        $form->text('carFactory', __('汽车厂家'));
        $form->text('carBrand', __('车辆品牌'));
        $form->text('carModel', __('车辆型号'));
        $form->text('carClass', __('车辆类型'));
        $form->text('carColor', __('车辆颜色'));
        $form->select('status', __('车辆使用性质'))->options([
            1 => '营运',
            2 => '非营运',
            3 => '租赁',
        ]);


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
