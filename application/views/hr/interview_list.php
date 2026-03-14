<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>INT CODE</th>
					<th>Requisition Code</th>
                    <th>Position</th>
					<th>Name</th>
					<th>Shortlisted</th>
					<th>Visa</th>
					<th>Exp.Sal</th>
					<th>Agree</th>
					<th>Interview Status</th>
					<th>HR Approval</th>
                    <th>HOD Approval</th>
					<th>CEO Approval</th>
                    <th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;//print_r($records);
				foreach ($records as $row) { 
                    $hr_app = 0;$hod_app = 0; $hr_approval =" ";$dept_hod_approval =" ";$ceo_app = 0;
$ceo_approval = " ";
                    if($row->h_app == '0' || $row->h_app == ' ' || empty($row->h_app)) 
						$hr_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->h_app == '1'){
						$hr_approval ="<span style='color:green;'>Approved</span>";
						$hr_app = 1;
					} 
                    else if($row->h_app == '2') 
                        $hr_approval ="<span style='color:red;'>Not Approved</span>";
                    
                    if($row->hod_app == '0' || $row->hod_app == ' ' || empty($row->hod_app)) 
                        $dept_hod_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->hod_app == '1'){
						$dept_hod_approval ="<span style='color:green;'>Approved</span>";
						$hod_app = 1;
					} 
                    else if($row->hod_app == '2') 
                        $dept_hod_approval ="<span style='color:red;'>Not Approved</span>";
                        
					if($row->ceo_app == '0' || $row->ceo_app == ' ' || empty($row->ceo_app)) 
                        $ceo_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->ceo_app == '1'){
						$ceo_approval ="<span style='color:green;'>Approved</span>";
						$ceo_app = 1;
					} 
                    else if($row->ceo_app == '2') 
                        $ceo_approval ="<span style='color:red;'>Not Approved</span>";?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						<td>
							<?php echo $row->int_code; ?>
						</td>
						<td>
							<?php echo $row->emp_req_code; ?>
						</td>
						<td>
							<?php echo $row->designation_name; ?>
						</td>
						<td>
							<?php echo $row->name; ?>
						</td>
						<td>
							<?php echo $row->shortlisted; ?>
						</td>
						<td>
							<?php echo $row->visa; ?>
						</td>
					
						<td>
							<?php echo $row->expected_salary; ?>
						</td>
                        <td>
							<?php echo $row->work_agree; ?>
						</td>
						<td>
							<?php echo $row->recommendation; ?>
						</td>
                        <td>
							<?php echo $hr_approval; ?>
						</td>
                        <td>
							<?php echo $dept_hod_approval; ?>
						</td>
						<td>
							<?php echo $ceo_approval; ?>
						</td>
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_interview/'.$row->int_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url() . 'index.php/Hr/list_interview/'; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->int_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


								<?php if($hod_app == 1 && $hr_app == 1 && $ceo_app == 1){?>
								<div class="copy-container">
									  <a href="javascript:void(0);" onclick="copyToClipboard(this, '<?php echo base_url('index.php/Client/add_joining_application/' . encrypt_id($row->int_id)); ?>')" title="Copy Link">

									<i class="fa fa-copy" style="font-size: 18px; cursor: pointer;"></i>
									</a>
									<div class="copy-toast">Copied!</div>
								</div>
							<?php }?>

							<?php /*if($hod_app == 1 && $hr_app == 1){?>
								<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_offerletter/'.$row->int_id ; ?>"
									title="Download Job Description"><i class="fa fa-print" style="font-size:18px"></i></a>	
							<?php }*/?>
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

<style>
	.copy-container {
      position: relative;
      display: inline-block;
    }

    .copy-toast {
		position: absolute;
		top: -35px;
		left: -20px; /* ← shift left */
		display: none;
		background-color: #28a745;
		color: white;
		padding: 4px 8px;
		border-radius: 4px;
		font-size: 14px;
		white-space: nowrap;
		box-shadow: 0 2px 5px rgba(0,0,0,0.2);
		z-index: 100;
		}

		.copy-toast::after {
			content: "";
			position: absolute;
			bottom: -5px;
			left: 30px; /* adjust to match new toast position */
			border-width: 5px;
			border-style: solid;
			border-color: #28a745 transparent transparent transparent;
			}
</style>
<!-- Static Table End -->



<script>
	function confirmcancel(tid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'employee_interview',
					where_key: 'int_id',
					where_val: tid
				},
				success: function (msg) {
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

function copyToClipboard(elem, text) {
      if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
          showToastNear(elem);
        }).catch(err => {
          alert("Failed to copy: " + err);
        });
      } else {
        fallbackCopy(text, elem);
      }
    }

    function showToastNear(elem) {
      const toast = elem.parentElement.querySelector('.copy-toast');
      toast.style.display = 'block';
      setTimeout(() => {
        toast.style.display = 'none';
      }, 2000);
    }

    function fallbackCopy(text, elem) {
      const tempInput = document.createElement("textarea");
      tempInput.value = text;
      document.body.appendChild(tempInput);
      tempInput.select();
      try {
        document.execCommand("copy");
        showToastNear(elem);
      } catch (err) {
        alert("Fallback failed: " + err);
      }
      document.body.removeChild(tempInput);
    }



</script>