<style type="text/css">
    .form-control{
        margin-bottom: 5px;
    }
</style>
<?php $student_id = $EncryptingDecrypting->encryptData($students->id); ?> 
<?php $student_info_id = $EncryptingDecrypting->encryptData($studentInfos->id); ?> 
 <?php
if(!empty($fee_type_role_id))
{
    $fee_type_role_ids=$EncryptingDecrypting->encryptData($fee_type_role_id);
}
else
{
    $fee_type_role_ids='';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" >
                <h3 class="box-title" >Fee Deposition Details</h3>
                <div class="box-tools pull-right">
                  <?= $this->Html->link('Student Edit',['controller'=>'Students','action'=>'editStudent',$student_id,'FeeReceipts','monthlyFee',$fee_type_role_ids],['class'=>'btn btn-warning','style'=>'color:#FFF !important;']) ?>
                </div>
            </div>
            <div class="box-body">
            <?= $this->Form->create($feeReceipt,['class'=>'FormSubmit','id'=>'ServiceForm']) ?>
                <?= $this->Form->control('fee_category_id',['label' => false,'type'=>'hidden','value'=>1])?>
                <?php
                if(!empty($fee_type_role_id))
                {
                    echo $this->Form->control('fee_type_role_id',['label' => false,'type'=>'hidden','value'=>$fee_type_role_id]);
                }
                ?>
                <?= $this->element('student_information') ?>
                <table class="table table-bordered table-hover" style="text-align: center;">
                    <thead>
                        <tr>
                            <th class='text-center'>Months</th>
                            <?php
                                $y=0;
                                foreach ($feeMonths as $key => $value) {
                                    echo " <th class='text-center'>".$value->name."</th>";
                                 $y++;
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='text-center'> Fee Component
                                <?= $this->Form->control('check_all', ['type' => 'checkbox','label'=>false,'class'=>'check_all']) ?>
                            </td>
                            <?php
                            $y=0;
                                foreach ($feeMonths as $key => $value) { 
                                $checked=(in_array($value->name,$month_mapping))?'checked':'';
                                echo '<td class="text-center">'.$this->Form->control('dsad', ['type' => 'checkbox','label'=>false,'class'=>'checkDisable','uncheck'=>'removeDisable'.$value->id,'totalAmount'=>'totalAmount'.$value->id,'value'=>$value->id,'checked'=>$checked]).'</td>';
                                $y++;

                                }
                            ?>
                        </tr>
                        <?php
                        $rr=0;
                          foreach ($FeeData as $FeeDatas) {
                            echo"<tr><td>".$FeeDatas->fee_type->name.$this->Form->control('paidornot', ['type' => 'checkbox','label'=>false,'class'=>'rowsCount','checked'=>'checked'])."</td>";
                             $x=0;
                            foreach ($feeMonths as $key => $value) {
                                $checked='';
                                $month_value='';
                                $column=0;
                                $disabled=true;
                                if(in_array($value->name,$month_mapping))
                                {
                                    $checked='checked';
                                    $month_value=$value->id;
                                    $column=1;
                                    $disabled=false;
                                }

                                $FeeAmount = $label_amount = @$FeeDatas->fee_type_master_rows[$x]->amount;
                                $fee_concession_amount=0;
                                if(sizeof($FeeDatas->fee_type_master_rows[$x]->fee_type_student_masters)>0)
                                {
                                    
                                    $FeeAmount = $label_amount = @$FeeDatas->fee_type_master_rows[$x]->fee_type_student_masters[0]->amount;
                                    $fee_concession_amount = @$FeeDatas->fee_type_master_rows[$x]->fee_type_student_masters[0]->concession_amount;
                                    echo $this->Form->control('fee_type_master_rows['.$rr.']['.$x.'][fee_type_student_master_id]',['label' => false,'type'=>'hidden','value'=>@$FeeDatas->fee_type_master_rows[$x]->fee_type_student_masters[0]->id]);
                                }
                                $SubmittedAmount = @$FeeDatas->fee_type_master_rows[$x]->fee_receipt_rows[0]->total_amount;
                                if($SubmittedAmount > 0)
                                {
                                    $FeeAmount=$FeeAmount-$SubmittedAmount;
                                    $fee_concession_amount=0;
                                }
                                else
                                {
                                    $FeeAmount=$FeeAmount-$SubmittedAmount;
                                }
                                
                                echo "
                                    <td>";
                                    echo $this->Form->hidden('fee_type_master_rows['.$rr.']['.$x.'][fee_month_id]', ['type' => 'checkbox','label'=>false,'class'=>'check'.$value->id,'row'=>'1',$checked,'value'=>$month_value]);
                                    echo $this->Form->control('fee_type_master_rows['.$rr.']['.$x.'][fee_type_master_row_id]',['label' => false,'type'=>'hidden','value'=>$FeeDatas->fee_type_master_rows[$x]->id,'row'=>'1']);
                                    echo "
                                    <label>".
                                        $label_amount
                                    ."</label>".
                                    $this->Form->control('fee_type_master_rows['.$rr.']['.$x.'][amount]',[
                                        'label' => false,
                                        'class'=>'form-control amountValid input-small removeDisable'.$value->id,
                                        'placeholder'=>'Amount',
                                        'type'=>'text',
                                        'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",
                                        'column'=>$column,
                                        'row'=>1,
                                        'value'=>$FeeAmount,
                                        'disabled'=>$disabled,
                                        'actualAmount'=>$FeeAmount,
                                        'feeConcessionAmount'=>$fee_concession_amount,
                                        'fee_type_role_id'=>$FeeDatas->fee_type->fee_type_role_id,
                                        'totalAmount'=>'totalAmount'.$value->id,  
                                    ]).
                                    "</td>";
                                $x++;
                            }
                            echo"</tr>";
                            $rr++;
                        }
                        ?>
                         
                        <tr>
                            <td> Total Amount</td>
                            <?php
                                foreach ($feeMonths as $key => $value) { 
                                echo '<td>'.$this->Form->control('tot', ['type' => 'taxt','label'=>false,'class'=>'form-control gross input-small totalAmount'.$value->id,'disabled'=>'disabled']).'</td>';
                                }
                            ?>
                        </tr>
                    </tbody>
                </table>
                <?= $this->element('payment_calculation_monthly') ?>       
                <?= $this->element('payment_detail') ?> 
                      
                <div align="center" class="">
                <?php 
                $id = $EncryptingDecrypting->encryptData($id);
                if(!empty($fee_type_role_id))
                {
                     $fee_type_role_id = $EncryptingDecrypting->encryptData($fee_type_role_id);
                } 
                ?>    
                <?php echo $this->Form->button('Save',['class'=>'btn btn-info submit_fee','type'=>'submit', 'value'=>'save', 'name'=>'save']); ?>
                <?php echo $this->Form->button('Save & Print',['class'=>'btn btn-info submit_fee','type'=>'submit', 'value'=>'print', 'name'=>'save']); ?>
                <?= $this->Html->link(__('Fee Edit'), ['controller' => 'FeeReceipts', 'action' => 'invoiceEdit', $id,$fee_type_role_id],array('escape'=>false,'class'=>'btn btn-warning')) ?>
                
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#FeeDetails">Show Previous Detail</button>
                </div>
            <?= $this->Form->end() ?>             
            </div>
        </div>
    </div>
</div>
<div id="FeeDetails" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Monthly Fee Receipt</h4>
      </div>
      <div class="modal-body">
         <table class="table table-bordered table-hover" id="tab">
            <thead>
                <tr>
                    <th>Recipt No.</th> 
                    <th>Date of Payment</th>
                    <th>Amount Paid</th>
                    <th>Concession</th>
                    <th>Fine</th>
                    <th>Fee Type (Month)</th>
                    <th>Remarks</th> 
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($SubmittedFee as $Submittedlist) {
                    $FeeName=[];
                    foreach ($Submittedlist->fee_receipt_rows as $key => $value) {
                        $FeeName[$value->fee_type_master_row->fee_type_master->fee_type->name][]=$value->fee_month->name;
                    }
                    $receipt_id=$EncryptingDecrypting->encryptData($Submittedlist->id);
                    ?>
                    <tr>
                        <td><?= $Submittedlist->receipt_no ;?></td>
                        <td><?= $Submittedlist->receipt_date ;?></td>
                        <td><?= $Submittedlist->total_amount ;?></td>
                        <td><?= $Submittedlist->concession_amount ;?></td>
                        <td><?= $Submittedlist->fine_amount ;?></td>
                        <td>
                            <?php
                            foreach ($FeeName as $key => $value) {
                                echo $key;
                                echo '(';
                                echo implode(',', $value);
                                echo ')';
                            }
                            ?>
                                
                        </td>
                        <td><?= $Submittedlist->remark ;?></td>
                        <td> 
                            <?= $this->Html->link('<i class="fa fa-print"></i>',['controller'=>'FeeReceipts','action'=>'receiptPrint','FeeReceipts','monthlyFee',$receipt_id,$student_info_id,$fee_type_role_ids],['escape'=>false,'class'=>'btn btn-primary btn-xs']) ?>
                            <a class=" btn btn-danger btn-xs" data-target="#deletemodal<?php echo $Submittedlist->id; ?>" data-toggle=modal><i class="fa fa-trash-o "></i></a>
                            
                        </td>
                    </tr>

                <?php
                }
                ?>
              
            </tbody>
        </table>
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php

foreach ($SubmittedFee as $Submittedlist) { 
   
    $receipt_id=$EncryptingDecrypting->encryptData($Submittedlist->id);
    ?>
<div id="deletemodal<?php echo $Submittedlist->id; ?>" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md" >
            <?= $this->Form->create('from',['url'=>['action'=>'delete','monthlyFee',$receipt_id,$student_info_id,$fee_type_role_ids]]) ?>
            <div class="modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                    Are you sure you want to delete this Receipt?
                    </h4>
                </div>
                <div class="modal-body">
                   <?= $this->Form->control('delete_date', ['type' => 'taxt','class'=>'form-control datepicker  input-small','placeholder'=>'Delete Date','required'=>true,'data-date-format'=>'dd-mm-yyyy'])?>
                   <?= $this->Form->control('remark', ['type' => 'taxt','class'=>'form-control input-small','placeholder'=>'Remarks','required'=>true])?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-sm btn-info">Yes</button>
                    <button type="button" class="btn  btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
         
        <?= $this->Form->end() ?>
    </div>
</div> 
<?php
}?>
<?= $this->element('icheck') ?>
<?= $this->element('validate') ?> 
<?php 
$js="
 $(document).ready(function(){
    $('#ServiceForm').validate({ 
        submitHandler: function () {
            var inputtes = $('.GrossAmount').val();
            if(inputtes != 0 ){
                $('#loading').show();
                $('.submit_fee').attr('disabled','disabled');
                form.submit();
            }
            else
            {
                alert('Invalid Amount');
                return false; 
            }
        }
    });
    $(document).on('ifChanged', '.check_all', function(){
        if($(this).is(':checked')){
            $('.checkDisable').each(function(){
                $(this).attr('checked',true).iCheck({
                    checkboxClass: 'icheckbox_minimal-blue'
                });
                $(this).closest('div').addClass('checked');
                var isClass = $(this).attr('uncheck');
                var value = $(this).val();
                $('.' + isClass).attr('column','1');
                $('.check'+value).attr('checked',true);
                $('.check'+value).attr('value',value);
                removeDisable();
                
            });
        }
        else
        {
            $('.checkDisable').each(function(){
                $(this).attr('checked',false).iCheck({
                    checkboxClass: 'icheckbox_minimal-blue'
                });
                var isClass = $(this).attr('uncheck');
                var value = $(this).val();
                $('.' + isClass).attr('column','0');
                $('.check'+value).attr('checked',false);
                $('.check'+value).removeAttr('value');
                removeDisable();
                
            });
        }
    });
    $(document).on('ifChanged', '.rowsCount', function(){
        var isNow = $(this);
        if($(this).is(':checked')){
            isNow.closest('tr').find('td input').attr('row','1')
        }
        else{
            isNow.closest('tr').find('td input').attr('row','0')
        }
         removeDisable();
    });
    $('.checkDisable').each(function(){
        var isClass = $(this).attr('uncheck');
        var value = $(this).val();
        var obj_cur = $(this);
        var total = 0;
        var amount = 0;
        var Actualamount = 0;
        $('.removeDisable'+value).each(function(){
            amount += parseInt($(this).val());
            Actualamount += parseInt($(this).closest('td').find('label').html());
        });
        
        if(amount==0)
        {
            $('.removeDisable' + value).attr('column','0');
            $('.check'+value).attr('checked',false);
            $('.check'+value).removeAttr('value');
            if(Actualamount > 0)
            {
                obj_cur.attr('checked',true).iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
                });
                obj_cur.closest('div').addClass('checked');
                obj_cur.closest('td').append('<span style=font-weight:bolder;color:#0e0c0c;> Paid</span>');
            }
            else
            {
                obj_cur.attr('checked',false).iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
                });
            }
            
            obj_cur.attr('disabled',true);
            
            removeDisable();
            obj_cur.removeClass('checkDisable');
        }
    });
  
    $(document).on('ifChanged', '.checkDisable', function(){
        var isClass = $(this).attr('uncheck');
        var value = $(this).val();
        if($(this).is(':checked')){
            $('.' + isClass).attr('column','1');
            $('.check'+value).attr('checked',true);
            $('.check'+value).attr('value',value);
        }
        else{
            $('.' + isClass).attr('column','0');
            $('.check'+value).attr('checked',false);
            $('.check'+value).removeAttr('value');
        }
        removeDisable();
    });

    function removeDisable(){
        $('.amountValid').each(function(){
            var column = $(this).attr('column');
            var row = $(this).attr('row');
            if(row == 1 && column == 1){
               $(this).removeAttr('disabled');
            }
            else{
                 $(this).attr('disabled','true');
            }
        });
        calcuteAmount();
    }
    
    calcuteAmount(); 
    function calcuteAmount(){
        var concession_amount_1=0;
        var concession_amount_2=0;
        $('.checkDisable').each(function(){
            var isClass = $(this).attr('uncheck');
            var totalAmount = $(this).attr('totalAmount');
            var total = 0;
            $('.' + isClass).each(function(){
                var column = $(this).attr('column');
                var row = $(this).attr('row');
                var fee_concession_amount =  parseInt($(this).attr('feeConcessionAmount'));
                var fee_type_role_id = $(this).attr('fee_type_role_id');
                if(row == 1 && column == 1){
                    var amount = parseInt($(this).val());
                    total=parseInt(total)+amount;

                    if(fee_type_role_id==1)
                    {
                        concession_amount_1+=fee_concession_amount;
                    }
                    else if(fee_type_role_id==2)
                    {
                        concession_amount_2+=fee_concession_amount;
                    }
                }
            });
            $('.'+totalAmount).val(total);
            $('input[name=concession_amount_1]').val(concession_amount_1);
            $('input[name=concession_amount_2]').val(concession_amount_2);
        });

        grossTotal();
    }

    function grossTotal(){
        var totalAmount=0;
        $('.gross').each(function(){
            var amount = parseInt($(this).val());
            totalAmount=parseInt(totalAmount)+amount;
        });
        $('.GrossAmount').val(totalAmount);
        $('.totalFee').val(totalAmount);
        calAmount();
    }

    $(document).on('keyup', '.amountValid', function(){
        var actualAmount=parseInt($(this).attr('actualAmount'));
        var isClass = $(this).attr('uncheck');
        var totalAmount = $(this).attr('totalAmount');

        var inputted = parseInt($(this).val());
        var total = 0; 
        if( (inputted > actualAmount) || (inputted < 1) || ($(this).val().length == 0)){
            alert('Invalid Amount'); 
            $(this).val(actualAmount);
            calcuteAmount();
        }
        else{
           calcuteAmount(); 
        }
    });
    
     
});
    
";
$this->Html->scriptBlock($js,['block'=>'block_js']);
?>