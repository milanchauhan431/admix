<?php $this->load->view('includes/header'); ?>
<div class="page-wrapper">
    <div class="container-fluid bg-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="card-title pageHeader"><?=$pageHeader?></h4>
                            </div>       
                            <div class="col-md-9 float-right">  
                                <div class="input-group">
                                    <div class="input-group-append" style="width:20%;">
                                        <select id="item_type" class="form-control select2">
                                            <?php
                                                foreach($this->itemTypes as $type=>$typeName):
                                                    echo '<option value="'.$type.'">'.$typeName.'</option>';
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group-append" style="width:18%;">
                                        <select id="unique_id" class="form-control select2">
                                            <option value="">All Brand</option>
                                            <?=getBrandListOption($brandList)?>
                                        </select>
                                    </div>
                                    <div class="input-group-append" style="width:18%;">
                                        <select id="stock_type" class="form-control select2" >
                                            <option value="0">ALL</option>
                                            <option value="1">With Stock</option>
                                            <option value="2">Without Stock</option>
                                        </select>
                                    </div>
                                    <input type="date" id="from_date" class="form-control" value="<?=$from_date?>">
                                    <input type="date" id="to_date" class="form-control" value="<?=$to_date?>">
                                    <button type="button" class="btn waves-effect waves-light btn-success refreshReportData loadData" title="Load Data">
                                        <i class="fas fa-sync-alt"></i> Load
                                    </button>
                                </div>
                                <div class="error stock_type"></div>
                            </div>                  
                        </div>                                         
                    </div>
                    <div class="card-body reportDiv" style="min-height:75vh">
                        <div class="table-responsive">
                            <table id='reportTable' class="table table-bordered">
								<thead class="thead-info" id="theadData">
                                    <tr class="text-center">
                                        <th colspan="7">Stock Register</th>
                                    </tr>
									<tr>
										<th class="text-center">#</th>
										<th class="text-left">Item Description</th>
										<th class="text-right">Op. Qty.</th>
										<th class="text-right">In Qty.</th>
										<th class="text-right">Out Qty.</th>
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
		var stock_type = $('#stock_type').val();
		var unique_id = $('#unique_id').val();
        var from_date = $('#from_date').val();
	    var to_date = $('#to_date').val();

		if($("#item_type").val() == ""){$(".item_type").html("Item Type is required.");valid=0;}
		if($("#stock_type").val() == ""){$(".stock_type").html("Stock type is required.");valid=0;}
        if(from_date == ""){$(".from_date").html("From Date is required.");valid=0;}
        if(to_date == ""){$(".to_date").html("To Date is required.");valid=0;}
        if(from_date > to_date){$(".from_date").html("Invalid Date.");valid=0;}

		if(valid){
            $.ajax({
                url: base_url + controller + '/getStockRegisterData',
                data: {item_type:item_type,stock_type:stock_type,unique_id:unique_id,from_date:from_date,to_date:to_date},
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
			url: base_url + controller + '/stockTransactions',
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