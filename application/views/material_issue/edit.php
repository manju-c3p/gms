<h2>Edit Material Issue</h2>

<div class="alert alert-warning">
    ⚠ Editing issued quantities will automatically adjust inventory stock.
</div>

<form method="post" action="<?= base_url('MaterialIssue/update') ?>">
    <input type="hidden" name="issue_id" value="<?= $issue->issue_id ?>">

    <div class="row mb-3">
        <div class="col">
            <label>Job Card</label>
            <input class="form-control" value="<?= $jobcard->jobcard_no ?>" readonly>
        </div>
        <div class="col">
            <label>Issue No</label>
            <input class="form-control" value="<?= $issue->issue_no ?>" readonly>
        </div>
        <div class="col">
            <label>Issue Date</label>
            <input class="form-control" value="<?= $issue->issue_date ?>" readonly>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Part</th>
                <th>Planned Qty</th>
                <th>Issued (This Issue)</th>
                <th>Edit Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <?php
                    $remaining = $item->planned_qty - $item->issued_qty;
                ?>
                <tr>
                    <td><?= $item->part_name ?></td>
                    <td><?= $item->planned_qty ?></td>
                    <td><?= $item->issued_qty ?></td>
                    <td style="width:150px">
                        <input type="number"
                               name="items[<?= $item->issue_item_id ?>]"
                               class="form-control"
                               min="0"
                               max="<?= $remaining + $item->issued_qty ?>"
                               value="<?= $item->issued_qty ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Update Issue</button>
    <a href="<?= base_url('MaterialIssue/view/' . $jobcard->jobcard_id) ?>"
       class="btn btn-secondary">Cancel</a>
</form>
