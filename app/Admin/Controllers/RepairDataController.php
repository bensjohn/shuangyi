<?php

namespace App\Admin\Controllers;

use App\CarData;
use App\RepairClassData;
use App\RepairData;
use App\SyUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Log;

class RepairDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '维修记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RepairData());

        $grid->column('id', __('Id'));
        $grid->column('carData.carNumber', __('车牌号'));
        $grid->column('giveCarid_.name', __('送修人'));
        $grid->column('repairClassData.repairName', __('维修厂'));


        $grid->column('repairStartDate', __('维修开始时间'));
        $grid->column('repairEndDate', __('维修结束时间'));
        $grid->column('pickUpCarDate', __('提车时间'));
        $grid->column('enterFactoryDate', __('进场方式'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '拖车';
                    break;
                case 2 :
                    $return = '自驾';
                    break;
            }
            return $return;
        });
        $grid->column('reportContent', __('司机报备内容'));
        $grid->column('checkResultClass', __('检测结果类型'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '司机';
                    break;
                case 2 :
                    $return = '公司';
                    break;
            }
            return $return;
        });
        $grid->column('checkContent', __('检测内容'))->hide();
        $grid->column('repairContent', __('维修内容'))->hide();
        $grid->column('materialCost', __('材料费'));
        $grid->column('repairContent', __('人工费'));
        $grid->column('otherCost', __('其他费用'));
        $grid->column('totalCost', __('总计费用'));
        $grid->column('remark', __('备注'))->hide();
        $grid->column('leaveFactoryDate', __('预计出厂时间'));



        $grid->filter(function ($filter) {

            $filter->like('carData.carNumber', '维修车辆车牌号');
            $filter->like('giveCarid_.name', '送修人');
            $filter->like('repairClassData.repairName', '维修厂');
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
        $show = new Show(RepairData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('carData', __('维修车辆车牌号'))->as(function ($content) {
            return @$content->carNumber;
        });

        $show->field('giveCarid_', __('送修人'))->as(function ($content) {
            return @$content->name;
        });

        $show->field('repairClassData', __('维修厂'))->as(function ($content) {
            return @$content->repairName;
        });

        $show->field('repairStartDate', __('维修开始时间'));
        $show->field('repairEndDate', __('维修结束时间'));
        $show->field('pickUpCarDate', __('提车时间'));
        $show->field('enterFactoryDate', __('进场方式'))->using(['1'=>'拖车',2=>'自驾']);
        $show->field('reportContent', __('司机报备内容'));
        $show->field('checkResultClass', __('检测结果类型'))->using(['1'=>'司机',2=>'公司']);

        $show->field('checkContent', __('检测内容'));
        $show->field('repairContent', __('维修内容'));
        $show->field('materialCost', __('材料费'));
        $show->field('peopleCost', __('人工费'));
        $show->field('repairimage', __('维修照片'))->image();
        $show->field('repairfile', __('维修文件'))->files();

        $show->field( 'otherCost',__('其他费用'));
        $show->field( 'totalCost',__('总计费用'));
        $show->field( 'leaveFactoryDate',__('预计出厂时间'));
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
        $form = new Form(new RepairData());

        $data1 = CarData::pluck('carNumber','id')->toArray();
        $data2 = SyUser::pluck('name','id')->toArray();
        $data3 = RepairClassData::pluck('repairName','id')->toArray();

        $id = @request()->route()->parameters()['repair_data'];
        $data = @RepairData::where(['id'=>$id])->first();

        if ($data && $data->carID){
            $form->select('carID', __('车牌号'))->options($data1)->readOnly();
        }else{
            $form->select('carID', __('车牌号'))->options($data1);
        }

        if ($data && $data->giveCarID){
            $form->select('giveCarID', __('送修人'))->options($data2)->readOnly();
        }else{
            $form->select('giveCarID', __('送修人'))->options($data2);
        }


        if ($data && $data->repairID){

            $form->select('repairID', __('维修厂'))->options($data3)->readOnly();
        }else{

            $form->select('repairID', __('维修厂'))->options($data3);
        }


        if ($data && $data->repairStartDate){

            $form->date('repairStartDate', __('维修开始时间'))->readOnly();
        }else{

            $form->date('repairStartDate', __('维修开始时间'));
        }

        if ($data && $data->repairEndDate){

            $form->date('repairEndDate', __('维修结束时间'))->readOnly();
        }else{

            $form->date('repairEndDate', __('维修结束时间'));
        }

        if ($data && $data->pickUpCarDate){

            $form->date('pickUpCarDate', __('提车时间'))->readOnly();
        }else{
            $form->date('pickUpCarDate', __('提车时间'));

        }


        if ($data && $data->enterFactoryDate){

            $form->select('enterFactoryDate', __('进场方式'))->options(['1'=>'拖车',2=>'自驾'])->readOnly();
        }else{
            $form->select('enterFactoryDate', __('进场方式'))->options(['1'=>'拖车',2=>'自驾']);

        }

        if ($data && $data->reportContent){

            $form->text('reportContent', __('司机报备内容'))->readOnly();
        }else{
            $form->text('reportContent', __('司机报备内容'));

        }


        if ($data && $data->checkResultClass){

            $form->select('checkResultClass', __('检测结果类型'))->options(['1'=>'司机',2=>'公司'])->readOnly();
        }else{
            $form->select('checkResultClass', __('检测结果类型'))->options(['1'=>'司机',2=>'公司']);

        }

        if ($data && $data->checkContent){

            $form->text('checkContent', __('检测内容'))->readOnly();
        }else{
            $form->text('checkContent', __('检测内容'));

        }

        if ($data && $data->repairContent){

            $form->text('repairContent', __('维修内容'))->readOnly();
        }else{
            $form->text('repairContent', __('维修内容'));

        }

        if ($data && $data->materialCost){

            $form->text('materialCost', __('材料费'))->readOnly();
        }else{
            $form->text('materialCost', __('材料费'));

        }

        if ($data && $data->peopleCost){

            $form->text('peopleCost', __('人工费'))->readOnly();
        }else{

            $form->text('peopleCost', __('人工费'));
        }

        if ($data && $data->repairimage && (@$data->repairimage[0] || @$data->repairimage[1])){

            $form->multipleImage('repairimage', __('维修照片'))->readOnly();
        }else{

            $form->multipleImage('repairimage', __('维修照片'))->removable()->retainable()->sortable()->uniqueName();
        }

        if ($data && $data->repairfile && (@$data->repairfile[0] || @$data->repairfile[1])){

            $form->multipleFile('repairfile', __('维修文件'))->readOnly();
        }else{

            $form->multipleFile('repairfile', __('维修文件'))->removable()->retainable()->sortable()->uniqueName();
        }

        if ($data && $data->otherCost){

            $form->text('otherCost', __('其他费用'))->readOnly();
        }else{
            $form->text('otherCost', __('其他费用'));

        }

        if ($data && $data->totalCost){
            $form->text('totalCost', __('总计费用'))->readOnly();

        }else{
            $form->text('totalCost', __('总计费用'));

        }

        if ($data && $data->leaveFactoryDate){

            $form->date('leaveFactoryDate', __('预计出厂时间'))->readOnly();
        }else{
            $form->date('leaveFactoryDate', __('预计出厂时间'));

        }

        if ($data && $data->remark){

            $form->text('remark', __('备注'))->readOnly();
        }else{

            $form->text('remark', __('备注'));
        }

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
