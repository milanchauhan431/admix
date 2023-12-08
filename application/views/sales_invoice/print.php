
<div style="font-size:15px;font-weight:500;position:fixed;top:-21mm;right:-15px;text-align:right;color:#343434">
    1, Umakant Pandit Udhyog Nagar,<br>Nr. Anand Bunglow Chowk,<br>Rajkot-360005
</div>
<div class="row">
    <div class="col-12">
        
        <table class="table bg-light-grey" style="margin-left:12px;width:97%;">
            <tr class="" style="letter-spacing: 2px;font-weight:bold;padding:2px !important; border-bottom:1px solid #000000;">
                <th style="width:33%;" class="fs-18 text-left">
                    GSTIN: <?=$companyData->company_gst_no?>
                </th>
                <th style="width:33%;" class="fs-18 text-center">TAX INVOICE</th>
                <th style="width:33%;" class="fs-18 text-right"><?=$printType?></th>
            </tr>
        </table>
        
        <table class="table item-list-bb fs-22" style="margin-top:5px;width:97%;">
            <tr>
                <td style="width:60%; vertical-align:top;" rowspan="4">
                    <b>Name & Address of the Receipiant (BILL TO)</b><br>
                    <b><?=$invData->party_name?></b><br>
                    <?=(!empty($partyData->party_address) ? $partyData->party_address : '')?><br>
                    <b>CITY</b> : <?=$partyData->city_name."-".$partyData->party_pincode?><br>
                    <b>Mobile No.</b> : <?=$partyData->party_mobile?><br>
                    <b>GSTIN</b> : <?=($invData->gstin != "URP")?$invData->gstin:""?> <br>
                    <b>Place of Supply</b> : <?=$partyData->state_code ." - ".$partyData->state_name?>
                </td>
                <td>
                    <b>Invoice No. : <?=$invData->trans_number?></b>
                </td>
                <td>
                    <b>Date : <?=date('d/m/Y', strtotime($invData->trans_date))?></b>
                </td>
            </tr>
            <tr>
                <td style="width:40%;" colspan="2">
                    <b>Memo Type</b> : <?=$invData->memo_type?>                    
                </td>
            </tr>
            <tr>
                <td style="width:40%;" colspan="2">
                    <b>Payment</b> : <?=(!empty($partyData->credit_days))?$partyData->credit_days." Days Credit":""?>
                </td>
            </tr>
            <tr>
                <td style="width:40%;" colspan="2">
                    <b>Transport</b> : <?=(!empty($invData->transaport_name))?$invData->transaport_name." - ".$invData->transaport_gst_no:""?>
                </td>
            </tr>
        </table>
        
        <table class="table item-list-bb" style="margin-top:10px;width:97%;">
            <?php $thead = '<thead>
                    <tr>
                        <th style="width:20px;">No.</th>
                        <th class="text-left">Description of Goods</th>
                        <th style="width:10%;">HSN/SAC</th>
                        <th style="width:60px;">Qty</th>
                        <th style="width:50px;">Rate<br><small>('.$partyData->currency.')</small></th>
                        <!--<th style="width:50px;">Disc<br><small>(%)</small></th>-->
                        <th style="width:50px;">GST<br><small>(%)</small></th>
                        <th style="width:90px;">Amount<br><small>('.$partyData->currency.')</small></th>
                    </tr>
                </thead>';
                echo $thead;
            ?>
            <tbody>
                <?php
                    $i=1;$totalQty = 0;$migst=0;$mcgst=0;$msgst=0;
                    $rowCount = 1;$pageCount = 1;
                    if(!empty($invData->itemList)):
                        foreach($invData->itemList as $row):						
                            echo '<tr>';
                                echo '<td class="text-center">'.$i++.'</td>';
                                echo '<td>'.$row->item_name.(($invData->bill_per == 100)?" PREMIUM":"").'</td>';
                                echo '<td class="text-center">'.$row->hsn_code.'</td>';
                                echo '<td class="text-center">'.floatVal($row->qty).' ('.$row->unit_name.')</td>';
                                echo '<td class="text-right">'.floatVal($row->price).'</td>';
                                //echo '<td class="text-right">'.floatVal($row->disc_per).'</td>';
                                echo '<td class="text-center">'.$row->gst_per.'</td>';
                                echo '<td class="text-right">'.$row->taxable_amount.'</td>';
                            echo '</tr>';
                            
                            $totalQty += $row->qty;
                            if($row->gst_per > $migst){$migst=$row->gst_per;$mcgst=$row->cgst_per;$msgst=$row->sgst_per;}
                        endforeach;
                    endif;

                    $blankLines = ($maxLinePP - $i);
                    if($blankLines > 0):
                        for($j=0;$j<=$blankLines;$j++):
                            echo '<tr>
                                <td style="border-top:none;border-bottom:none;">&nbsp;</td>
                                <td style="border-top:none;border-bottom:none;"></td>
                                <td style="border-top:none;border-bottom:none;"></td>
                                <td style="border-top:none;border-bottom:none;"></td>
                                <td style="border-top:none;border-bottom:none;"></td>
                                <td style="border-top:none;border-bottom:none;"></td>
                                <td style="border-top:none;border-bottom:none;"></td>
                                <!--<td style="border-top:none;border-bottom:none;"></td>-->
                            </tr>';
                        endfor;
                    endif;
                    
                    $rwspan= 0; $srwspan = '';
                    $beforExp = "";
                    $afterExp = "";
                    $invExpenseData = (!empty($invData->expenseData)) ? $invData->expenseData : array();
                    foreach ($expenseList as $row) :
                        $expAmt = 0;
                        $amtFiledName = $row->map_code . "_amount";
                        if (!empty($invExpenseData) && $row->map_code != "roff") :
                            $expAmt = floatVal($invExpenseData->{$amtFiledName});
                        endif;

                        if(!empty($expAmt)):
                            if ($row->position == 1) :
                                if($rwspan == 0):
                                    $beforExp .= '<th colspan="2" class="text-right">'.$row->exp_name.'</th>
                                    <td class="text-right">'.sprintf('%.2f',$expAmt).'</td>';
                                else:
                                    $beforExp .= '<tr>
                                        <th colspan="2" class="text-right">'.$row->exp_name.'</th>
                                        <td class="text-right">'.sprintf('%.2f',$expAmt).'</td>
                                    </tr>';
                                endif;
                                $rwspan++;
                            endif;
                        endif;
                    endforeach;

                    $taxHtml = '';$totalTaxAmount = 0;
                    foreach ($taxList as $taxRow) :
                        $taxAmt = 0;
                        $taxAmt = floatVal($invData->{$taxRow->map_code.'_amount'});
                        if(!empty($taxAmt)):
                            if($rwspan == 0):
                                $taxHtml .= '<th colspan="2" class="text-right">'.$taxRow->name.' @'.(($invData->gst_type == 1)?floatVal($migst/2):$migst).'%</th>
                                <td class="text-right">'.sprintf('%.2f',$taxAmt).'</td>';
                            else:
                                $taxHtml .= '<tr>
                                    <th colspan="2" class="text-right">'.$taxRow->name.' @'.(($invData->gst_type == 1)?floatVal($migst/2):$migst).'%</th>
                                    <td class="text-right">'.sprintf('%.2f',$taxAmt).'</td>
                                </tr>';
                            endif;
                            $totalTaxAmount += $taxAmt;
                            $rwspan++;
                        endif;
                    endforeach;

                    foreach ($expenseList as $row) :
                        $expAmt = 0;
                        $amtFiledName = $row->map_code . "_amount";
                        if (!empty($invExpenseData) && $row->map_code != "roff") :
                            $expAmt = floatVal($invExpenseData->{$amtFiledName});
                        endif;

                        if(!empty($expAmt)):
                            if ($row->position == 2) :
                                if($rwspan == 0):
                                    $afterExp .= '<th colspan="2" class="text-right">'.$row->exp_name.'</th>
                                    <td class="text-right">'.sprintf('%.2f',$expAmt).'</td>';
                                else:
                                    $afterExp .= '<tr>
                                        <th colspan="2" class="text-right">'.$row->exp_name.'</th>
                                        <td class="text-right">'.sprintf('%.2f',$expAmt).'</td>
                                    </tr>';
                                endif;
                                $rwspan++;
                            endif;
                        endif;
                    endforeach;

                    $fixRwSpan = (!empty($rwspan))?3:0;
                ?>
                <tr>
                    <th colspan="3" class="text-right">Total Qty.</th>
                    <th class="text-right"><?=floatval($totalQty)?></th>
                    <!--<th></th>-->
                    <th colspan="2" class="text-right">Sub Total</th>
                    <th class="text-right"><?=sprintf('%.2f',$invData->taxable_amount)?></th>
                </tr>
                <tr>
                    <td class="text-left" colspan="4" rowspan="<?=$rwspan?>">
                        <b>Bank Name : </b> <?=$companyData->company_bank_name.", ".$companyData->company_bank_branch?><br>
                        <b>A/c. No. : </b><?=$companyData->company_acc_no?><br>
                        <b>IFSC Code : </b><?=$companyData->company_ifsc_code?>
                        <hr>
                        <b>Note : </b> <?=$invData->remark?>
                    </td>
                    <?php if(empty($rwspan)): ?>
                        <th colspan="2" class="text-right">Round Off</th>
                        <td class="text-right"><?=sprintf('%.2f',$invData->round_off_amount)?></td>
                    <?php endif; ?>
                </tr>
                <?=$beforExp.$taxHtml.$afterExp?>
                <tr>
                    <td class="text-left" colspan="4" rowspan="<?=$fixRwSpan?>">
                        <b>GST Amount (In Words)</b> : <?=($totalTaxAmount > 0)?numToWordEnglish(sprintf('%.2f',$totalTaxAmount)):""?>
                        <hr>
                        <b>Bill Amount (In Words)</b> : <?=numToWordEnglish(sprintf('%.2f',$invData->net_amount))?>
                    </td>	
                    
                    <?php if(empty($rwspan)): ?>
                        <th colspan="2" class="text-right">Grand Total</th>
                        <th class="text-right"><?=sprintf('%.2f',$invData->net_amount)?></th>
                    <?php else: ?>
                        <th colspan="2" class="text-right">Round Off</th>
                        <td class="text-right"><?=sprintf('%.2f',$invData->round_off_amount)?></td>
                    <?php endif; ?>
                </tr>
                
                <?php if(!empty($rwspan)): ?>
                <tr>
                    <th colspan="2" class="text-right">Grand Total</th>
                    <th class="text-right"><?=sprintf('%.2f',$invData->net_amount)?></th>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- <table class="table top-table" style="margin-top:10px;width:92%;">
            <tr>
                <th class="text-left">
                    <h4>Terms & Conditions :-</h4>
                </th>
            </tr>
            <?php
                /* if(!empty($invData->termsConditions)):
                    foreach($invData->termsConditions as $row):
                        echo '<tr>';
                            //echo '<th class="text-left fs-11" style="width:140px;">'.$row->term_title.'</th>';
                            echo '<td class=" fs-11"><ul><li> '.$row->condition.' </li></ul></td>';
                        echo '</tr>';
                    endforeach;
                endif; */
            ?>
        </table> -->

        <htmlpagefooter name="lastpage">
            <table style="border-top:1px solid #545454;margin-top:10px;width:92%;">
                <tr>
                    <th class="text-left" style="width:60%;">
                        <h4>Terms & Conditions :-</h4>
                    </th>
                    <th style="vertical-align:bottom;text-align:right;font-size:1rem;padding:5px 2px;">
                        For, <?=$companyData->company_name?><br>
                    </th>
                </tr>
                <tr>
                    <td class="fs-11">
                        1. Goods once sold will not be taken back<br>
                        2. Interest 18% pa. will be charged if payment is not received within Due date.<br>
                        3. Our risk and responsibility ceases as soon as the material leaves our premises.<br>
                        4. Subject To RAJKOT Jurisdiction Only E.&O.E. 
                    </td>
                    <td height="35"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align:bottom;text-align:right;font-size:1rem;padding:5px 2px;"><b>Authorised Signature</b></td>
                </tr>
            </table>
        </htmlpagefooter>
		<sethtmlpagefooter name="lastpage" value="on" />    
    </div>
</div>