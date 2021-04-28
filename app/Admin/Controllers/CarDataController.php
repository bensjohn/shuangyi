<?php

namespace App\Admin\Controllers;

use App\carClassData;
use App\CarData;
use App\InsureData;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Validation\Rule;

class CarDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '车辆基本信息';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CarData());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('carClassData.carName', __('车辆字典'));
        $grid->column('InsureData.insureNumber', __('保险序号'));
        $grid->column('carNumber', __('车牌号'));
        $grid->column('engineNumber', __('发动机号'));
        $grid->column('carFrameNumber', __('车架号'));
        $grid->column('insureID', __('保险序号'));
        $grid->column('carStatus', __('当前车辆状态'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '在库';
                    break;
                case 2 :
                    $return = '出库';
                    break;
            }
            return $return;
        });
        $grid->column('shoeNum', __('轮胎编码'));
        $grid->column('shoeSpecs', __('轮胎规格'));
        $grid->column('powerType', __('动力类型'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '燃油';
                    break;
                case 2 :
                    $return = '纯电';
                    break;
                case 3 :
                    $return = '油电混合';
                    break;
            }
            return $return;
        });
        $grid->column('yearCheckDate', __('年检日期'));
        $grid->column('keySum', __('车钥匙数量'));
        $grid->column('isSend', __('车辆行驶证是否已经发出'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 0 :
                    $return = '否';
                    break;
                case 1 :
                    $return = '是';
                    break;
            }
            return $return;
        });


        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->like('carClassData.carName', '车辆字典名称');
            $filter->like('InsureData.insureNumber', '保单号');
        });

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
            $filter->like('carNumber', '车牌号');
            $filter->like('carClassData.carName', '车辆字典名称');
            $filter->like('InsureClassData.insureNumber', '保险字典保单号');
        });

        $grid->column('remark', __('备注'))->hide();
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
        $show = new Show(CarData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('carClassData', __('车辆字典名称'))->as(function ($content) {
            return @$content->carName;
        });

        $show->field('InsureData', __('保单号'))->as(function ($content) {
            return @$content->insureNumber;
        });

        $show->field('engineNumber', __('发动机号'));
        $show->field('carFrameNumber', __('车架号'));
        $show->field('carStatus', __('当前车辆状态'))->using(['1'=>'在库',2=>'出库']);
        $show->field('shoeNum', __('轮胎编码'));
        $show->field('shoeSpecs', __('轮胎规格'));
        $show->field('powerType', __('动力类型'))->using(['1'=>'燃油',2=>'纯电',3=>'油电混合']);
        $show->field('yearCheckDate', __('年检日期'));
        $show->field('yearCheckDate', __('年检日期'));
        $show->field('keySum', __('车钥匙数量'));
        $show->field('isSend', __('车辆行驶证是否已经发出'))->using(['0'=>'否',1=>'是']);

        $show->field( 'xszfile',__('行驶证照片'))->image();
        $show->field( 'carfile',__('车辆照片'))->image();
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
        $form = new Form(new CarData());

        $name = isset(request()->all()['carNumber']) ? request()->all()['carNumber'] : '';
        $upperData = InsureData::pluck('insureNumber','id')->toArray();

        $form->select('insureID', __('保单号'))->options($upperData);

        $upperData2 = carClassData::pluck('carName','id')->toArray();

        $form->select('carClassID', __('车辆字典名称'))->options($upperData2);

        $form->text('carNumber', __('车牌号'))
             ->creationRules(['required', Rule::unique('sy_cardata')->where(function ($query)use($name){
                 return $query->where(['carNumber' =>$name,'deleted_at'=>null]);
             })], [
                 'required' => '车牌号必填',
                 'unique'   => '车牌号重复',
             ])->updateRules(['required', Rule::unique('sy_cardata')->where(function ($query)use($name){
                return $query->where(['carNumber' =>$name,'deleted_at'=>null]);
            })->ignore(@request()->route()->parameters()['car_data'])], [
                'required' => '车牌号必填',
                'unique'   => '车牌号重复',
            ]);

        $form->text('engineNumber', __('发动机号'));
        $form->text('carFrameNumber', __('车架号'));
        $form->select('carStatus', __('当前车辆状态'))->options(['1'=>'在库',2=>'出库']);
        $form->text('shoeNum', __('轮胎编码'));
        $form->text('shoeSpecs', __('轮胎规格'));
        $form->select('powerType', __('动力类型'))->options(['1'=>'燃油',2=>'纯电',3=>'油电混合']);
        $form->date('yearCheckDate', __('年检日期'));
        $form->number('keySum', __('车钥匙数量'));
        $form->select('isSend', __('车辆行驶证是否已经发出'))->options(['0'=>'否',1=>'是']);

        $form->multipleImage('xszfile', __('行驶证照片'))->removable()->retainable()->sortable()->uniqueName();
        $form->multipleImage('carfile', __('车辆照片'))->removable()->retainable()->sortable()->uniqueName();
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
