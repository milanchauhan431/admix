<?php $this->load->view('customer_app/includes/header'); ?>
<?php $this->load->view('customer_app/includes/topbar'); ?>
<div class="header header-fixed header-auto-show header-logo-app header-active">
    <a href="#" class="header-title">Admix</a>
    <a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
    <!-- <a href=""  class="header-icon header-icon-2 show-on-theme-dark"><i class="fas fa-plus"></i></a> -->
    <a href="<?=base_url('customerApp/login/logout')?>" data-menu="menu-highlights" class="header-icon header-icon-2 font-19 font-700"  data-menu="menu-main"><i class="fas fa-power-off"></i></a>
    <a href="<?=base_url($headData->controller.'/addOrder');?>"  data-menu="menu-main" class="header-icon header-icon-3 show-on-theme-light font-19 font-700 "><i class="fas fa-plus"></i></a>
    
</div>
<div class="page-content mb-sm-4">
    <div style="margin-top:65px !important">
        <h5 class="ps-4">Pending Orders :</h5>
        <?php
        if(!empty($soData)):
            foreach($soData as $row):
                ?>
                <div class="card card-style" > 
                    <div class="content">
                        <div class="d-flex pb-0">
                            <div class="pe-1">
                                <h5 class="font-14 font-700 pb-2"><?=$row->item_name?></h5>
                                <span class="d-block mb-3 mt-n3">So No : <?=$row->trans_number?></span>
                                <span class="d-block mb-3 mt-n3"> Date : <?=formatDate($row->trans_date)?> | Pcs/Box : <?=$row->packing_qty?></span>
                                
                            </div>
                            <div class="ms-auto">
                                <!-- <div class=" rounded-s text-center mb-1">
                                    <img src="<?= base_url() ?>assets/customer_app/images/logo.png"  class="shadow-xl" width="70">
                                </div> -->
                                <div class="mx-auto">
                                    <div class=" rounded-s text-center">
                                        <h5 class="font-14 font-700"  ><?=floatval($row->qty)?></h5>
                                        <h5 class="font-14 font-700 pb-2" >Qty</h5>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
        ?>
    </div>
    
    
    
</div>
<!-- end of page content-->
    
<?php $this->load->view('customer_app/includes/add_to_home'); ?>
<?php $this->load->view('customer_app/includes/footer'); ?>
