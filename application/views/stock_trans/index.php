<?php $this->load->view('includes/header'); ?>
<div class="page-wrapper">
    <div class="container-fluid bg-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
								<a href="<?= base_url($headData->controller."/stockRegister") ?>" class="btn btn-outline-primary">Stock Register</a>
								<a href="<?= base_url($headData->controller) ?>" class="btn btn-outline-primary active">FG Stock Inward</a>
							</div>
                            <div class="col-md-4">
                                <h4 class="card-title text-center">FG Stock Inward</h4>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn waves-effect waves-light btn-outline-primary float-right addNew press-add-btn permission-write" data-button="both" data-modal_id="modal-md" data-function="addStock" data-form_title="Add Stock"><i class="fa fa-plus"></i> Add Stock</button>
                            </div>                             
                        </div>                                         
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id='itemStockTable' class="table table-bordered ssTable" data-url='/getDTRows'></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

<?php $this->load->view('includes/footer'); ?>