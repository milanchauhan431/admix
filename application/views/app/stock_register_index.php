<?php $this->load->view('app/includes/header');?>

<div class="appHeader bg-primary">
	<div class="left">
		<a href="#" class="headerButton goBack text-white">
			<ion-icon name="chevron-back-outline" role="img" class="md hydrated" aria-label="chevron back outline"></ion-icon>
		</a>
	</div>
	<div class="pageTitle text-white"><?=$headData->pageTitle?></div>
	<div class="right">
		<a href="#" class="headerButton toggle-searchbox text-white">
			<ion-icon name="search-outline" role="img" class="md hydrated searchbtn" aria-label="search outline"></ion-icon>
		</a>
	</div>
</div>
<div id="search" class="appHeader bg-info">
		<div class="form-group searchbox">
			<input type="text" class="form-control quicksearch" placeholder="Search...">
			<i class="input-icon icon ion-ios-search"></i>
			<a href="#" class="ms-1 close toggle-searchbox"><i class="icon ion-ios-close-circle text-white"></i></a>
		</div>
</div>

<!-- Start Main Content -->
<div id="appCapsule" class=" full-height">
	<div class="tab-content mb-1">
		<ul class="listview image-listview media flush no-line list-grid mb-1" data-isotope='{ "itemSelector": ".listItem" }'>
			<?php
				$listRows = '';
				$i = 1;
				if (!empty($srData)) {
					foreach ($srData as $row):
						echo '<li>
									<div class="listItem item transition "  data-category="transition">
										<div class="in ">
											<div>
												<a href="javascript:void(0)" data-postdata = '.json_encode(['item_id'=>$row->item_id]).'  class="headerButton  text-black addNew" data-function="stockTransactions" data-form_title="'.$row->item_name.'" data-button="close" data-modal_id="actionSheetForm"  data-savecontroller="stockTrans">'.$row->item_name.'</a>
											</div>
											<div class="text-end">
                                                <div><h5>'.floatval($row->stock_qty).'</h5></div>
											</div>
										</div>
									</div>
								</li>';
					endforeach;
				}
			?>
			
		</ul>
	</div>
</div>

<!-- End Main Content -->
<?php $this->load->view('app/includes/bottom_menu');?>
<?php $this->load->view('app/includes/sidebar');?>
<?php $this->load->view('app/includes/add_to_home');?>
<?php $this->load->view('app/includes/footer');?>
<script>
$(document).ready(function(){
	var qsRegex;
	var isoOptions = {
		itemSelector: '.listItem',
		layoutMode: 'fitRows',
		filter: function() {return qsRegex ? $(this).text().match( qsRegex ) : true;}
	};
	// init isotope
	var $grid = $('.list-grid').isotope( isoOptions );
	var $qs = $('.quicksearch').keyup( debounce( function() {qsRegex = new RegExp( $qs.val(), 'gi' );$grid.isotope();}, 200 ) );
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

