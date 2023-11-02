<?php $this->load->view('includes/header'); ?>
<div class="page-wrapper">
    <div class="container-fluid bg-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title pageHeader"><?=$pageHeader?></h4>
                                <button class="refreshReportData loadData hidden"></button>
                            </div>            
                        </div>                                         
                    </div>
                    <div class="card-body reportDiv" style="min-height:75vh">
                        <div class="table-responsive" style="width: 100%;">
                            <table id='commanTable' class="table table-bordered" style="width:100%;">
								<thead class="thead-info" id="theadData">
                                    <tr class="text-center">
										<th colspan="6"><?=$pageHeader?></th>
									</tr>
									<tr>
										<th class="text-left">Month</th>
										<th>Taxable Amount</th>
                                        <th>IGST Amount</th>
                                        <th>CGST Amount</th>
                                        <th>SGST Amount</th>
                                        <th>Net Amount</th>
									</tr>
								</thead>
								<tbody id="tbody">
								</tbody>
                                <tfoot id="tfoot">
                                    <tr>
                                        <th>Total</th>
                                        <th>0</th>
                                        <th>0</th>
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
    buttons: ['pageLength', 'excel', {text: 'Refresh',action: function (){ $(".refreshReportData").trigger('click'); } }],
    "fnInitComplete":function(){ $('.dataTables_scrollBody').perfectScrollbar(); },
    "fnDrawCallback": function() { $('.dataTables_scrollBody').perfectScrollbar('destroy').perfectScrollbar(); }
};
$(document).ready(function(){
    reportTable('commanTable',tableOption);
	loadData();
    $(document).on('click','.loadData',function(){
		loadData();
	});  
});

function loadData(pdf=""){
	var postData = {};
    $.ajax({
        url: base_url + controller + '/getSalesSummary',
        data: postData,
        type: "POST",
        dataType:'json',
        success:function(data){
            $("#commanTable").DataTable().clear().destroy();
            $("#tbody").html("");
            $("#tbody").html(data.tbody);
            $("#tfoot").html("");
            $("#tfoot").html(data.tfoot);
            reportTable('commanTable',tableOption);
        }
    });
}

</script>