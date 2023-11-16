<?php
class SalesReport extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->data['headData']->pageTitle = "Sales Report";
        $this->data['headData']->controller = "reports/salesReport";
    }

    public function orderMonitoring(){
        $this->data['headData']->pageUrl = "reports/salesReport/salesRegister";
        $this->data['headData']->pageTitle = "ORDER MONITORING";
        $this->data['pageHeader'] = 'ORDER MONITORING';
        $this->data['startDate'] = (!empty($startDate))?$startDate:getFyDate(date("Y-m-01"));
        $this->data['endDate'] = (!empty($endDate))?$endDate:getFyDate(date("Y-m-d"));
        $this->load->view("reports/sales_report/order_monitoring",$this->data);
    }

    public function getOrderMonitoringData(){
        $data = $this->input->post();
        
    }
}
?>