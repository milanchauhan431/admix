<?php $this->load->view('includes/header'); ?>
<div class="page-wrapper">
    <div class="container-fluid bg-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                            <div class="row">   
                                <div class="col-md-4">
                                    <h4 class="card-title pageHeader"><?=$pageHeader?></h4>
                                </div> 	   
                                <div class="col-md-8">                                        
                                    <div class="input-group">
                                        <select name="report_type" id="report_type" class="form-control">
                                            <option value="Receivable" <?=(!empty($report_type) && $report_type == "Receivable")?"selected":""?>>Receivable</option>
                                            <option value="Payable" <?=(!empty($report_type) && $report_type == "Payable")?"selected":""?>>Payable</option>
                                        </select>  
                                        <div class="input-group-append" style="width:30%;">
                                            <select name="party_id" id="party_id" class="form-control select2">
                                                <option value="">All Party</option>
                                                <?=getPartyListOption($partyList)?>
                                            </select>
                                        </div>
                                        <select name="due_type" id="due_type" class="form-control">
                                            <option value="">ALL</option>
                                            <option value="under_due">Under Due</option>
                                            <option value="over_due">Over Due</option>
                                        </select> 
                                        <input type="date" name="due_date" id="due_date" class="form-control" value="<?=getFyDate()?>" />
                                        <div class="input-group-append">
                                            <button type="button" class="btn waves-effect waves-light btn-success float-right refreshReportData loadData" title="Load Data">
    									        <i class="fas fa-sync-alt"></i> Load
    								        </button>
                                        </div>
                                    </div>
                                    <div class="error dueDate"></div>
                                </div>        
                            </div>
                    </div>
                    <div class="card-body reportDiv" style="min-height:75vh">
                        <div class="table-responsive">
                            <table id='commanTable' class="table table-bordered">
								<thead class="thead-info" id="theadData">
									<tr>
										<th>#</th>
										<th>Vou. No.</th>
										<th>Vou. Date</th>
										<th>Party Name</th>
										<th>Contact Number</th>
										<th>Vou. Amount</th>
										<th>Received/Paid Amount</th>
										<th>Due Amount</th>
										<th>Due Date</th>
										<th>Due Days</th>
									</tr>
								</thead>
								<tbody id="tbodyData"></tbody>
								<tfoot class="thead-info" id="tfootData">
								   <tr>
									   <th colspan="5" class="text-right">Total</th>
									   <th>0</th>
									   <th>0</th>
									   <th>0</th>
									   <th></th>
									   <th></th>
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
var tableOption = {
    responsive: true,
    "scrollY": '52vh',
    "scrollX": true,
    deferRender: true,
    scroller: true,
    destroy: true,
    "autoWidth" : false,
    order: [],
    "columnDefs": [
        {type: 'natural',targets: 0},
        {orderable: false,targets: "_all"},
        {className: "text-center",targets: [0, 1]},
        {className: "text-center","targets": "_all"}
    ],
    pageLength: 25,
    language: {search: ""},
    lengthMenu: [
        [ 10, 20, 25, 50, 75, 100, 250,500 ],
        [ '10 rows', '20 rows', '25 rows', '50 rows', '75 rows', '100 rows','250 rows','500 rows' ]
    ],
    dom: "<'row'<'col-sm-7'B><'col-sm-5'f>>" + "<'row'<'col-sm-12't>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: ['pageLength', 'excel',{text: 'Refresh',action: function (){ $(".refreshReportData").trigger('click'); } }],
    "fnInitComplete":function(){ $('.dataTables_scrollBody').perfectScrollbar(); },
    "fnDrawCallback": function() { $('.dataTables_scrollBody').perfectScrollbar('destroy').perfectScrollbar(); }
};
//{ text: 'Pdf',action: function () {loadData('pdf'); } } , 
$(document).ready(function(){
    loadData();
    $(document).on('click','.loadData',function(){
		loadData();
	}); 
});

function loadData(pdf=""){
	$(".error").html("");
	var valid = 1;
	var report_type = $('#report_type').val();
    var party_id = $("#party_id").val();
	var due_type = $('#due_type').val();
	var due_date = $("#due_date").val();

	if($("#due_date").val() == ""){$(".dueDate").html("Due Date is required.");valid=0;}

	var postData = {report_type:report_type,party_id:party_id,due_type:due_type,due_date:due_date};

	if(valid){
        $.ajax({
            url: base_url + controller + '/getDuePaymentReminderData',
            data: postData,
            type: "POST",
            dataType:'json',
            success:function(data){
                $("#commanTable").DataTable().clear().destroy();
                $("#tbodyData").html("");
                $("#tbodyData").html(data.tbody);
                $("#tfootData").html("");
                $("#tfootData").html(data.tfoot);
                reportTable('commanTable',tableOption);
            }
        });
	}
}
</script>