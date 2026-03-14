<style>
    .styled-table {
        width: 95%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 14px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .styled-table thead {
        background-color: #0099cc;
        color: black;
    }

    .styled-table thead th {
        padding: 10px;
        text-align: left;
    }

    .styled-table tbody td {
        padding: 8px 10px;
        border-bottom: 1px solid #ddd;
    }

    .styled-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .styled-table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>
<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/Hr/add_notification_manage_data'; ?>"
        autocomplete="off" enctype="multipart/form-data">


        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Select Page Name<span style="color: red;"> * </span></label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm" name="page_name" required
                    onchange="get_page_wise_group_name();">
                    <option value="">Select Page</option>
                    <?php foreach ($master as $m): ?>
                        <option value="<?php echo $m->notify_id; ?>"><?php echo $m->page_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label class="col-sm-2 col-form-label">Select Group Name<span style="color: red;"> * </span></label>
            <div class="col-sm-3">
                <select class="form-control select2" multiple name="group_id[]" id="group_id" required
                    onchange="get_group_wise_list()">
                    <?php foreach ($group as $g): ?>
                        <option value="<?php echo $g->group_id; ?>"><?php echo $g->group_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>


        <div class="form-group row mt-3" id="group_wise_user_list">
            <!-- Table will be generated here -->
        </div>
        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <input type="submit" class="btn btn-sm btn-primary" value="Submit">
            </div>
        </div>

    </form>
</div>
</div>
<script>
    function get_page_wise_group_name() {
        var pageId = $('select[name="page_name"]').val();

        if (!pageId) {
            $('#group_id').val(null).trigger('change'); // Clear groups
            $('#group_wise_user_list').html('');
            return;
        }

        $.ajax({
            url: "<?php echo base_url('index.php/Hr/get_page_wise_groups_ajax'); ?>",
            type: "POST",
            data: { page_id: pageId },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    const groupIds = response.group_ids;

                    // ✅ Set selected values in group select
                    $('#group_id').val(groupIds).trigger('change');

                    // ✅ Call your table population function
                    get_group_wise_list();
                } else {
                    alert(response.message || 'No groups found');
                    $('#group_id').val(null).trigger('change');
                    $('#group_wise_user_list').html('');
                }
            },
            error: function () {
                alert('Failed to fetch group data');
            }
        });
    }


    function get_group_wise_list() {
        var selected = $('select[name="group_id[]"]').val();

        if (!selected || selected.length === 0) {
            $('#group_wise_user_list').html('');
            return;
        }

        $.ajax({
            url: "<?php echo base_url('index.php/Hr/group_user_details_ajax'); ?>",
            type: "POST",
            data: { group_ids: selected },
            dataType: "json",
            success: function (response) {
                if (response.length === 0) {
                    $('#group_wise_user_list').html('<div class="text-muted">No data found.</div>');
                    return;
                }

                var table = '<table class="styled-table">';
                table += '<thead><tr><th>Group Name</th><th>User List</th></tr></thead><tbody>';

                response.forEach(function (row) {
                    table += '<tr>';
                    table += '<td>' + row.group_name + '</td>';
                    table += '<td>' + row.user_list + '</td>';
                    table += '</tr>';
                });

                table += '</tbody></table>';

                $('#group_wise_user_list').html(table);
            },
            error: function () {
                $('#group_wise_user_list').html('<div class="text-danger">Failed to load data</div>');
            }
        });
    }
</script>