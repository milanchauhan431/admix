<?php
class StoreReport extends MY_Controller{
    public function __construct(){
		parent::__construct();
		$this->isLoggedin();
		$this->data['headData']->pageTitle = "Store Report";
		$this->data['headData']->controller = "reports/storeReport";
    }

    public function stockRegister(){
        $this->data['pageHeader'] = 'STOCK REGISTER';
        $this->data['headData']->pageUrl = "reports/storeReport/stockRegister";
        $this->load->view("reports/store_report/item_stock",$this->data);
    }

    public function getStockRegisterData(){
        $data = $this->input->post();
        $result = $this->storeReport->getStockRegisterData($data);

        $tbody = '';$i=1;
        foreach($result as $row):
			$box_qty = (!empty(floatVal($row->stock_qty)))? (floatVal($row->stock_qty) / $row->packing_standard) : 0;
            $tbody .= '<tr>
                <td class="text-center">'.$i++.'</td>
                <td class="text-left">
					<a href="'.base_url("reports/storeReport/getItemHistory/".$row->item_id).'" target="_blank" datatip="History" flow="left">'.$row->item_name.'</a>
				</td>
                <td  class="text-right">
					<a class="stockTransactions" data-item_id="'.$row->item_id.'" data-item_name="'.$row->item_name.'" datatip="Brand Wise" flow="left" href="javascript:void(0)">
						'.floatVal($row->stock_qty).'
					</a>
				</td>
				<td class="text-right">'.round($box_qty,0).'</td>
            </tr>';
        endforeach;

        $this->printJson(['status'=>1,'tbody'=>$tbody]);
    }
	
	public function getItemHistory($item_id=""){
		$data['item_id'] = $item_id;
        $itemData = $this->storeReport->getItemHistory($data);
		
        $i=1; $tbody =""; $tfoot=""; $item_name=""; $credit=0;$debit=0; $tcredit=0;$tdebit=0; $tbalance=0;
        foreach($itemData as $row):
            $credit=0;$debit=0;
            if($row->p_or_m == 1){ 
				$credit = abs($row->qty);$tbalance +=abs($row->qty); 
			} else { 
				$debit = abs($row->qty);$tbalance -=abs($row->qty); 
			}
            
            $tbody .= '<tr>
                <td>' . $i++ . '</td>
                <td>'.$row->sub_menu_name.'</td>
                <td>'.$row->ref_no.'</td>
                <td>'.formatDate($row->ref_date).'</td>
                <td>'.floatVal($credit).'</td>
                <td>'.floatVal($debit).'</td>
                <td>'.floatVal($tbalance).'</td>
            </tr>';
            $tcredit += $credit; $tdebit += $debit;
			$item_name = $row->item_name;
        endforeach;
        $tfoot .= '<tr class="thead-info">
                <th colspan="4">Total</th>
                <th>' .floatVal($tcredit). '</th>
                <th>' .floatVal($tdebit). '</th>
                <th>' .floatVal($tbalance). '</th>
            </tr>';
		$this->data['item_name'] = $item_name;
        $this->data['tbody'] = $tbody;
        $this->data['tfoot'] = $tfoot;
        $this->load->view('reports/store_report/item_history',$this->data);
    }
	
	public function stockTransactions(){    
		$this->data['item_id'] = $this->input->post('item_id');
		$data['item_id'] = $this->data['item_id'];
        $result = $this->storeReport->getStockTransaction($data);
        
        $tbody = ""; $i=1;
        foreach($result as $row):
            $tbody .= '<tr>
                <td>'.$i++.'</td>
                <td class="text-left">'.$row->batch_no.'</td>
                <td  class="text-right">'.floatVal($row->stock_qty).'</td>
            </tr>';
        endforeach;
		$this->data['tbody'] = $tbody;
        $this->load->view("reports/store_report/brand_wise_trans",$this->data);
    }
    
    /*public function stockTransactions($id = ""){
        $this->data['item_id'] = $id;
        $this->data['pageHeader'] = 'STOCK REGISTER';
        $this->data['headData']->pageUrl = "reports/storeReport/stockRegister";
        $this->data['itemList'] = $this->item->getItemList();
        $this->load->view("reports/store_report/item_stock_trans",$this->data);
    }
    
    public function getStockTransaction(){
        $data = $this->input->post();
        $result = $this->storeReport->getStockTransaction($data);
        
        $tbody = ""; $i=1;
        foreach($result as $row):
            $tbody .= '<tr>
                <td>'.$i++.'</td>
                <td class="text-left">'.$row->batch_no.'</td>
                <td  class="text-right">'.floatVal($row->stock_qty).'</td>
            </tr>';
        endforeach;
        
        $this->printJson(['status'=>1,'tbody'=>$tbody]);
    }*/
}
?>