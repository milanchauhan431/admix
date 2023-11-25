<?php $this->load->view('customer_app/includes/header'); ?>
<?php $this->load->view('customer_app/includes/topbar'); ?>
<div class="header header-fixed header-auto-show header-logo-app header-active">
    <a href="#" class="header-title" data-back-button="" >My Order List</a>
    <a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
    <a href="<?=base_url('customerApp/login/logout')?>" data-menu="menu-highlights" class="header-icon header-icon-2  font-19 font-700"><i class="fas fa-power-off"></i></a>
    <a href="<?=base_url($headData->controller.'/addOrder');?>"  class="header-icon header-icon-3 show-on-theme-light font-19 font-700"><i class="fas fa-plus"></i></a>
    
</div>
<div class="page-content">
    <div style="margin-top:65px !important">
        <?php
        if(!empty($soData)):
            foreach($soData as $row):
                ?>
                <div class="card card-style" > 
                    <div class="content">
                        <div class="d-flex pb-2">
                            <div class="pe-3">
                                <h5 class="font-14 font-700 pb-2"><?=$row->item_name?></h5>
                                <span class="d-block mb-3 mt-n3">So No : <?=$row->trans_number?></span>
                                <span class="d-block mb-3 mt-n3"> Date : <?=formatDate($row->trans_date)?> | Pcs/Box : <?=$row->packing_qty?></span>
                                <span class="d-block mb-3 mt-n3"></span>
                                
                            </div>
                            <div class="ms-auto">
                                <div class=" rounded-s text-center mb-1">
                                    <!-- <img src="<?= base_url() ?>assets/customer_app/images/logo.png"  class="shadow-xl" width="70"> -->
                                    <h5 class="font-14 font-700"  ><?=floatval($row->qty)?></h5>
                                    <h5 class="font-14 font-700 pb-2" >Qty</h5>
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

    
<?php $this->load->view('customer_app/includes/add_to_home'); ?>
<?php $this->load->view('customer_app/includes/footer'); ?>
<script>
function store(postData){
    console.log(postData);
    var formId = postData.formId;
    var fnsave = postData.fnsave || "save";
    var controllerName = postData.controller || controller;

    var form = $('#'+formId)[0];
    var fd = new FormData(form);
    $.ajax({
        url: base_url + controllerName+'/'+fnsave,
        data:fd,
        type: "POST",
        processData:false,
        contentType:false,
        dataType:"json",
    }).done(function(data){
        if(data.status==1){
            $('#'+formId)[0].reset(); 
            $("#DialogIconedSuccess .modal-body").html(data.message);
            $("#DialogIconedSuccess").modal('show');
            window.location.reload();
        }else{
            if(typeof data.message === "object"){
                $(".error").html("");
                $.each( data.message, function( key, value ) {$("."+key).html(value);});
            }else{
                $("#DialogIconedDanger .modal-body").html(data.message);
                $("#DialogIconedDanger").modal('show');
                
            }			
        }				
    });
}
  
</script>