<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>SR No</th>
					<th>User Name</th>
					<th>Department</th>
					<th>Position</th>
					<th>Application Form</th>
                    <th>Interview Assesment</th>
					<th>Joining Form</th>
					<th>CV</th>
                    <th>Passport</th>
					<th>Photo</th>
                    <th>Offer Letter</th>
					<th>Contract Form</th>
                    <th>Insurance</th>
                    <th>Labor Payment</th>
					<th>Medical Fitness</th>
					<th>EID</th>
					<th>Visa</th>
					<th>Iloe Insurance</th>
					<th>Labor Card</th>
					<th>Degree Certificate</th>
					<th>Induction</th>
					<th>Job Desc</th>
					<th>Driving Licence</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($records as $row) { 
                    
                    ?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						
						<td>
							<?php echo $row->user_name.' '.$row->middle_name.' '.$row->last_name; ?>
						</td>
						<td>
							<?php echo $row->dept_name; ?>
						</td>
						<td>
							<?php echo $row->designation_name; ?>
						</td>
						
						<td>
							<?php echo $row->application_form; ?>
						</td>
						<td>
							<?php echo $row->interview_form; ?>
						</td>
						<td>
							<?php echo $row->joining_form; ?>
						</td>
						<td>
							<?php echo $row->cv; ?>
						</td>
						<td>
							<?php echo $row->passport_copy; ?>
						</td>
						<td>
							<?php echo $row->photo_copy; ?>
						</td>
						<td>
							<?php echo $row->offer_letter; ?>
						</td>
						<td>
							<?php echo $row->contract_form; ?>
						</td>
						<td>
							<?php echo $row->insurance_form; ?>
						</td>
						<td>
							<?php echo $row->labor_payment_form; ?>
						</td>
						<td>
							<?php echo $row->medical_fit_certificate; ?>
						</td>
						<td>
							<?php echo $row->emirates_id; ?>
						</td>
						<td>
							<?php echo $row->visa_copy; ?>
						</td>
						<td>
							<?php echo $row->iloe_insurance; ?>
						</td>
						<td>
							<?php echo $row->labor_card; ?>
						</td>
						<td>
							<?php echo $row->degree_certificate; ?>
						</td>
						<td>
							<?php echo $row->induction; ?>
						</td>
						<td>
							<?php echo $row->job_description; ?>
						</td>
						<td>
							<?php echo $row->driving_license; ?>
						</td>
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_checklist/'.$row->check_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <a href="<?php echo base_url() . 'index.php/Hr/delete_workforce_requisition/'.$row->check_id ; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->check_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a> -->
							<?php if(empty($row->checklist_doc_path)){?>
								<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_checklist_form/'.$row->check_id ; ?>"
								title="Download Checklist Form"><i class="fa fa-print" style="font-size:18px"></i></a>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php }else{?>
								<a href="<?php echo base_url() . 'public/uploded_documents/' . $row->checklist_doc_path; ?>" title="Print Checklist Form" target="_blank"><i class="fa fa-print" style="font-size:18px"></i></a>
							<?php } ?>
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
	function confirmcancel(tid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'employee_requisition',
					where_key: 'emp_req_id',
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
</script>