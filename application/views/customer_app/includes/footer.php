    
</div>    

<!-- DialogIconedSuccess -->
<div class="modal fade dialogbox " id="DialogIconedSuccess" data-bs-backdrop="static" tabindex="-1"
	role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-icon text-success">
				<ion-icon name="checkmark-circle"></ion-icon>
			</div>
			<div class="modal-header">
				<h5 class="modal-title">Success</h5>
			</div>
			<div class="modal-body">
				Your payment has been sent.
			</div>
			<div class="modal-footer">
				<div class="btn-inline">
					<a href="#" class="btn btn-outline-cyan" data-bs-dismiss="modal">CLOSE</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <div id="DialogIconedSuccess" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="305" data-menu-effect="menu-over" style="display: block; height: 305px;">
	<h1 class="text-center mt-4"><i class="fa fa-3x fa-check-circle color-green-dark"></i></h1>
	<h1 class="text-center mt-3 text-uppercase font-700">All's Good</h1>
	<p class="boxed-text-l">
			You can continue with your previous actions.<br> Easy to attach these to success calls.
	</p>
	<a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green-light">Great</a>
</div> -->
<!-- * DialogIconedSuccess -->

<!-- DialogIconedDanger -->
<div class="modal fade dialogbox" id="DialogIconedDanger" data-bs-backdrop="static" tabindex="-1" role="dialog"  style="z-index: 9999!important">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-icon text-danger">
				<ion-icon name="close-circle"></ion-icon>
			</div>
			<div class="modal-header">
				<h5 class="modal-title">Error</h5>
			</div>
			<div class="modal-body">
				There is something wrong.
			</div>
			<div class="modal-footer">
				<div class="btn-inline">
					<a href="#" class="btn" data-bs-dismiss="modal">CLOSE</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('customer_app/includes/footerfiles');?>
</body>