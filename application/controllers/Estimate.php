<?php
class Estimate extends MY_Controller{
    private $indexPage = "estimate/index";
    private $form = "estimate/form"; 
    private $paymentForm = "estimate/estimate_payment";

    public function __construct(){
		parent::__construct();
		$this->data['headData']->pageTitle = "Estimate";
		$this->data['headData']->controller = "estimate";        
        $this->data['headData']->pageUrl = "estimate";
        $this->data['entryData'] = $this->transMainModel->getEntryType(['controller'=>'estimate']);
	}

    public function index(){
        $this->data['tableHeader'] = getSalesDtHeader("estimate");
        $this->load->view($this->indexPage,$this->data);
    }

    public function getDTRows($status = 0){
        $data = $this->input->post();$data['status'] = $status;
        $data['entry_type'] = $this->data['entryData']->id;
        $result = $this->estimate->getDTRows($data);
        $sendData = array();$i=($data['start']+1);
        foreach($result['data'] as $row):
            $row->sr_no = $i++;
            $sendData[] = getEstimateData($row);
        endforeach;
        $result['data'] = $sendData;
        $this->printJson($result);
    }

    public function addEstimate(){
        $this->data['entry_type'] = $this->data['entryData']->id;
        $this->data['trans_prefix'] = $this->data['entryData']->trans_prefix;
        $this->data['trans_no'] = $this->data['entryData']->trans_no;
        $this->data['trans_number'] = $this->data['trans_prefix'].$this->data['trans_no'];
        $this->data['partyList'] = $this->party->getPartyList(['party_category'=>1]);
        $this->data['itemList'] = $this->item->getItemList(['item_type'=>1]);
        $this->data['brandList'] = $this->brandMaster->getBrandList();
        $this->data['unitList'] = $this->item->itemUnits();
        $this->data['hsnList'] = $this->hsnModel->getHSNList();
		$this->data['taxList'] = array();//$this->taxMaster->getActiveTaxList(2);
        $this->data['expenseList'] = $this->expenseMaster->getActiveExpenseList(2);
        $this->data['termsList'] = $this->terms->getTermsList(['type'=>'Sales']);
		$this->data['ledgerList'] = $this->party->getPartyList(["'DT'","'ED'","'EI'","'ID'","'II'"]);
        $this->load->view($this->form,$this->data);
    }

