
<style>
	@media print {
    body {
        margin: 0;
    }

    .btn, form {
        display: none !important;
    }

    .bs-container {
        display: flex !important;
    }

    .bs-column {
        width: 50% !important;
    }
}

body.modal-open {
    overflow: hidden;
    padding-right: 0 !important;
}

/* Force scrollbar always visible */
html {
    overflow-y: scroll;
}
thead { display: table-header-group; }
tfoot { display: table-footer-group; }

tfoot td {
    height: 0;
    padding: 0;
}
/* Layout */
.bs-container {
    display: flex;
    gap: 20px;
}

.bs-column {
    width: 50%;
}

/* Table Styling */
.bs-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.bs-table th {
    background: #f5f5f5;
    font-weight: 600;
}

.bs-table th,
.bs-table td {
    border: 1px solid #ccc;
    padding: 6px;
}

.text-right {
    text-align: right;
}

/* Divider line before total */
.divider {
    border-bottom: 2px solid #000 !important;
    padding: 0 !important;
    height: 5px;
}

/* Status */
.bs-status {
    margin-top: 15px;
    font-weight: bold;
}

.bs-status .ok {
    color: green;
}

.bs-status .error {
    color: red;
}
</style>
<?php 
// $this->load->helper('Account_helper.php');
 ?>
<div class="card-body">

	<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Accounts/view_balance_sheet_new" class="form-horizontal" autocomplete="off" name="question" id="question" enctype="multipart/form-data">
		<div class="form-group row">
			     <!-- <label class="col-sm-1 col-form-label">From <span style="color: red;">*</span></label> -->
              <div class="col-sm-2">
                <input tabindex="1" type="hidden" class="form-control" id="from" name="from" value="<?php echo $from; ?>"
                  required>
              </div>

              <label class="col-sm-1 col-form-label">Till Date <span style="color: red;">*</span></label>
              <div class="col-sm-2">
                <input tabindex="2" type="date" class="form-control" id="to" name="to" value="<?php echo $to; ?>"
                  required>
              </div>
		
		            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
				 <input type="submit" id="view" name="go" value="Go" class="btn btn-sm btn-primary m-b-0" /> <button onclick="printBalanceSheet()" class="btn btn-success btn-sm">
				Print
			</button>
			    </div>
			</div>          
		    </form>
		   
	    <div class="row">

<?php
$asset_total = array_sum(array_map(fn($g) => $g->balance, $assets));
$liab_total  = array_sum(array_map(fn($g) => $g->balance, $liabilities));
?>
<div id="printArea">

    <!-- HEADER -->
    <div style="text-align:center; margin-bottom:15px;">
       
        <small><?php echo $from; ?> to <?php echo $to; ?></small>
    </div>

    <!-- TWO COLUMN LAYOUT -->
    <div class="bs-container">
