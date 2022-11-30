<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Holiday[]|\Cake\Collection\CollectionInterface $holidays
 */
?>
<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Holiday'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="holidays index large-9 medium-8 columns content">
    <h3><?= __('Holidays') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('holiday_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($holidays as $holiday): ?>
            <tr>
                <td><?= $this->Number->format($holiday->id) ?></td>
                <td><?= $this->Number->format($holiday->holiday_id) ?></td>
                <td><?= h($holiday->date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $holiday->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $holiday->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $holiday->id], ['confirm' => __('Are you sure you want to delete # {0}?', $holiday->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>-->
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" >
                <label > Holidays </label>
                <div class="box-tools pull-right">
                    <a style="font-size:19px;" class="btn btn-box-tool" data-target="#FilterModel" data-toggle="collapse"> <i class="fa fa-filter"></i></a>
                </div>
            </div>
			<?php $holidaysss=['sunday'=>'Sunday','holiday'=>'Holiday'];?>
            <div class="box-body">
                <?= $this->Form->create('FilterForm',['type'=>'get']) ?>
                <div class="collapse"  id="FilterModel" aria-expanded="false"> 
                    <fieldset style="text-align:left;"><legend>Filter</legend>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Select Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                     <?= $this->Form->control('daterange',['class'=>'form-control pull-left daterangepicker','label'=>false,'placeholder'=>'Date range']) ?> 
                                    </div>    
                                </div> 
                                <div class="col-md-6">
                                    <label class="control-label">Select Category</label>
                                    <?php 
                                    echo $this->Form->control('CID',['options' =>@$holidaysss,'label' => false,'class'=>'select2','empty'=> 'Select...','style'=>'width:100%']);?>     
                                </div> 
                                <div class="col-md-12" align="center">
                                <hr style="margin-top: 12px;margin-bottom: 10px;"></hr>
                                    <!-- <a href="<?php echo $this->Url->build(array('controller'=>'AcademicCalenders','action'=>'index')) ?>"class="btn btn-danger btn-sm">Reset</a> -->
                                    <?php echo $this->Form->button('Apply',['class'=>'btn btn-sm btn-success']); ?>
                                </div> 
                            </div>
                        </div>
                    </fieldset>
                </div>
                <?= $this->Form->end() ?>
            
                <div class="form-group">  
                    <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><?= h('S.No.') ?></th> 
                                <th scope="col"><?= h('Holidays') ?></th>
                               
                                <th scope="col"><?= h('Date') ?></th> 
                                <th scope="col"><?= h('Status') ?></th> 
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $x=0; foreach (@$holidays as $academicCalender): 
							//pr($academicCalender);die;
							?>
                            <tr>
                                <td><?= ++$x ?></td>
                                <td style="text-transform: uppercase;" ><?= $academicCalender->holidays_name ?></td>
                             
                                <td><?= h($academicCalender->date) ?></td> 
                                <td>
                                    <?php 
                                    if ($academicCalender->is_deleted =='Y') {
                                        
                                         echo $this->Form->button('Deactive',['class'=>'btn btn-xs btn-danger']); 
                                    }
                                    elseif($academicCalender->is_deleted =='N')
                                    {
                                       echo $this->Form->button('Active',['class'=>'btn btn-xs btn-success']); 
                                    }
                                    ?>
                                    
                                         
                                     </td>
                                <td class="actions">
                                    <?php $this->Html->link(__('Edit'), ['action' => 'edit', $academicCalender->id],['class'=>'btn btn-sm btn-danger']) ?>

                                    <?= $this->Html->link(__('<i class="fa fa-pencil"></i> '), ['action' => 'edit', $academicCalender->id],['class'=>'btn btn-info btn-xs editbtn','escape'=>false, 'data-widget'=>'Edit', 'data-toggle'=>'tooltip', 'data-original-title'=>'Edit']) ?>

                            
                               
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                 <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('daterangepicker') ?>
