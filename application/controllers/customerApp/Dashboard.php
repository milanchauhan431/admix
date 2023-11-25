<?php
class Dashboard extends MY_Controller{
	
	public function __construct()	{
		parent::__construct();
		$this->isLoggedin();
		$this->data['headData']->pageTitle = "Dashboard";
		$this->data['headData']->controller = "customerApp/dashboard";
		
        $this->data['entryData'] = $this->transMainModel->getEntryType(['controller'=>'salesOrders']);
	}
	
	public function index(){
		$this->data['headData']->menu_id = 0;
		$this->data['soData'] = $this->salesOrder->getPendingOrderItems(['party_id'=>$this->partyId]);
		$this->load->view('customer_app/dashboard',$this->data);
	}
	
	

	public function changePassword(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['old_password']))
            $errorMessage['old_password'] = "Old Password is required.";
        if(empty($data['new_password']))
            $errorMessage['new_password'] = "New Password is required.";
        if(empty($data['cpassword']))
            $errorMessage['cpassword'] = "Confirm Password is required.";
        if(!empty($data['new_password']) && !empty($data['cpassword'])):
            if($data['new_password'] != $data['cpassword'])
                $errorMessage['cpassword'] = "Confirm Password and New Password is Not match!.";
        endif;

        if(!empty($errorMessage)):
			$this->printJson(['status'=>0,'message'=>$errorMessage]);
		else:
            $id = $this->session->userdata('loginId');
			$result =  $this->dashboard->changePassword($id,$data);
			$this->printJson($result);
		endif;
    }

	public function addOrder(){
		$this->data['headData']->menu_id = 0;
		$this->data['fgList'] = $this->item->getItemList(['item_type'=>1]);
		$this->load->view('customer_app/order_form',$this->data);
	}

	public function confirmOrder($jsonData=""){
		$this->data['headData']->menu_id = 0;
        $postData = (Array) decodeURL($jsonData);
		$itemData = [];$ids = [];
		foreach($postData as $row){
			if($row->qty > 0){
				$itemData[$row->item_id]['qty'] = $row->qty;
				$ids[]=$row->item_id;
			}
		}
		if(empty($itemData))
			$errorMessage['general_error'] = "Item Details is required.";
		
		if(!empty($errorMessage)):
			$this->printJson(['status'=>0,'message'=>$errorMessage]);
		else:
			$this->data['fgList'] = $this->item->getItemList(['item_type'=>1,'ids'=>$ids]); 
			$this->data['itemData'] =$itemData; 
			$this->data['brandList'] = $this->brandMaster->getBrandList();
			$this->load->view('customer_app/order_confirm_form',$this->data);
		endif;
	}
	
	public function saveOrder(){
		$postData = $this->input->post(); 
        $errorMessage = array();
		$itemData = [];
		$partyData = $this->party->getParty(['id'=>$this->partyId]);
		if(empty($this->partyId))
			$errorMessage['general_error'] = "Customer Login Required";
		$totalAmount = 0;$totalTaxableAmount=0;$totalNetAmount=0;
		foreach($postData['item_id'] as $key=>$item_id){
			if($postData['qty'][$key] > 0){
				$item = $this->item->getItem(['id'=>$item_id]);
				$sgstPer=$cgstPer = $igstPer="";
				$sgstAmount=$cgstAmount = $igstAmount="";
				$amount = $item->price*$postData['qty'][$key];
				$gstAmount = ($item->gst_per*$amount)/100;
				$gstType = 1;
				if($partyData->party_state_code == 24){
					$sgstPer=$cgstPer = $item->gst_per/2;
					$sgstAmount=$cgstAmount= ($sgstPer*$amount)/100;
					$gstType=1;
				}else{
					$igstPer=$item->gst_per;
					$igstAmount = ($igstPer*$amount)/100;
					$gstType=2;
				}
				$netAmount = $amount + $gstAmount;
				$itemData[] =[
					'id' => '',
					'item_id' => $item_id,
					'item_name' =>$item->item_name,
					'from_entry_type' => 0,
					'ref_id' => 0,
					'item_code' => $item->item_name,
					'item_type' => 1,
					'brand_id' => $postData['brand_id'],
					'brand_name' =>$postData['brand_name'] ,
					'hsn_code' => $item->hsn_code,
					'qty' => $postData['qty'][$key],
					'unit_id' =>$item->unit_id,
					'unit_name' => $item->unit_name,
					'price' => $item->price,
					'disc_per' => 0.00,
					'disc_amount' => 0.00,
					'cgst_per' => $item->gst_per/2,
					'cgst_amount' => $cgstAmount,
					'sgst_per' => $item->gst_per/2,
					'sgst_amount' => $sgstAmount,
					'gst_per' => $item->gst_per,
					'igst_per' =>$igstPer,
					'gst_amount' => $gstAmount,
					'igst_amount' => $igstAmount,
					'amount' => $amount,
					'taxable_amount' => $amount,
					'net_amount' =>$netAmount,
					'item_remark' => '',
					'cod_date' => null,
				];
				$totalAmount += $amount;
				$totalTaxableAmount+=$amount;
				$totalNetAmount+=$netAmount;
			}
		}
        if(empty($itemData))
            $errorMessage['item_id'] = "Item Details is required.";
        if(empty($postData['brand_id']))
            $errorMessage['brand_id'] = "Brand is required.";
        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
			$entryData = $this->transMainModel->getEntryType(['controller'=>'salesOrders']);

			$trans_prefix = $entryData->trans_prefix;
			$trans_no = $entryData->trans_no;
			$trans_number = $trans_prefix.$trans_no;
			
			$data = [
				'id'=>'',
				'party_id'=>$this->partyId,
				'entry_type'=>20,
				'from_entry_type'=>'',
				'entry_from'=>1,
				'ref_id'=>'',
				'trans_prefix'=>$trans_prefix,
				'trans_no'=>$trans_no,
				'trans_number'=>$trans_number,
				'trans_date'=>date("Y-m-d"),
				'party_name'=>$partyData->party_name,
				'gst_type'=>(($partyData->party_state_code == 24)?1:2),
				'party_state_code'=>$partyData->party_state_code,
				'gstin'=>$partyData->gstin,
				'apply_round'=>1,
				'ledger_eff'=>0,
				'is_approve'=>0,
				'approve_date'=>0,
				'doc_no'=>'',
				'doc_date'=>'',
				'doc_date'=>'',
				'masterDetails' =>['t_col_1'=>$partyData->contact_person,'t_col_1'=>$partyData->party_phone,'t_col_3'=>$partyData->party_address,'t_col_4'=>$partyData->party_pincode] ,
				'total_amount'=>$totalAmount,
				'taxable_amount'=>$totalTaxableAmount,
				'expenseData' =>[
					'exp1_per'=>0,
					'exp1_amount'=>0,
					'exp3_per'=>0,
					'exp3_amount'=>0,
					'exp4_per'=>0,
					'exp2_per'=>0,
					'exp2_amount'=>0,
				],
				'cgst_per'=>$cgstPer,
				'cgst_amount'=>$cgstAmount,
				'sgst_per'=>$sgstPer,
				'sgst_amount'=>$sgstAmount,
				'igst_per'=>$igstPer,
				'igst_amount'=>$igstAmount,
				'round_off_amount'=>0,
				'net_amount'=>$netAmount,
				'remark'=>0,
				'termsData'=>'',
				'vou_name_l'=>'Sales Order',
				'vou_name_s'=>'SOrd',

			];
			$data['itemData'] = $itemData;
            $this->printJson($this->salesOrder->save($data));
		endif;
	}

	public function orderList(){
		$this->data['headData']->menu_id = 1;
		$this->data['soData'] = $this->salesOrder->getPendingOrderItems(['party_id'=>$this->partyId,'completed_order'=>1]);
		$this->load->view('customer_app/order_list',$this->data);
	}
}
?>