<div class="card-body">
    <div class="dt-responsive table-responsive">
        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Allowances Type</th>
                    <th>Allowance Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td><?php echo $i;
                            $i++; ?></td>
                        <td>
                            <?php echo ($row->allowance_type == 'A') ? "Allowances" : (($row->allowance_type == 'D') ? "Deductions" : ""); ?>
                        </td>

                        <td><?php echo $row->allowance_name; ?></td>


                        <td>
                            <a href="<?php echo base_url() . 'index.php/Hr/edit_allowances/' . $row->sno; ?>" title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo base_url() . 'index.php/Hr/delete_Allowances/' . $row->sno; ?>" title="Delete" onclick="return confirmcancel(<?php echo $row->sno; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>

                        </td>
                    </tr>
                <?php  } ?>
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
    function confirmcancel(tid) {
        var r = confirm("Are you sure you want to Delete Record?");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
                type: "POST",
                data: {
                    table_name: 'allowance_master',
                    where_key: 'sno',
                    where_val: tid
                },
                success: function(msg) {
                    if (msg == 1) {
                        // alert("Record deleted");
                        window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
                    } else {
                        alert("Can't Delete record. Data already exist!!!");
                    }
                },
            });
            return true;
        } else
            return false;

    }
</script>