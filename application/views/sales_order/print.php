<html>
    <head>
        <title>Sales Order</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url("assets/images/favicon.png");?>">
    </head>
    <body>
        <div style="font-size:15px;font-weight:500;position:fixed;top:-21mm;right:-15px;text-align:right;color:#343434">
            1, Umakant Pandit Udhyog Nagar,<br>Nr. Anand Bunglow Chowk,<br>Rajkot-360005
        </div>
        <div class="row">
            <div class="col-12">
                <!-- <table>
                    <tr>
                        <td>
                            <img src="<?=$letter_head?>" class="img">
                        </td>
                    </tr>
                </table> -->

                <table class="table bg-light-grey" style="margin-left:12px;width:97%;">
                    <tr class="" style="letter-spacing: 2px;font-weight:bold;padding:2px !important; border-bottom:1px solid #000000;">
                        <td style="width:33%;" class="fs-18 text-left">
                            GSTIN: <?=$companyData->company_gst_no?>
                        </td>
                        <td style="width:33%;" class="fs-18 text-center">Sales Order</td>
                        <td style="width:33%;" class="fs-18 text-right"></td>
                    </tr>
                </table>
                
                <table class="table item-list-bb fs-22" style="margin-top:5px;width:97%;">
                    <tr >
                        <td rowspan="5" style="width:67%;vertical-align:top;">
                            <b>M/S. <?=$dataRow->party_name?></b><br>
                            <?=(!empty($dataRow->ship_address) ? $dataRow->ship_address ." - ".$dataRow->ship_pincode : '')?><br>
                            <b>Kind. Attn. : <?=$dataRow->contact_person?></b> <br>
                            Contact No. : <?=$dataRow->contact_no?><br>
                            Email : <?=$partyData->contact_email?><br><br>
                            GSTIN : <?=$dataRow->gstin?>
                        </td>
                        <td>
                            <b>SO. No.</b>
                        </td>
                        <td>
                            <?=$dataRow->trans_number?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left">SO. Date</th>
                        <td><?=formatDate($dataRow->trans_date)?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Cust. PO. No.</th>
                        <td><?=$dataRow->doc_no?></td>
                    </tr>
                    <tr>
                        <th class="text-left">Cust. PO. Date</th>
                        <td><?=(!empty($dataRow->doc_date)) ? formatDate($dataRow->doc_date) : ""?></td>
                    </tr>
                    <tr>
				        <th class="text-left">Transport</th>
                        <td><?=(!empty($dataRow->transaport_name))?$dataRow->transaport_name." - ".$dataRow->transaport_gst_no:""?></td>
                    </tr>
                </table>
                
                <table class="table item-list-bb" style="margin-top:10px;width:97%;">
                    <tr>
                        <th style="width:40px;">No.</th>
                        <th class="text-left">Item Description</th>
                        <th style="width:90px;">HSN/SAC</th>
                        <th class="text-right" style="width:100px;">Qty</th>
                        <th style="width:50px;">UOM</th>
                        <th class="text-right" style="width:100px;">Weight (Kg)</th>
                    </tr>
                    <?php
                        $i=1;$totalQty = $totalWeight = 0;
                        if(!empty($dataRow->itemList)):
                            foreach($dataRow->itemList as $row):
                                $indent = (!empty($row->ref_id)) ? '<br>Reference No:'.$row->ref_number : '';
                                $delivery_date = (!empty($row->delivery_date)) ? '<br>Delivery Date :'.formatDate($row->delivery_date) : '';
                                $item_remark=(!empty($row->item_remark))?'<br><small>Remark:.'.$row->item_remark.'</small>':'';
                                
                                echo '<tr>';
                                    echo '<td class="text-center">'.$i++.'</td>';
                                    echo '<td>'.$row->item_name.$indent.$delivery_date.$item_remark.'</td>';
                                    echo '<td class="text-center">'.$row->hsn_code.'</td>';
                                    echo '<td class="text-right">'.$row->qty.'</td>';
                                    echo '<td class="text-center">'.$row->unit_name.'</td>';
                                    echo '<td class="text-right">'.sprintf('%.3f',($row->qty * $row->wkg)).'</td>';
                                echo '</tr>';
                                $totalQty += $row->qty;
                                $totalWeight += ($row->qty * $row->wkg);
                            endforeach;
                        endif;
                    ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th class="text-right"><?=sprintf('%.3f',$totalQty)?></th>
                        <th class="text-right"></th>
                        <th class="text-right"><?=sprintf('%.3f',$totalWeight)?></th>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-left"><b>Note: </b> <?= $dataRow->remark ?></td>
                    </tr>
                    
                </table>

                <table class="table top-table" style="margin-top:10px;width:92%;">
                    <tr>
                        <th class="text-left"><h4>Terms & Conditions :-</h4></th>
                    </tr>
                    <?php
                        if(!empty($dataRow->termsConditions)):
                            foreach($dataRow->termsConditions as $row):
                                echo '<tr>';
                                    /* echo '<th class="text-left fs-11" style="width:140px;">'.$row->term_title.'</th>'; */
                                    echo '<td class=" fs-11"><ul><li> '.$row->condition.' </li></ul></td>';
                                echo '</tr>';
                            endforeach;
                        endif;
                    ?>
                </table>
                
                <htmlpagefooter name="lastpage">
                    <table class="table top-table" style="border-top:1px solid #545454;margin-top:10px;width:92%;">
                        <tr>
                            <td style="width:50%;"></td>
                            <td style="width:20%;"></td>
                            <th class="text-center">For, <?=$companyData->company_name?></th>
                        </tr>
                        <tr>
                            <td colspan="3" height="50"></td>
                        </tr>
                        <tr>
                            <td><br>This is a computer-generated order.</td>
                            <td class="text-center"><?=$dataRow->created_name?><br>Prepared By</td>
                            <td class="text-center"><br>Authorised By</td>
                        </tr>
                    </table>
                    <table class="table top-table" style="border-top:1px solid #545454;margin-top:10px;width:92%;">
						<tr>
							<td style="width:25%;">SO. No. & Date : <?=$dataRow->trans_number.' ['.formatDate($dataRow->trans_date).']'?></td>
							<td style="width:25%;"></td>
							<td style="width:25%;text-align:right;">Page No. {PAGENO}/{nbpg}</td>
						</tr>
					</table>
                </htmlpagefooter>
				<sethtmlpagefooter name="lastpage" value="on" />                
            </div>
        </div>        
    </body>
</html>
