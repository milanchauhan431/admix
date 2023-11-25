<script>
	var base_url = '<?=base_url();?>'; 
	var controller = '<?=(isset($headData->controller)) ? $headData->controller : ''?>'; 
	var popupTitle = '<?=POPUP_TITLE;?>';
	var theads = '<?=(isset($tableHeader)) ? $tableHeader[0] : ''?>';
	var textAlign = '<?=(isset($tableHeader[1])) ? $tableHeader[1] : ''?>';
	var srnoPosition = '<?=(isset($tableHeader[2])) ? $tableHeader[2] : 1?>';
	var tableHeaders = {'theads':theads,'textAlign':textAlign,'srnoPosition':srnoPosition};
	var menu_id = '<?=(isset($headData->menu_id)) ? $headData->menu_id : 0?>';
</script>
<div class="chat-windows"></div>
<!-- Permission Checking -->
<?php
	$script= "";
	// $this->permission->getEmployeeMenusPermission();
	if($permission = $this->session->userdata('emp_permission')):
		if(!empty($headData->pageUrl)):
    		$empPermission = $permission[$headData->pageUrl];
			
    		$script .= '
    			<script>
    				var permissionRead = "'.$empPermission['is_read'].'";
    				var permissionWrite = "'.$empPermission['is_write'].'";
    				var permissionModify = "'.$empPermission['is_modify'].'";
    				var permissionRemove = "'.$empPermission['is_remove'].'";
    				var permissionApprove = "'.$empPermission['is_approve'].'";
    			</script>
    		';
    		echo $script;
		else:
			$script .= '
			<script>
				var permissionRead = "1";
				var permissionWrite = "1";
				var permissionModify = "1";
				var permissionRemove = "1";
				var permissionApprove = "1";
			</script>
		';
		echo $script;
		endif;
	else:
		$script .= '
			<script>
				var permissionRead = "";
				var permissionWrite = "";
				var permissionModify = "";
				var permissionRemove = "";
				var permissionApprove = "";
			</script>
		';
		echo $script;
	endif;
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?= base_url() ?>assets/customer_app/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/customer_app/scripts/custom.js"></script>

<script src="<?=base_url()?>assets/customer_app/plugins/sweet-alert2/sweetalert2.min.js"></script>

