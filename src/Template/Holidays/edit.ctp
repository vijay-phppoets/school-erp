<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Holiday $holiday
 */
?>
<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $holiday->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $holiday->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Holidays'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Holidays'), ['controller' => 'Holidays', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Holiday'), ['controller' => 'Holidays', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="holidays form large-9 medium-8 columns content">
    <?= $this->Form->create($holiday) ?>
    <fieldset>
        <legend><?= __('Edit Holiday') ?></legend>
        <?php
            //echo $this->Form->control('holiday_id');
            echo $this->Form->control('date');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" >
                <label > Holiday </label>
            </div>
			<?php $holidaysss=['sunday'=>'Sunday','holiday'=>'Holiday'];?>
            <div class="box-body">
                <div class="form-group">    
                    <?= $this->Form->create($holiday,['id'=>'ServiceForm']) ?>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label"> Select Holiday <span class="required" aria-required="true"> * </span></label>
                                <?php echo $this->Form->control('holidays_name',[
                                'label' => false,'class'=>'form-control','empty'=>'Select...','options' => @$holidaysss,'required'=>true,'vlaue'=>$holiday->holidays_name]);?>
                            </div> 
                            <div class="col-md-6">
                                <label class="control-label"> Date <span class="required" aria-required="true"> * </span></label>
                                <?php echo $this->Form->control('date',[
                                'label' => false,'class'=>'form-control datepicker','placeholder'=>'Date','type'=>'text','data-date-format'=>'dd-mm-yyyy','vlaue'=>$holiday->date]);?>
                            </div>
                        </div>
                        <span class="help-block"></span>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label"> Status <span class="required" aria-required="true"> * </span></label>
                                <?php 
                                    $status[]=['value'=>'N','text'=>'Active'];
                                    $status[]=['value'=>'Y','text'=>'Deactive'];
                                ?>
                                <?= $this->Form->control('is_deleted',array('options' => $status,'class'=>'select2 form-control','label'=>false,'style'=>'width:100%')) ?>
                            </div>
                        <!--    <div class="col-md-8">
                                <label class="control-label"> Description <span class="required" aria-required="true"> * </span></label>
                                <?php //echo $this->Form->control('description',[
                               // 'label' => false,'class'=>'form-control','placeholder'=>'Description','rows'=>2]);?>
                            </div>-->
                        </div>
                         <div class="box-footer">
                            <div class="row">
                                <center>
                                    <div class="col-md-12">
                                        <div class="col-md-offset-3 col-md-6">  
                                            <?php echo $this->Form->button('Submit',['class'=>'btn button','id'=>'submit_member']); ?>
                                        </div>
                                    </div>
                                </center>       
                            </div>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
     
</div>
<?= $this->element('validate') ?> 
<?= $this->element('datepicker') ?> 
<?php
$js='
$(document).ready(function() {
    // validate signup form on keyup and submit
     $("#ServiceForm").validate({ 
        rules: {
            description: {
                required: true
            },
            academic_category_id: {
                required: true
            },
            date: {
                required: true
            }
        },
        submitHandler: function () {
            $("#submit_member").attr("disabled","disabled");
            form.submit();
        }
    }); 

});
';
$this->Html->scriptBlock($js,['block'=>'block_js']);
?>
 