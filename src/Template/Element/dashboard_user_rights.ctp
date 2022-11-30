
<div id="bread">
<ul class="accordion">
<?php
foreach ($menus as $menu) {
   
    	$checked='';
    	if(in_array($menu->id, $userRightsIds))
    	{
    		$checked='checked';
    	}
        ?>
        <li style="margin-top: 5px;"><label>
        	<?= $this->Form->checkbox('dashboard_section_id[]',['value'=>$menu->id,'hiddenField'=>false,'class'=>'menu_check',$checked]).' '.$menu->name; ?></label>
        </li>
        <?php
    
    
}
?>
</ul>
</div>
<div class="box-footer">
    <div class="row">
        <center>
            <div class="col-md-12">
                <div class="col-md-offset-3 col-md-6">  
                    <?php echo $this->Form->button('Submit',['class'=>'btn button submit','id'=>'submit_member']); ?>
                </div>
            </div>
        </center>       
    </div>
</div>
