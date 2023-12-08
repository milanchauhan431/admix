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
        $this->data['from_date'] = $this->startYearDate;
        $this->data['to_date'] = $this->endYearDate;
        $this->data['brandList'] = $this->brandMaster->getBrandList();
        $this->load->view("reports/store_report/item_stock",$this->data);
    }

    public function getStockRegisterData(){
        $data = $this->input->post();
        $result = $this->storeReport->getStockRegisterData($data);

        $tbody = '';$i=1;
        foreach($result as $row):
			$box_qty = (!empty(floatVal($row->cl_stock_qty)) && !empty(floatval($row->packing_standard)))? ceil((floatVal($row->cl_stock_qty) / $row->packing_standard)) : 0;
            $tbody .= '<tr>
                <td class="text-center">'.$i++.'</td>
                <td class="text-left">
					<a href="'.base_url("reports/storeReport/itemHistory/".$row->item_id).'" target="_blank" datatip="History" flow="left">'.$row->item_name.'</a>
				</td>
                <td class="text-right">'.floatVal($row->op_stock_qty).'</td>
                <td class="text-right">'.floatVal($row->in_stock_qty).'</td>
                <td class="text-right">'.floatVal($row->out_stock_qty).'</td>
                <td  class="text-right">
					<a class="stockTransactions" data-item_id="'.$row->item_id.'" data-item_name="'.$row->item_name.'" datatip="Brand Wise" flow="left" href="javascript:void(0)">
						'.floatVal($row->cl_stock_qty).'
					</a>
				</td>
				<td class="text-right">'.$box_qty.'</td>
            </tr>';
        endforeach;

        $this->printJson(['status'=>1,'tbody'=>$tbody]);
    }

    public function itemHistory($item_id=""){
        $this->data['itemData'] = $this->item->getItem(['id'=>$item_id]);
        $this->data['from_date'] = $this->startYearDate;
        $this->data['to_date'] = $this->endYearDate;
        $this->data['brandList'] = $this->brandMaster->getBrandList();
        $this->load->view('reports/store_report/item_history',$this->data);
    }
	
	public function getItemHistory(){
		$data = $this->input->post();
        $itemData = $this->item->getItem(['id'=>$data['item_id']]);
        $itemSummary = $this->storeReport->getItemSummary($data);
        $itemHistory = $this->storeReport->getItemHistory($data);

        $thead = '<tr class="text-center">
            <th colspan="5" class="text-left">'.((!empty($itemData))?$itemData->item_name:"Item History").'</th>
            <th colspan="2" class="text-right">Op. Stock : '.floatVal($itemSummary->op_stock_qty).'</th>
        </tr>
        <tr>
            <th style="min-width:25px;">#</th>
            <th style="min-width:100px;">Trans. Type</th>
            <th style="min-width:100px;">Trans. No.</th>
            <th style="min-width:50px;">Trans. Date</th>
            <th style="min-width:50px;">Inward</th>
            <th style="min-width:50px;">Outward</th>
            <th style="min-width:50px;">Balance</th>
        </tr>';
		
        $i=1; $tbody =""; $tfoot=""; $balanceQty = $itemSummary->op_stock_qty;
        foreach($itemHistory as $row):  
            $balanceQty += $row->qty * $row->p_or_m;          
            $tbody .= '<tr>
                <td>' . $i++ . '</td>
                <td>'.$row->sub_menu_name.'</td>
                <td>'.$row->ref_no.'</td>
                <td>'.formatDate($row->ref_date).'</td>
                <td>'.floatVal($row->in_qty).'</td>
                <td>'.floatVal($row->out_qty).'</td>
                <td>'.floatVal($balanceQty).'</td>
            </tr>';
        endforeach;

        $tfoot .= '<tr>
            <th colspan="4" class="text-right">Cl. Stock</th>
            <th>' .floatVal($itemSummary->in_stock_qty). '</th>
            <th>' .floatVal($itemSummary->out_stock_qty). '</th>
            <th>' .floatVal($itemSummary->cl_stock_qty). '</th>
        </tr>';

        $this->printJson(['status'=>1,'thead'=>$thead,'tbody'=>$tbody,'tfoot'=>$tfoot]);
    }
	
	public function stockTransactions(){    
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