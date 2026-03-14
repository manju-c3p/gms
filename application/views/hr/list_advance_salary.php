<div class="card-body">
    <div class="dt-responsive table-responsive">
        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <!-- <th>AS Code</th> -->
                    <th>Employee Name</th>
                    <th>From date</th>
                    <th>To date</th>
                    <th>Deduction Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <!-- <td><?php echo $row->as_code; ?></td> -->
                        <td><?php echo $row->user_name; ?></td>


                        <td><?php echo date('d-M-Y', strtotime($row->form_date)); ?></td>


                        <td><?php echo date('d-M-Y', strtotime($row->to_date)); ?></td>
                        <td><?php echo $row->deduction_amount; ?></td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/Hr/edit_advance_salary/' . $row->as_id; ?>" title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>
                            <a href="<?php echo base_url() . 'index.php/Hr/delete_advance_salary/' . $row->as_id; ?>" title="Delete" onclick="return confirmcancel(<?php echo $row->as_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
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
                    table_name: 'advance_salary',
                    where_key: 'as_id',
                    where_val: tid
                },
                success: function(msg) {
                    if (msg == 1) {

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