    public function save(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['party_id']))
            $errorMessage['party_id'] = "Party Name is required.";
        if(empty($data['itemData'])):
            $errorMessage['itemData'] = "Item Details is required.";
        else:
            $bQty = array();
            foreach($data['itemData'] as $key => $row):
                /*if(!empty(floatVal($row['qty'])) && !empty($row['packing_qty'])):
                    if(is_int(($row['qty'] / $row['packing_qty'])) == false):
                        $errorMessage['qty'.$key] = "Invalid qty against packing standard.";
                    endif;
                endif;*/

                if($row['stock_eff'] == 1):
                    $postData = ['location_id' => $this->RTD_STORE->id,'batch_no' => $row['brand_name'],'item_id' => $row['item_id'],'stock_required'=>1,'single_row'=>1];
                    
                    $stockData = $this->itemStock->getItemStockBatchWise($postData);  
                    
                    $stockQty = (!empty($stockData->qty))?$stockData->qty:0;
                    if(!empty($row['id'])):
                        $oldItem = $this->estimate->getEstimateItem(['id'=>$row['id']]);
                        $stockQty = $stockQty + $oldItem->qty;
                    endif;
                    
                    if(!isset($bQty[$row['item_id']])):
                        $bQty[$row['item_id']] = $row['qty'] ;
                    else:
                        $bQty[$row['item_id']] += $row['qty'];
                    endif;

                    if(empty($stockQty)):
                        $errorMessage['qty'.$key] = "Stock not available.";
                    else:
                        if($bQty[$row['item_id']] > $stockQty):
                            $errorMessage['qty'.$key] = "Stock not available.";
                        endif;
                    endif;
                endif;
            endforeach;
        endif;
        
        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            $data['vou_name_l'] = $this->data['entryData']->vou_name_long;
            $data['vou_name_s'] = $this->data['entryData']->vou_name_short;
            $this->printJson($this->estimate->save($data));
        endif;
    }

    public function edit($id){
        $this->data['dataRow'] = $dataRow = $this->estimate->getEstimate(['id'=>$id,'itemList'=>1]);
        $this->data['gstinList'] = $this->party->getPartyGSTDetail(['party_id' => $dataRow->party_id]);
        $this->data['partyList'] = $this->party->getPartyList(['party_category' => 1]);
        $this->data['itemList'] = $this->item->getItemList(['item_type'=>1]);
        $this->data['brandList'] = $this->brandMaster->getBrandList();
        $this->data['unitList'] = $this->item->itemUnits();
        $this->data['hsnList'] = $this->hsnModel->getHSNList();
		$this->data['taxList'] = array();//$this->taxMaster->getActiveTaxList(2);
        $this->data['expenseList'] = $this->expenseMaster->getActiveExpenseList(2);
        $this->data['termsList'] = $this->terms->getTermsList(['type'=>'Sales']);
        $this->data['ledgerList'] = $this->party->getPartyList(["'DT'","'ED'","'EI'","'ID'","'II'"]);
        $this->load->view($this->form,$this->data);
    }

    public function delete(){
        $id = $this->input->post('id');
        if(empty($id)):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->estimate->delete($id));
        endif;
    }

    public function printEstimate($id){
        $this->data['dataRow'] = $dataRow = $this->salesOrder->getSalesOrder(['id'=>$id,'itemList'=>1]);
        $this->data['partyData'] = $this->party->getParty(['id'=>$dataRow->party_id]);
        $this->data['companyData'] = $companyData = $this->masterModel->getCompanyInfo();
        
        $pdfData = $this->load->view('estimate/print', $this->data, true);        
        
		$mpdf = new \Mpdf\Mpdf();
		$filePath = realpath(APPPATH . '../assets/uploads/sales_quotation/');
        $pdfFileName = $filePath.'/' . str_replace(["/","-"],"_",$dataRow->trans_number) . '.pdf';
        $stylesheet = file_get_contents(base_url('assets/css/pdf_style.css?v='.time()));
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkImage($logo, 0.03, array(120, 120));
        $mpdf->showWatermarkImage = true;
		$mpdf->AddPage('P','','','','',10,5,5,15,5,5,'','','','','','','','','','A4-P');
        $mpdf->WriteHTML($pdfData);
		
		ob_clean();
		$mpdf->Output($pdfFileName, 'I');		
    }

    public function estimatePayment(){
        $data = $this->input->post();
        $this->data['main_ref_id'] = $data['id'];
        $this->load->view($this->paymentForm,$this->data);
    }

    public function saveEstimatePayment(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['entry_date']))
            $errorMessage['entry_date'] = "Date is required.";
        if(empty($data['amount']))
            $errorMessage['amount'] = "Amount is required.";

        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            $this->printJson($this->estimate->saveEstimatePayment($data));
        endif;
    }

    public function getEstimatePaymentTrans(){
        $data = $this->input->post();
        $result = $this->estimate->getEstimatePayments($data);

        $tbodyData="";$i=1; 
        if(!empty($result)):
            foreach($result as $row):
                $deleteParam = "{'postData':{'id' : ".$row->id."},'message' : 'Payment','fndelete':'deleteEstimatePayment','res_function':'resTrashEstimatePayment'}";
                $tbodyData.= '<tr>
                    <td>' . $i++ . '</td>
                    <td>' . formatDate($row->entry_date) . '</td>
                    <td>' . $row->received_by . '</td>
                    <td>' . $row->amount . ' </td>
                    <td>' . $row->remark . '</td>
                    <td class="text-center">
                        <button type="button" onclick="trash('.$deleteParam.');" class="btn btn-sm btn-outline-danger waves-effect waves-light btn-delete permission-remove"><i class="ti-trash"></i></button>
                    </td>
                </tr>';
            endforeach;
        else:
            $tbodyData.= '<tr><td colspan="6" class="text-center">No data available in table</td></tr>';
        endif;

        $this->printJson(['status'=>1,"tbodyData"=>$tbodyData]);
    }

    public function deleteEstimatePayment(){
        $id = $this->input->post('id');
        if(empty($id)):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->estimate->deleteEstimatePayment($id));
        endif;
    }
}
?>