<!-- LIABILITIES -->
        <div class="bs-column">
            <table class="bs-table tree">
                <thead>
                    <tr>
                        <th>Liabilities</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $row_id = 1000;
                    if(empty($liabilities)): ?>
                        <tr><td colspan="2">No Data</td></tr>
                    <?php endif;

                    render_tree_rows($liabilities, $row_id); 
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="divider"></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th class="text-right"><?php echo number_format($liab_total, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- ASSETS -->
        <div class="bs-column">
            <table class="bs-table tree">
                <thead>
                    <tr>
                        <th>Assets</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $row_id = 1;
                    if(empty($assets)): ?>
                        <tr><td colspan="2">No Data</td></tr>
                    <?php endif;

                    render_tree_rows($assets, $row_id); 
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="divider"></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th class="text-right"><?php echo number_format($asset_total, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        

    </div>

    <!-- STATUS -->
    <div class="bs-status">
        <?php if (round($asset_total,2) == round($liab_total,2)): ?>
            <span class="ok">✔ Balance Sheet Tallies</span>
        <?php else: ?>
            <span class="error">✖ Not Tally (Difference: <?php echo number_format(abs($asset_total - $liab_total),2); ?>)</span>
        <?php endif; ?>
    </div>

</div>
		

<!-- DRILLDOWN MODAL -->
<div id="drillModal" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    
      <div class="modal-header">
        
        <h4 class="modal-title">Ledger Drilldown</h4>
      </div>


      <div class="modal-body">
        <div id="drillContent">Loading...</div>
      </div>
 <!-- FOOTER -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">
            Close
        </button>
      </div>
    </div>
  </div>
</div>
            	</div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Static Table End -->

<?php 

function render_tree_rows($groups, &$row_id = 1, $parent_id = 0, $level = 0)
{
    
    foreach ($groups as $group) {  
        if (round($group->balance, 2) == 0) {
            continue;
        }
        $current_id = $row_id++;
        $parent_class = $parent_id ? "treegrid-parent-$parent_id" : "";

        echo "<tr class='treegrid-$current_id $parent_class'>";

        echo "<td style='padding-left:" . ($level * 20) . "px; font-weight:bold;'>";
        echo $group->group_name;
        echo "</td>";

        echo "<td style='text-align:right; font-weight:bold;'>";
        echo number_format(abs($group->balance), 2);
        echo "</td>";

        echo "</tr>";

        // Ledgers
        if (!empty($group->ledgers)) {
        foreach ($group->ledgers as $ledger) {

            if (round($ledger->balance, 2) == 0) {
                continue; // skip zero balance
            }

                $ledger_id = $row_id++;

                echo "<tr class='treegrid-$ledger_id treegrid-parent-$current_id'>";
                
                echo "<td style='padding-left:" . (($level + 1) * 20) . "px'>";
 global $from, $to;
echo "<a href='" . base_url() . "index.php/Accounts/drilldown?account_id=" 
    . $ledger->account_id . "&from=" . $from . "&to=" . $to . "'>";

echo $ledger->name;

echo "</a>";
echo "<a href='javascript:void(0);' 
        class='drilldown-link' 
        data-id='" . $ledger->account_id . "' 
        data-from='" . $from . "' 
        data-to='" . $to . "'>";

echo $ledger->name;

echo "</a>";



echo "</td>";

                echo "<td style='text-align:right'>";
                echo ($ledger->balance < 0 ? '(' : '') . number_format(abs($ledger->balance), 2) . ($ledger->balance < 0 ? ')' : '');
                echo "</td>";

                echo "</tr>";
            }
        }

        // Children
        if (!empty($group->children)) {
            render_tree_rows($group->children, $row_id, $current_id, $level + 1);
        }
    }
}


?>

 <script type="text/javascript">
      
function printBalanceSheet() {

    // if ($.fn.treegrid) {
    //     $('.tree').treegrid('expandAll');
    // }

    var content = document.getElementById('printArea').innerHTML;

    var myWindow = window.open('', '', 'width=1000,height=700');

    myWindow.document.write(`
        <html>
        <head>
            <title>Balance Sheet</title>
            <style>
                body { 
                    font-family: Arial; 
                    font-size: 13px; 
                    margin: 20px; 
                    color: #000;
                }

                h2 {
                    text-align: center;
                    margin-bottom: 5px;
                }

                .date-range {
                    text-align: center;
                    margin-bottom: 15px;
                    font-size: 12px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th {
                    background: #e9ecef;
                    font-weight: bold;
                    text-align: left;
                    padding: 8px;
                    border: 1px solid #000;
                }

                td {
                    padding: 6px 8px;
                    border: 1px solid #000;
                }

                .text-right {
                    text-align: right;
                }

                .section-title {
                    font-weight: bold;
                    background: #f5f5f5;
                }

                .sub {
                    padding-left: 20px;
                }

                .total {
                    font-weight: bold;
                    border-top: 2px solid #000;
                }

                .grand-total {
                    font-weight: bold;
                    background: #e9ecef;
                }
            </style>
        </head>
        <body>

            <h2>Balance Sheet</h2>

            <table>
                <thead>
                    <tr>
                        <th>Assets</th>
                        <th class="text-right">Amount</th>
                        <th>Liabilities & Equity</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    ${formatSingleTable()}
                </tbody>
            </table>

        </body>
        </html>
    `);

    myWindow.document.close();

    myWindow.onload = function () {
        myWindow.focus();
        myWindow.print();
        myWindow.close();
    };
}

function formatSingleTable() {

    let assetRows = [];
    let liabRows = [];

    // Include BOTH tbody + tfoot
    document.querySelectorAll('.bs-column:nth-child(1) table tr').forEach(tr => {
        assetRows.push(tr.innerHTML);
    });

    document.querySelectorAll('.bs-column:nth-child(2) table tr').forEach(tr => {
        liabRows.push(tr.innerHTML);
    });

    let max = Math.max(assetRows.length, liabRows.length);
    let html = '';

    for (let i = 0; i < max; i++) {
        html += '<tr>';

        html += assetRows[i] 
            ? assetRows[i] 
            : '<td></td><td></td>';

        html += liabRows[i] 
            ? liabRows[i] 
            : '<td></td><td></td>';

        html += '</tr>';
    }

    return html;
}
$(document).ready(function() {

    // $('.tree').treegrid({
    //     initialState: 'collapsed',
    //     expanderExpandedClass: 'glyphicon glyphicon-minus',
    //     expanderCollapsedClass: 'glyphicon glyphicon-plus'
    // });

    if(!$('#from').val()){
        let today = new Date();
        let year = today.getFullYear();

        $('#from').val(year + '-01-01');
        $('#to').val(today.toISOString().split('T')[0]);
    }
});

$(document).on('click', '.drilldown-link', function () {

    let account_id = $(this).data('id');
    let from = $(this).data('from');
    let to = $(this).data('to');

    $('#drillModal').modal('show');
    $('#drillContent').html('Loading...');

    $.ajax({
        url: "<?php echo base_url('index.php/Accounts/drilldown_balance_sheet'); ?>",
        type: "GET",
        data: {
            account_id: account_id,
            from: from,
            to: to
        },
        success: function (response) {
            $('#drillContent').html(response);
        },
        error: function () {
            $('#drillContent').html('<p style="color:red;">Error loading data</p>');
        }
    });

});
$(document).on('click', '.modal .close, .modal .btn-default', function () {
    $('#drillModal').modal('hide');
});

        </script>
