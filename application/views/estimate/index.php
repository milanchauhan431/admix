<?php $this->load->view('includes/header'); ?>
<div class="page-wrapper">
    <div class="container-fluid bg-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"> 
                                        <a href="<?=base_url("estimate")?>" class="btn btn-outline-info waves-effect waves-light">Estimate</a>
                                    </li>
                                    <li class="nav-item"> 
                                        <a href="<?=base_url("estimate/ledger")?>" class="btn btn-outline-success waves-effect waves-light">Estimate Ledger</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 text-center">
                                <h4 class="card-title">Estimate</h4>
                            </div>
                            <div class="col-md-4">
                                <a href="javascript:void(0)" class="btn waves-effect waves-light btn-outline-primary float-right permission-write press-add-btn" onclick="window.location.href='<?=base_url($headData->controller.'/addEstimate')?>'"><i class="fa fa-plus"></i> Add Estimate</a>
                            </div>                             
                        </div>                                         
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id='estimateTable' class="table table-bordered ssTable" data-url='/getDTRows'></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>