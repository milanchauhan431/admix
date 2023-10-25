<form>
    <div class="action-sheet-content">
        <table class="table table-bordered bg-light">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-left"> Brand Name</th>
                    <th class="text-right">Balance Qty.</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    if(!empty($stockTransData)):
                        foreach($stockTransData as $row):
                            echo '<tr>';
                                echo '<td class="text-center">'.$i++.'</td>';
                                echo '<td>'.$row->batch_no.'</td>';
                                echo '<td class="text-center">'.$row->stock_qty.'</td>';
                        endforeach;
                    endif;
                ?>
            </tbody>
        </table>
    </div>
</form>
