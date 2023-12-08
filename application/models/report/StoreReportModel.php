<?php
class StoreReportModel extends MasterModel{
    private $itemMaster = "item_master";
    private $stockTrans = "stock_transaction";

    public function getStockRegisterData($data){
        $data['from_date'] = (!empty($data['from_date']))?$data['from_date']:$this->startYearDate;
        $data['to_date'] = (!empty($data['to_date']))?$data['to_date']:$this->endYearDate;
        $unique_id = "";
        if(!empty($data['unique_id'])):
            $unique_id = " AND unique_id = ".$data['unique_id'];
        endif;

        $queryData = array();
        $queryData['tableName'] = $this->itemMaster;
        $queryData['select'] = "item_master.id as item_id,item_master.item_code,item_master.item_name,item_master.packing_standard,ifnull(st.op_stock_qty,0) as op_stock_qty,ifnull(st.in_stock_qty,0) as in_stock_qty,ifnull(st.out_stock_qty,0) as out_stock_qty,ifnull(st.cl_stock_qty,0) as cl_stock_qty,ifnull(st.cl_stock_qty,0) as stock_qty";

        //$queryData['leftJoin']['(SELECT SUM(qty * p_or_m) as stock_qty,item_id FROM stock_transaction WHERE is_delete = 0 GROUP BY item_id) as st'] = "item_master.id = st.item_id";

        $queryData['leftJoin']['(SELECT 
        item_id,
        SUM((CASE WHEN ref_date < "'.$data['from_date'].'" THEN (qty * p_or_m) ELSE 0 END)) as op_stock_qty,
        
        SUM((CASE WHEN ref_date >= "'.$data['from_date'].'" AND ref_date <= "'.$data['to_date'].'" AND p_or_m = 1 THEN qty ELSE 0 END)) as in_stock_qty,
        
        SUM((CASE WHEN ref_date >= "'.$data['from_date'].'" AND ref_date <= "'.$data['to_date'].'" AND p_or_m = -1 THEN qty ELSE 0 END)) as out_stock_qty,
        
        SUM((CASE WHEN ref_date <= "'.$data['to_date'].'" THEN (qty * p_or_m) ELSE 0 END)) as cl_stock_qty

        FROM stock_transaction WHERE is_delete = 0 '.$unique_id.' GROUP BY item_id) as st'] = "item_master.id = st.item_id";

        $queryData['where']['item_master.item_type'] = $data['item_type'];

        if(!empty($data['stock_type'])):
            if($data['stock_type'] == 1):
                $queryData['where']['ifnull(st.cl_stock_qty,0) > '] = "0";
            else:
                $queryData['where']['ifnull(st.cl_stock_qty,0) <= '] = "0";
            endif;
        endif;

        $result = $this->rows($queryData);
        return $result;
    }
    
    public function getStockTransaction($data){
        $queryData = array();
        $queryData['tableName'] = $this->stockTrans;
        $queryData['select'] = "stock_transaction.batch_no,SUM(stock_transaction.qty * stock_transaction.p_or_m) as stock_qty";
        $queryData['where']['stock_transaction.item_id'] = $data['item_id'];
        $queryData['having'][] = "SUM(stock_transaction.qty * stock_transaction.p_or_m) > 0";
        $queryData['group_by'][] = "stock_transaction.batch_no";
        $result = $this->rows($queryData);
        
        return $result;
    }

    public function getItemSummary($data){
        $unique_id = "";
        if(!empty($data['unique_id'])):
            $unique_id = " AND unique_id = ".$data['unique_id'];
        endif;

        $queryData = array();
        $queryData['tableName'] = $this->itemMaster;
        $queryData['select'] = "item_master.id,item_master.item_code,item_master.item_name,ifnull(st.op_stock_qty,0) as op_stock_qty,ifnull(st.in_stock_qty,0) as in_stock_qty,ifnull(st.out_stock_qty,0) as out_stock_qty,ifnull(st.cl_stock_qty,0) as cl_stock_qty";

        $queryData['leftJoin']['(SELECT 
        item_id,
        SUM((CASE WHEN ref_date < "'.$data['from_date'].'" THEN (qty * p_or_m) ELSE 0 END)) as op_stock_qty,
        
        SUM((CASE WHEN ref_date >= "'.$data['from_date'].'" AND ref_date <= "'.$data['to_date'].'" AND p_or_m = 1 THEN qty ELSE 0 END)) as in_stock_qty,
        
        SUM((CASE WHEN ref_date >= "'.$data['from_date'].'" AND ref_date <= "'.$data['to_date'].'" AND p_or_m = -1 THEN qty ELSE 0 END)) as out_stock_qty,
        
        SUM((CASE WHEN ref_date <= "'.$data['to_date'].'" THEN (qty * p_or_m) ELSE 0 END)) as cl_stock_qty

        FROM stock_transaction WHERE is_delete = 0 '.$unique_id.' GROUP BY item_id) as st'] = "item_master.id = st.item_id";

        if(!empty($data['item_id'])):
            $queryData['where']['item_master.id'] = $data['item_id'];
            $result = $this->row($queryData);
        else:
            $result = $this->rows($queryData);
        endif;
        return $result;
    }
	
	public function getItemHistory($data){
        $queryData['tableName'] = $this->stockTrans;
        $queryData['select'] = 'item_master.item_code,item_master.item_name,stock_transaction.*,sub_menu_master.sub_menu_name,(CASE WHEN stock_transaction.p_or_m = 1 THEN stock_transaction.qty ELSE 0 END) as in_qty,(CASE WHEN stock_transaction.p_or_m = -1 THEN stock_transaction.qty ELSE 0 END) as out_qty';

        $queryData['leftJoin']['item_master'] = "item_master.id = stock_transaction.item_id";
		$queryData['leftJoin']['sub_menu_master'] = "sub_menu_master.id = stock_transaction.entry_type";

        $queryData['where']['stock_transaction.item_id'] = $data['item_id'];
        $queryData['where']['stock_transaction.ref_date >='] = $data['from_date'];
        $queryData['where']['stock_transaction.ref_date <='] = $data['to_date'];
        if(!empty($data['unique_id'])):
            $queryData['where']['stock_transaction.unique_id'] = $data['unique_id'];
        endif;

        $queryData['order_by']['stock_transaction.id'] = 'ASC';

		$result = $this->rows($queryData);
		return $result;
    }
}
?>