<?php

namespace App\Admin\Controllers;

use App\CarData;
use App\HireData;
use App\InsureData;
use App\SyUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HireDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '租赁记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HireData());

        $grid->column('id', __('Id'));
        $grid->column('carData.carNumber', __('车牌号'));
        $grid->column('userid_.name', __('租赁人'));
        $grid->column('agentid_.name', __('经办人'));
        $grid->column('insureid_.insureNumber', __('保单号'));

        $grid->column('hireType', __('租赁模式'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '月租';
                    break;
                case 2 :
                    $return = '周租';
                    break;
            }
            return $return;
        });

        $grid->column('hireStartDate', __('租赁时间'));
        $grid->column('hireEndDate', __('还车时间'));
        $grid->column('hireEndDate', __('还车时间'));
        $grid->column('hireLongTime', __('租期（月为单位）'));
        $grid->column('hireStartNumber', __('租赁里程数'));
        $grid->column('hireEndNumber', __('还车里程数'));
        $grid->column('hireStatus', __('租赁状态'))->display(function ($text) {
            $return = '';
            switch ($text) {
                case 1 :
                    $return = '租赁中';
                    break;
                case 2 :
                    $return = '租赁完成';
                    break;
            }
            return $return;
        });
        $grid->column('accidentTime', __('出险次数'));
        $grid->column('healthTime', __('保养次数'));
        $grid->column('agentTime', __('经办时间'));
        $grid->column('reamrk', __('备注'))->hide();

        $grid->filter(function ($filter) {
            $filter->like('carData.carNumber', '车牌号');
            $filter->like('userid_.name', '租赁人');
            $filter->like('agentid_.name', '经办人');
            $filter->like('insureid_.insureNumber', '保单号');
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
        $show = new Show(HireData::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('carData', __('车牌号'))->as(function ($content) {
            return @$content->carNumber;
        });

        $show->field('userid_', __('租赁人'))->as(function ($content) {
            return @$content->name;
        });
        $show->field('agentid_', __('经办人'))->as(function ($content) {
            return @$content->name;
        });
        $show->field('insureid_', __('保单号'))->as(function ($content) {
            return @$content->insureNumber;
        });

        $show->field('hireType', __('租赁模式'))->using([1=>'月租',2=>'周租']);

        $show->field('hireStartDate', __('租赁时间'));
        $show->field('hireEndDate', __('还车时间'));
        $show->field('hireLongTime', __('租期（月为单位）'));
        $show->field('hireStartNumber', __('租赁里程数'));
        $show->field('hireEndNumber', __('还车里程数'));
        $show->field('hireStatus', __('租赁状态'))->using([1=>'租赁中',2=>'租赁完成']);
        $show->field('accidentTime', __('出险次数'));
        $show->field('healthTime', __('保养次数'));
        $show->field('agentTime', __('经办时间'));
        $show->field('remark', __('备注'));

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
        $form = new Form(new HireData());

        $data1 = CarData::pluck('carNumber','id')->toArray();
        $data2 = SyUser::pluck('name','id')->toArray();
        $data3 = InsureData::pluck('insureNumber','id')->toArray();

        $form->select('carID', __('车牌号'))->options($data1);
        $form->select('userID', __('租赁人'))->options($data2);
        $form->select('agentID', __('经办人'))->options($data2);
        $form->select('insureID', __('保单号'))->options($data3);


        $form->select('hireType', __('租赁模式'))->options([1=>'月租',2=>'周租']);
        $form->date('hireStartDate', __('租赁时间'));
        $form->date('hireEndDate', __('还车时间'));
        $form->text('hireLongTime', __('租期(月为单位)'));
        $form->text('hireStartNumber', __('租赁里程数'));
        $form->text('hireEndNumber', __('还车里程数'));
        $form->select('hireStatus', __('租赁状态'))->options([1=>'租赁中',2=>'租赁完成']);
        $form->text('accidentTime', __('出险次数'));
        $form->text('healthTime', __('保养次数'));
        $form->date('agentTime', __('经办时间'));
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
