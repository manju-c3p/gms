<?php ini_set('display_errors', 1); error_reporting(E_ALL); ?>
<?php $this->load->helper('form'); ?>

<div class="card-body">
  <form class="form-horizontal" action="<?= base_url('index.php/accounts/trial_balance') ?>" method="post" id="receipt" name="receipt" onsubmit="return goToUrlWithDates()">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="from_date">From</label>
      <div class="col-sm-3">
      <div class="input-group">
             <input type="text" class="form-control datepicker" name="from_date" id="from_date"
    value="<?= isset($from_date) ? $from_date : date('d-m-Y') ?>" required>
                           
          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        </div>
      </div>

      <label class="col-sm-2 col-form-label" for="to_date">To</label>
      <div class="col-sm-3">
       <div class="input-group">
        <input type="text" class="form-control datepicker" name="to_date" id="to_date"
    value="<?= isset($to_date) ? $to_date : date('d-m-Y') ?>" required>       
          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        </div>
      </div>

      <div class="col-sm-2">
        <button type="submit" class="btn btn-sm btn-primary">View</button>
      </div>
    </div>
  </form>

  <div class="d-flex align-items-center mt-3 gap-2">
    <form method="post" action="<?= base_url('index.php/Accounts/trial_balance_export') ?>">
      <input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date) ?>" />
      <input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date) ?>" />
      <button type="submit" class="btn btn-warning btn-sm">Export to Excel</button>
    </form>

    <form method="post" action="<?= base_url('index.php/Accounts/trial_balance_print') ?>" target="_blank">
      <input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date) ?>" />
      <input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date) ?>" />
      <button type="submit" class="btn btn-warning btn-sm">Print</button>
    </form>
  </div>

  <div class="form-group row mt-4">
    <div class="col-md-12">
      <table class="table table-bordered table-sm" style="font-size:12px;">
        <thead class="table-light">
          <tr>
            <th>Group</th>
            <th>Ledger</th>
            <th class="text-end">Debit</th>
            <th class="text-end">Credit</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (!empty($accounts)) {
            $current_group = null;
            foreach ($accounts as $row):
              if ($current_group !== $row['group_name']):
                if ($current_group !== null && isset($group_totals[$current_group])):
                  $gt = $group_totals[$current_group];
                  ?>
                  <tr class="table-secondary fw-bold">
                    <td colspan="2">Total for <?= htmlspecialchars($current_group) ?></td>
                    <td class="text-end"><?= number_format($gt['debit'], 2) ?></td>
                    <td class="text-end"><?= number_format($gt['credit'], 2) ?></td>
                  </tr>
                  <?php
                endif;
                ?>
                <tr class="table-primary"><td colspan="4"><strong><?= htmlspecialchars($row['group_name']) ?></strong></td></tr>
                <?php
                $current_group = $row['group_name'];
              endif;
              ?>
              <tr>
                <td></td>
                <td><?= htmlspecialchars($row['account_name']) ?></td>
                <td class="text-end"><?= number_format($row['debit'], 2) ?></td>
                <td class="text-end"><?= number_format($row['credit'], 2) ?></td>
              </tr>
            <?php endforeach;

            // Last group total
            if ($current_group !== null && isset($group_totals[$current_group])):
              $gt = $group_totals[$current_group];
              ?>
              <tr class="table-secondary fw-bold">
                <td colspan="2">Total for <?= htmlspecialchars($current_group) ?></td>
                <td class="text-end"><?= number_format($gt['debit'], 2) ?></td>
                <td class="text-end"><?= number_format($gt['credit'], 2) ?></td>
              </tr>
            <?php endif;
          } else { ?>
            <tr><td colspan="4" class="text-center">No data available.</td></tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI JavaScript -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
$(function () {
  $(".datepicker").datepicker({
    dateFormat: 'dd-mm-yy', // Must match the format in input
    changeMonth: true,
    changeYear: true
  }).each(function () {
    const val = $(this).val();
    if (val) {
      try {
        // Explicitly parse and set date
        const parsed = $.datepicker.parseDate('dd-mm-yy', val);
        $(this).datepicker('setDate', parsed);
      } catch (e) {
        console.warn("Invalid date format in input:", val);
      }
    }
  });
});

function goToUrlWithDates() {
  const fromDate = $("#from_date").datepicker("getDate");
  const toDate = $("#to_date").datepicker("getDate");

  if (!fromDate || !toDate) {
    alert('Please select both From and To dates.');
    return false;
  }

  if (fromDate > toDate) {
    alert('From date cannot be greater than To date.');
    return false;
  }

  function formatDate(d) {
    const dd = String(d.getDate()).padStart(2, '0');
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const yyyy = d.getFullYear();
    return dd + '-' + mm + '-' + yyyy;
  }

  const fromStr = formatDate(fromDate);
  const toStr = formatDate(toDate);
  const baseUrl = '<?= base_url("index.php/accounts/trial_balance") ?>';

  window.location.href = `${baseUrl}/${fromStr}/${toStr}`;
  return false;
}
// $("#from_date, #to_date").change(function() {
//   let val = $(this).val();
//   let date = $.datepicker.parseDate("dd-mm-yy", val);
//   $(this).val($.datepicker.formatDate("dd-mm-yy", date));
// });
</script>
