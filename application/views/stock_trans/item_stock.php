<?php $this->load->view('includes/header'); ?>
<div class="page-wrapper">
    <div class="container-fluid bg-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
							<div class="col-md-4">
								<a href="<?= base_url($headData->controller."/stockRegister") ?>" class="btn btn-outline-primary active">Stock Register</a>
								<a href="<?= base_url($headData->controller) ?>" class="btn btn-outline-primary">FG Stock Inward</a>
							</div>
                            <div class="col-md-4">
                                <h4 class="card-title text-center"><?=$pageHeader?></h4>
                            </div>       
                            <div class="col-md-4 float-right"> 
								<input type="hidden" id="item_type" value="1" />
								<input type="hidden" id="stock_type" value="1" />  
								<button class="loadData refreshReportData hidden"></button> 
							</div>								
                        </div>                                         
                    </div>
                    <div class="card-body reportDiv" style="min-height:75vh">
                        <div class="table-responsive">
                            <table id='reportTable' class="table table-bordered">
								<thead class="thead-info" id="theadData">
                                    <tr class="text-center">
                                        <th colspan="4">Stock Register</th>
                                    </tr>
									<tr>
										<th class="text-center">#</th>
										<th class="text-left">Item Description</th>
										<th class="text-right">Balance Qty.</th>
										<th class="text-right">Box Qty.</th>
									</tr>
								</thead>
								<tbody id="tbodyData"></tbody>
							</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>


<?php $this->load->view('includes/footer'); ?>
<script>
$(document).ready(function(){
	reportTable();
    setTimeout(function(){$(".loadData").trigger('click');},500);
    
    $(document).on('click','.loadData',function(e){
		$(".error").html("");
		var valid = 1;
		var item_type = $('#item_type').val();
		var stock_type = $('#stock_type').val(); console.log('item_type: '+item_type+' | '+'stock_type: '+stock_type);
		if($("#item_type").val() == ""){$(".item_type").html("Item Type is required.");valid=0;}
		if($("#stock_type").val() == ""){$(".stock_type").html("Stock type is required.");valid=0;}
		if(valid){
            $.ajax({
                url: base_url + 'reports/storeReport/getStockRegisterData',
                data: {item_type:item_type,stock_type:stock_type},
				type: "POST",
				dataType:'json',
				success:function(data){
                    $("#reportTable").DataTable().clear().destroy();
					$("#tbodyData").html(data.tbody);
					reportTable();
                }
            });
        }
    });  

	$(document).on('click', '.stockTransactions', function() {
		var button = "close";
		var item_id = $(this).data("item_id");
		var item_name = $(this).data("item_name");
		
		$.ajax({
			type: "POST",
			url: base_url + 'reports/storeReport/stockTransactions',
			data: {
				item_id: item_id
			}
		}).done(function(response) {
			$("#modal-md").modal();
			$('#modal-md .modal-title').html(item_name);
			$('#modal-md .modal-body').html(response);

			$("#modal-md .modal-footer .btn-close").show();
			$("#modal-md .modal-footer .btn-save").hide();
		});
	});
});


</script>