<div class="card-body">
    <div class="dt-responsive table-responsive">
        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Approve Type </th>
                    <th>Level One(HR/Manager)</th>
                    <th>Level Two(Admin /MD)</th>
                    <th>Level Two(CEO)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td>
                            <?php echo $i++; ?>
                        </td>
                        <td>
                            <?php echo $row->approve_type; ?>
                        </td>




                        <td><?php foreach ($user_records as $hr) { ?><?php if ($hr->user_id == $row->approve_hr) { ?><?php echo $hr->user_name; ?><?php } ?>
                            <?php } ?>
                        </td>


                        <td><?php foreach ($user_records as $hr) { ?><?php if ($hr->user_id == $row->approve_admin_md) { ?><?php echo $hr->user_name; ?><?php } ?>
                            <?php } ?>
                        </td>
                        <td><?php foreach ($user_records as $hr) { ?><?php if ($hr->user_id == $row->approve_ceo) { ?><?php echo $hr->user_name; ?><?php } ?>
                            <?php } ?>
                        </td>


                        <td>

                            <a href="<?php echo base_url() . 'index.php/Hr/approval_setup_edit/' . $row->approve_id; ?>"
                                title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="#" title="Delete" onclick="return confirmCancel(<?php echo $row->approve_id; ?>);">
                                <?php echo $this->session->userdata('delete_icon'); ?>
                            </a>


                        </td>
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
<!-- Static Table End -->

<script>
    function confirmCancel(tid) {
        // Show the confirmation prompt
        if (confirm("Are you sure you want to delete this record?")) {
            // If confirmed, send the AJAX request
            $.ajax({
                url: "<?php echo base_url('index.php/Ajax/delete_record'); ?>",
                type: "POST",
                data: {
                    table_name: 'approval_setup',
                    where_key: 'approve_id',
                    where_val: tid
                },
                success: function (response) {
                    if (response == 1) {
                        // If successful, reload the current page
                        window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>";
                    } else {
                        // If an error occurs, show an alert
                        alert("Can't delete record. Data already exists!");
                    }
                }
            });
        }
        // Return false to prevent the default anchor action
        return false;
    }
</script>