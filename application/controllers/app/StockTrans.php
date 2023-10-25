<?php
class StockTrans extends MY_Controller
{
	private $indexPage = "app/fginward_index";
	private $formPage = "app/fginward_form"; 
	private $stockRegisterIndex = "app/stock_register_index";
	private $stockRegisterDetail = "app/stock_register_detail";

	public function __construct()
	{
		parent::__construct();
		$this->isLoggedin();
		$this->data['headData']->pageTitle = "Fg Stock Inward";
		$this->data['headData']->controller = "app/stockTrans";
        $this->data['entryData'] = $this->transMainModel->getEntryType(['controller'=>'stockTrans']);
	}

	public function index()
	{
		$this->data['bottomMenuName'] ='stockTrans';
        $this->data['stockData'] =  $this->itemStock->getStockDataForApp();
		$this->load->view($this->indexPage, $this->data);
	}

	public function addStock(){
        $this->data['itemList'] = $this->item->getItemList(['item_type'=>[1]]);
        $this->data['brandList'] = $this->brandMaster->getBrandList();
        $this->data['sizeList'] = $this->sizeMaster->getSizeList();
        $this->load->view($this->formPage, $this->data);
    }
    
    public function stockRegister()
	{
		$this->data['headData']->pageTitle = "Stock Register";
		$this->data['bottomMenuName'] ='stockRegister';
        $this->data['srData'] =  $this->storeReport->getStockRegisterData(['item_type'=>1,'stock_type'=>0]);
		$this->load->view($this->stockRegisterIndex, $this->data);
	}

	public function stockTransactions(){
		$data = $this->input->post(); 
        $this->data['pageHeader'] = 'STOCK REGISTER ';
        $this->data['stockTransData'] =  $this->storeReport->getStockTransaction($data);
		$this->load->view($this->stockRegisterDetail, $this->data);
    }
}
?>