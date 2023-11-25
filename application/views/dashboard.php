<!-- ============================================================== -->
<!-- Header -->
<!-- ============================================================== -->
    <?php $this->load->view('includes/header'); ?>
    <link href="<?=base_url()?>assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/js/pages/chartist/chartist-init.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/extra-libs/c3/c3.min.css">
<!-- ============================================================== -->
<!-- End Header  -->
<!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales Summery -->
                <!-- ============================================================== -->
                <div class="row m-b-10">
					<div class="col-lg-3">
						<div class="card bg-orange text-white">
							<div class="card-body">
								<div id="cc1" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner">
										<div class="carousel-item flex-column active">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 fas fa-user text-white" title="Present"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Present</h4>
													<h5>20</h5>
												</div>
											</div>
										</div>
										<div class="carousel-item flex-column">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 fas fa-user text-white" title="Absent"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Absent</h4>
													<h5>4</h5>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-success text-white">
							<div class="card-body">
								<div id="myCarousel22" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner">
										<div class="carousel-item flex-column active">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 icon-Receipt-3 text-white" title="BTC"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Pending Sales</h4>
													<h5>5</h5>
												</div>
											</div>
										</div>
										<div class="carousel-item flex-column">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 icon-Receipt-3 text-white" title="BTC"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Today's Sales</h4>
													<h5><i class="fas fa-inr"></i> 1,50,000</h5>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-cyan text-white">
							<div class="card-body">
								<div id="myCarousel45" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner">
										<div class="carousel-item flex-column active">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 icon-Shopping-Basket text-white" title="BTC"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Pending Purchase</h4>
													<h5>12</h5>
												</div>
											</div>
										</div>
										<div class="carousel-item flex-column">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 icon-Shopping-Basket text-white" title="BTC"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Today's Purchase</h4>
													<h5><i class="fas fa-inr"></i> 50,000</h5>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-dark text-white">
							<div class="card-body">
								<div id="myCarousel33" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner">
										<div class="carousel-item flex-column active">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 fas fa-arrow-left text-white" title="BTC"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Receivables</h4>
													<h5><i class="fas fa-inr"></i> 50,000</h5>
												</div>
											</div>
										</div>
										<div class="carousel-item flex-column">
											<div class="d-flex no-block align-items-center">
												<a href="JavaScript: void(0);"><i class="display-6 fas fa-arrow-left text-white" title="BTC"></i></a>
												<div class="m-l-15 m-t-10">
													<h4 class="font-medium m-b-0">Payables</h4>
													<h5><i class="fas fa-inr"></i> 50,000</h5>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>				
				
				
                <!-- ============================================================== -->
                <!-- Task, Feeds -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card earning-widget">
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-6">
                                        <h4 class="m-b-0">Receivable Reminder</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-outline-info float-right" href="<?=base_url("reports/accountingReport/duePaymentReminder/Receivable")?>">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top scrollable" style="height:365px;">
                                <table class="table v-middle table-bordered">
                                    <thead class="thead-info">
                                        <tr>
                                            <th>Party Name</th>
                                            <th>Contact No.</th>
                                            <th>Vou. No.</th>
                                            <th>Vou. Date</th>
                                            <th>Due Date</th>
                                            <th>Due Days</th>
                                            <th>Due Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($receivableReminder as $row):
                                                echo '<tr>
                                                <td>'.$row->party_name.'</td>
                                                <td>'.$row->party_mobile.'</td>
                                                <td>'.$row->trans_number.'</td>
                                                <td>'.formatDate($row->trans_date).'</td>
                                                <td>'.formatDate($row->due_date).'</td>
                                                <td class="'.(($row->due_days > 0)?"text-danger":"text-success").'">'.$row->due_days.'</td>
                                                <td>'.$row->due_amount.'</td>
                                            </tr>';
                                            endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card earning-widget">
                            <div class="card-body">                                
                                <div class="row">   
                                    <div class="col-md-6">
                                        <h4 class="m-b-0">Payable Reminder</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-outline-info float-right" href="<?=base_url("reports/accountingReport/duePaymentReminder/Payable")?>">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top scrollable" style="height:365px;">
                                <table class="table v-middle table-bordered">
                                    <thead class="thead-info">
                                        <tr>
                                            <th>Party Name</th>
                                            <th>Contact No.</th>
                                            <th>Vou. No.</th>
                                            <th>Vou. Date</th>
                                            <th>Due Date</th>
                                            <th>Due Days</th>
                                            <th>Due Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($payableReminder as $row):
                                                echo '<tr>
                                                <td>'.$row->party_name.'</td>
                                                <td>'.$row->party_mobile.'</td>
                                                <td>'.$row->trans_number.'</td>
                                                <td>'.formatDate($row->trans_date).'</td>
                                                <td>'.formatDate($row->due_date).'</td>
                                                <td class="'.(($row->due_days > 0)?"text-danger":"text-success").'">'.$row->due_days.'</td>
                                                <td>'.$row->due_amount.'</td>
                                            </tr>';
                                            endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Trade history / Exchange -->
            <!-- ============================================================== -->
        </div>
        

        <!-- ============================================================== -->
            <?php $this->load->view('includes/footer'); ?>

            <!--<script src="<?=base_url()?>assets/libs/chartist/dist/chartist.min.js"></script>
            <script src="<?=base_url()?>assets/libs/chartist/dist/chartist-plugin-legend.js"></script>
            <script src="<?=base_url()?>assets/js/pages/chartist/chartist-plugin-tooltip.js"></script>
            <script src="<?=base_url()?>assets/js/pages/chartist/chartist-init.js"></script>-->
            <script src="<?=base_url()?>assets/js/pages/c3-chart/bar-pie/c3-stacked-column.js"></script>
            <script src="<?=base_url()?>assets/js/pages/dashboards/dashboard3.js"></script>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->