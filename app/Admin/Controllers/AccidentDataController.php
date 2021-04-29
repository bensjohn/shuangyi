<?php

namespace App\Admin\Controllers;

use App\AccidentData;
use App\CarData;
use App\InsureData;
use App\RepairData;
use App\SyUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AccidentDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '事故记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AccidentData());


        $grid->column('id', __('Id'));
        $grid->column('carData.carNumber', __('车牌号'));
        $grid->column('accidentManagerid_.name', __('负责人'));
        $grid->column('repairData.id', __('维修编号'));
        $grid->column('insureData.insureNumber', __('保单号'));


        $grid->column('accidentDate', __('事故时间'));
        $grid->column('accidentAddress', __('事故地点'));
        $grid->column('dealDate', __('处理时间'));
        $grid->column('repairID', __('维修编号'));
        $grid->column('insureID', __('保险编号'));
        $grid->column('accidentReason', __('事故原因'))->hide();

        $grid->filter(function ($filter) {
            $filter->like('carData.carNumber', '车牌号');
            $filter->like('accidentManagerid_.name', '负责人');
            $filter->like('repairData.id', '维修编号');
            $filter->like('insureData.insureNumber', '保单号');
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
        $show = new Show(AccidentData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('carData', __('车牌号'))->as(function ($content) {
            return @$content->carNumber;
        });

        $show->field('accidentManagerid_', __('负责人'))->as(function ($content) {
            return @$content->name;
        });

        $show->field( 'repairData',__('维修编号'))->as(function ($content) {
            return @$content->id;
        });
        $show->field( 'insureData',__('保单号'))->as(function ($content) {
            return @$content->insureNumber;
        });

        $show->field('accidentDate', __('事故时间'));
        $show->field('accidentAddress', __('事故地点'));
        $show->field('dealDate', __('处理时间'));
        $show->field('accidentReason', __('事故原因'));
        $show->field('spotimage', __('现场照片'))->image();
        $show->field('spotfile', __('现场文件'))->files();


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
        $form = new Form(new AccidentData());


        $data1 = CarData::pluck('carNumber','id')->toArray();
        $data2 = SyUser::pluck('name','id')->toArray();
        $data3 = InsureData::pluck('insureNumber','id')->toArray();
        $data4 = RepairData::pluck('id','id')->toArray();

        $form->select('carID', __('车牌号'))->options($data1);
        $form->select('accidentManagerID', __('负责人'))->options($data2);
        $form->select('insureID', __('保单号'))->options($data3);
        $form->select('repairID', __('维修编号'))->options($data4);

        $form->date('accidentDate', __('事故时间'));
        $form->text('accidentAddress', __('事故地点'));
        $form->date('dealDate', __('处理时间'));
        $form->text('accidentReason', __('事故原因'));


        $form->multipleImage('spotimage', __('现场照片'))->removable()->retainable()->sortable()->uniqueName();
        $form->multipleFile('spotfile', __('现场文件'))->removable()->retainable()->sortable()->uniqueName();
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
