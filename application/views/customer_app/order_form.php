<?php $this->load->view('customer_app/includes/header'); ?>
<?php $this->load->view('customer_app/includes/topbar'); ?>

<div class="header header-fixed header-auto-show header-logo-app header-active">
    <a href="#" data-back-button="" class="header-title ">Back</a>
    <?php
    $param = "{'formId':'orderForm','fnsave':'confirmOrder','controller':'customerApp/dashboard'}";
    ?>
    <a href="#"  class="header-icon header-icon-2 show-on-theme-light font-19 font-700" onclick="store(<?=$param?>)"><i class="fas fa-check"></i></a>
</div>

<div class="page-content">
    
    <form id="orderForm"  style="margin-top:65px !important">
        <p><input type="text" class="quicksearch form-control" placeholder="Search" /></p>
       
        <div class="error general_error text-danger ps-3"></div>
        <div class="listview image-listview media flush no-line list-grid mb-1" data-isotope='{ "itemSelector": ".listItem" }'>
            <?php
            if(!empty($fgList)){
                foreach($fgList as $row){
                    ?>
                        <div class="listItem item transition card card-style "  data-category="transition">
                            <div class="content">
                                <div class="d-flex pb-2">
                                    <div class="pe-3">
                                        <h5 class="font-14 font-700 pb-2"><?=$row->item_name?></h5>
                                        <span class="d-block mb-3 mt-n3">Pcs/Box : <?=$row->packing_standard?></span>
                                        
                                    </div>
                                    <div class="ms-auto">
                                        <div class="stepper rounded-s float-start">
                                            <a href="#" class="stepper-sub"><i class="fa fa-minus color-theme opacity-40"></i></a>
                                            <input type="number" min="1" max="99" value="0" name="qty[]" data-item_id ="<?=$row->id?>" >
                                            <input type="hidden" name="item_id[]" value="<?=$row->id?>">
                                            <a href="#" class="stepper-add"><i class="fa fa-plus color-theme opacity-40"></i></a>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            }
            ?>
        </div>
       
    </form>
       
</div>   

    
<?php $this->load->view('customer_app/includes/add_to_home'); ?>
<?php $this->load->view('customer_app/includes/footer'); ?>
<script src="<?= base_url() ?>assets/app/js/lib/isotop/isotope.pkgd.min.js"></script>
<script>
function store(postData){
    console.log(postData);
    var formId = postData.formId;
    var fnsave = postData.fnsave || "save";
    var controllerName = postData.controller || controller;

    // var form = $('#orderForm')[0];
    // var fd = new FormData(form);
    var itemArray = [];
    var batchQtyArr = $("input[name='qty[]']").map(function(){
        var qty = parseFloat($(this).val());

        if(qty > 0){
            var item_id = $(this).data('item_id');
            itemArray.push({'qty':qty,'item_id':item_id});
        }
    })
    console.log(itemArray);
    if(itemArray.length === 0){
        $(".general_error").html("Select Item");
    }else{
        var url =  base_url + controller + '/confirmOrder/' + encodeURIComponent(window.btoa(JSON.stringify(itemArray)));
        window.open(url,'_self');
       
    }
    
}

$(document).ready(function(){
	var qsRegex;
	var isoOptions = {
		itemSelector: '.listItem',
		layoutMode: 'fitRows',
		filter: function() {return qsRegex ? $(this).text().match( qsRegex ) : true;}
	};
	// init isotope
	var $grid = $('.listview').isotope( isoOptions );
	var $qs = $('.quicksearch').keyup( debounce( function() {qsRegex = new RegExp( $qs.val(), 'gi' );$grid.isotope();}, 200 ) );

// $(document).on('keyup',".quicksearch",function(){console.log($(this).val());});
});

function searchItems(ele){
	console.log($(ele).val());
}

function debounce( fn, threshold ) {
  var timeout;
  threshold = threshold || 100;
  return function debounced() {
	clearTimeout( timeout );
	var args = arguments;
	var _this = this;
	function delayed() {fn.apply( _this, args );}
	timeout = setTimeout( delayed, threshold );
  };
}
</script>