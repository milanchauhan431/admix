<?php $this->load->view('includes/header'); ?>
<div class="page-wrapper">
    <div class="container-fluid bg-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title pageHeader">Item History</h4>
                            </div> 
							<div class="col-md-8">
								<input type="hidden" id="item_id" value="<?=(!empty($itemData))?$itemData->id:""?>">
								<div class="input-group">
									<div class="input-group-append" style="width:18%;">
                                        <select id="unique_id" class="form-control select2">
                                            <option value="">All Brand</option>
                                            <?=getBrandListOption($brandList)?>
                                        </select>
                                    </div>
									<input type="date" id="from_date" class="form-control" value="<?=$from_date?>">
									<input type="date" id="to_date" class="form-control" value="<?=$to_date?>">
									<div class="input-group-append">
										<button type="button" class="btn waves-effect waves-light btn-success float-right refreshReportData loadData" title="Load Data">
											<i class="fas fa-sync-alt"></i> Load
										</button>
									</div>
								</div>
							</div>
						</div>                                   
                    </div>
                    <div class="card-body reportDiv" style="min-height:75vh">
                        <div class="table-responsive">
                            <table id='reportTable' class="table table-bordered">
								<thead class="thead-info" id="theadData">
                                    <tr class="text-center">
                                        <th colspan="5" class="text-left"><?=(!empty($itemData)?$itemData->item_name:'Item History')?></th>
										<th colspan="2" class="text-right">Op. Stock : 0</th>
                                    </tr>
									<tr>
										<th style="min-width:25px;">#</th>
										<th style="min-width:100px;">Trans. Type</th>
										<th style="min-width:100px;">Trans. No.</th>
										<th style="min-width:50px;">Trans. Date</th>
										<th style="min-width:50px;">Inward</th>
										<th style="min-width:50px;">Outward</th>
										<th style="min-width:50px;">Balance</th>
									</tr>
								</thead>
								<tbody id="tbodyData"></tbody>
                                <tfoot class="thead-info" id="tfootData">
									<tr>
										<th colspan="4" class="text-right">Cl. Stock</th>
										<th>0</th>
										<th>0</th>
										<th>0</th>
									</tr>
								</tfoot>
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
	loadData();

    $(document).on('click','.loadData',function(e){
		loadData();
    });   
});

function loadData(){
	$(".error").html("");
	var valid = 1;
	var item_id = $('#item_id').val();
	var unique_id = $('#unique_id').val();
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	
	if(item_id == ""){$(".item_id").html("Item is required.");valid=0;}
	if(from_date == ""){$(".from_date").html("From Date is required.");valid=0;}
	if(to_date == ""){$(".to_date").html("To Date is required.");valid=0;}
	if(from_date > to_date){$(".from_date").html("Invalid Date.");valid=0;}
	
	if(valid){
		$.ajax({
			url: base_url + controller + '/getItemHistory',
			data: {item_id:item_id,unique_id:unique_id,from_date:from_date,to_date:to_date},
			type: "POST",
			dataType:'json',
			success:function(data){
				$("#reportTable").dataTable().fnDestroy();
				$("#theadData").html(data.thead);
				$("#tbodyData").html(data.tbody);
				$("#tfootData").html(data.tfoot);
				reportTable();
			}
		});
	}
}
</script>