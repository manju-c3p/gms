<style>
    .tooltip-list {
        display: none;
        position: absolute;
        background: #fff;
        border: 1px solid #ccc;
        padding: 10px;
        z-index: 9999;

        width: 400px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        white-space: normal;
        max-height: 200px;
        overflow-y: auto;
    }

    .group-name:hover .tooltip-list {
        display: block;
    }

    .table-responsive,
    .card-body {
        overflow: visible !important;
        position: relative;
    }
</style>
<div class="card-body">
    <div class="dt-responsive table-responsive">
        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Page Name</th>
                    <th>Group Name</th>
                    <th>Date</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td><?php echo $i;
                        $i++; ?></td>
                        <td><?php echo $row->page_name; ?></td>
                        <td class="group-name"
                            data-group-ids="<?php echo htmlspecialchars(json_encode($row->group_ids)); ?>">
                            <?php echo $row->group_names; ?>
                            <div class="tooltip-list"></div>
                        </td>


                        <td><?php echo date('d-M-Y', strtotime($row->created_date)); ?></td>

                        <!-- <td>

                            <a href="javascript:void(0);" title="Delete"
                                onclick="return confirmcancel(<?php echo $row->notify_id; ?>);">
                                <?php echo $this->session->userdata('delete_icon'); ?>
                            </a>

                        </td> -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Static Table End -->



<script>
    function confirmcancel(notify_id) {
        if (confirm("Are you sure you want to delete this group?")) {
            $.ajax({
                url: "<?php echo base_url('index.php/Hr/delete_notification_manage'); ?>",
                type: "POST",
                data: { notify_id: notify_id },
                success: function (response) {
                    if (response == 1) {
                        alert("Group deleted successfully.");
                        window.location.reload();
                    } else {
                        alert("Cannot delete group. Users are assigned to it.");
                    }
                },
                error: function () {
                    alert("An error occurred while deleting.");
                }
            });
        }
        return false;
    }


    $(document).ready(function () {
        $('.group-name').hover(function () {
            var cell = $(this);
            var groupIds = cell.data('group-ids'); // array from JSON

            if (!groupIds || groupIds.length === 0) return;

            var tooltipDiv = cell.find('.tooltip-list');

            if (tooltipDiv.is(':empty')) {
                $.ajax({
                    url: "<?php echo base_url('index.php/hr/user_list_groupid_wise_bulk'); ?>", // New method
                    type: "POST",
                    data: { group_ids: groupIds },
                    dataType: "html",
                    success: function (response) {
                        tooltipDiv.html(response);
                    },
                    error: function () {
                        tooltipDiv.html('<em>Failed to load users</em>');
                    }
                });
            }
        });
    });
</script>