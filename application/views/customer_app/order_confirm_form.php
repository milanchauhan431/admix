<?php $this->load->view('customer_app/includes/header'); ?>
<?php $this->load->view('customer_app/includes/topbar'); ?>

<div class="header header-fixed header-auto-show header-logo-app header-active">
    <a href="#" class="header-title" data-back-button="" >Confirm Order</a>
    <a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
    
</div>
<div class="page-content">
    <form id="orderForm" style="margin-top:65px !important">

    <div class="card card-style">
        <div class="error general_error text-danger"></div>
        <div class="error item_id  text-danger"></div>
        <div class="content">
            <?php
            if(!empty($fgList)){
                foreach($fgList as $row){
                    ?>
                        <div class="d-flex pb-2">
                            <div class="pe-3">
                                <h5 class="font-14 font-700 pb-2"><?=$row->item_name?></h5>
                                <span class="d-block mb-3 mt-n3">Pcs/Box : <?=$row->packing_standard?></span>
                            </div>
                            <div class="ms-auto">
                                <div class=" rounded-s text-center mb-1">
                                    <img src="<?= base_url() ?>assets/customer_app/images/logo.png"  class="shadow-xl" width="70">
                                </div>
                                <!-- <div class="mx-auto"> -->
                                    <div class="stepper rounded-s float-start">
                                        <a href="#" class="stepper-sub"><i class="fa fa-minus color-theme opacity-40"></i></a>
                                        <input type="number" min="1" max="99" value="<?=$itemData[$row->id]['qty']?>" name="qty[]">
                                        <input type="hidden" name="item_id[]" value="<?=$row->id?>">
                                        <a href="#" class="stepper-add"><i class="fa fa-plus color-theme opacity-40"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="divider mt-3"></div>
                    <?php
                }
            }
        ?>
            <div class="row mb-0 mt-4">
                <div class="col-12">
                    <div class="input-style has-borders input-style-always-active no-icon mb-4">
                        <label for="brand_id" class="color-highlight font-500 font-12">Brand</label>
                        <input type="hidden" name="brand_name" id="brand_name" value="">
                        <select id="brand_id" name="brand_id">
                            <option value="">Select Brand</option>
                            <?=getBrandListOption($brandList)?>
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                        <div class="error brand_id text-danger"></div>
                    </div>
                </div>
                <div class="divider mt-4"></div>
                <?php
                    $param = "{'formId':'orderForm','fnsave':'saveOrder','controller':'customerApp/dashboard'}";
                ?>
                <a href="#" class="btn btn-full btn-m rounded-sm bg-highlight font-800 text-uppercase" onclick="store(<?=$param?>)">Confirm & Save</a>
            </div>
        </div>
    </div>

        
    </form>
       
</div>   

    
<?php $this->load->view('customer_app/includes/add_to_home'); ?>
<?php $this->load->view('customer_app/includes/footer'); ?>
<script>
    $(document).ready(function(){
        $(document).on('change','#brand_id',function(){
            if($(this).find(":selected").val() != ""){
                $("#brand_name").val($(this).find(":selected").text());
            }else{
                $("#brand_name").val("");
            }
        });
    });


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
            Swal.fire({
                title: "Success",
                text: data.message,
                icon: "success",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok!"
                }).then((result) => {
                    window.location = base_url + controller;
                });
        }else{
            if(typeof data.message === "object"){
                $(".error").html("");
                $.each( data.message, function( key, value ) {$("."+key).html(value);});
            }else{
                Swal.fire( 'Sorry...!', data.message, 'error' );

                
            }			
        }				
    });
}
  
</script>