<?php
?>
<style>
	input[type=checkbox].form-control{
		padding: 30px;
		width : 15px;
	}
	.mand{
		color:red;
	}
	.green-text{
		color: #049c04;
	}
	.red-text{
		color : #FF0000;
	}
	.sortorder:after {
	  content: '\25b2';   /* BLACK UP-POINTING TRIANGLE*/
	}
	.sortorder.reverse:after {
	  content: '\25bc';   /* BLACK DOWN-POINTING TRIANGLE*/
	}
	.table th{
		cursor: pointer;
	}
	.link{ 
		color: #009fff; 
		cursor: pointer;
		/*text-decoration: underline;*/
	}
</style>
<?php 
$session_data = $this->session->userdata();
?>
<div class="container-fluid" style="overflow-x:hidden;">
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 ">
			<h3 style="text-align:center;">Book Edits</h3>
			<div class="col-lg-12">
			<?php echo form_open("report/get_bank_book_edits",array('role'=>'form','class'=>'row form-custom','id'=>'')); ?>
				<div class="form-group col-lg-4 col-md-4 d-flex align-items-center">
					<label for="from_date" class="me-2 mb-0">From Date</label>
					<input type="date" class="form-control" value="<?php if($this->input->post('from_date')){ echo $this->input->post('from_date'); }?>" name="from_date" required>
				</div>  
				<div class="form-group col-lg-4 col-md-4 d-flex align-items-center">
					<label for="to_date" class="me-2 mb-0">To Date</label>
					<input type="date" class="form-control" value="<?php if($this->input->post('to_date')){ echo $this->input->post('to_date'); } ?>" name="to_date" required>
				</div>
				<div class="col-lg-4 col-md-4">
					<input type="submit" class="btn btn-primary" value="Search" style="margin-top: 25px;">
				</div>
			</form>
		</div>
		</div><br/>
		<div class="container ol-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 text-left" style="margin-top: 20px;">
		<?php 
    		$from_date = $this->session->userdata('from_date');
    		$to_date = $this->session->userdata('to_date');	
			if ($from_date && $to_date) {
		?>
			<h4>Report Between 
				<span style="color: green;">
					<?php 
						date_default_timezone_set('Asia/Kolkata');
						echo date("d-m-Y", strtotime($this->session->userdata('from_date')));
					?>
				</span> 
				to 
				<span style="color: green;">
					<?php 
						echo date("d-m-Y", strtotime($this->session->userdata('to_date')));
					?>
				</span>
			</h4>
		<?php } else {
				echo '<span style="color: green;font-size:20px;">No date range selected.</span>';
			}
		?>
			<div style="float: right;">
				<input type="text" id="searchInput" class="form-control" placeholder="Search......." style="width: 200px;">
			</div>

			<?php if ($current_page > 1): ?>
				<a href="?page=<?php echo $current_page - 1; ?>" class="btn btn-default" style="margin: 2px;color:black;">&laquo; Previous</a>
			<?php endif; ?>

			<?php for ($p = 1; $p <= $total_pages; $p++): ?>
				<a href="?page=<?php echo $p; ?>" 
				class="btn btn-default <?php echo ($p == $current_page) ? 'active' : ''; ?>" 
				style="margin: 2px; <?php echo ($p == $current_page) ? 'background-color: #007bff; color: #fff;' : ''; ?>">
					<?php echo $p; ?>
				</a>
			<?php endfor; ?>

			<?php if ($current_page < $total_pages): ?>
				<a href="?page=<?php echo $current_page + 1; ?>" class="btn btn-default" style="margin: 2px;color:black;">Next &raquo;</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<table class="table table-bordered table-striped" id="table-sort">
				<thead>
					<tr>
						<th style="text-align:center"><strong>SNo</strong></th>
						<th style="text-align:center"><strong>Transaction id</strong></th>
						<th style="text-align:center"><strong>Ledger id</strong></th>
						<th style="text-align:center"><strong>Table name</strong></th>
						<th style="text-align:center"><strong>Field name</strong></th>
						<th style="text-align:center"><strong>Previous value</strong></th>
						<th style="text-align:center"><strong>New value</strong></th>
						<th style="text-align:center"><strong>Edit date/time</strong></th>
						<th style="text-align:center"><strong>Edited by</strong></th>		
					</tr>
				</thead>
				<tbody>
					<?php
					$i = ($current_page - 1) * 10 + 1;					
					foreach($get_edit_history as $pe){
					?>
					<tr>
						<td style="text-align:right"><?php echo $i;?></td>
						<td style="text-align:right"><?php echo $pe->transaction_id; ?></td> 	
						<td style="text-align:right"><?php echo $pe->ledger_id; ?></td> 	
						<td style="text-align:right"><?php echo $pe->table_name; ?></td>	
						<td style="text-align:right"><?php echo $pe->field_name ?></td>	
						<td style="text-align:right"><?php echo $pe->previous_value ?></td>	
						<td style="text-align:right"><?php echo $pe->new_value ?></td>	
						<td style="text-align:center"><?php echo date("d-M-Y H:i A",strtotime($pe->edit_date_time));?></td>
						<td style="text-align:center"><?php if($pe->name==''){ echo $pe->user_name; }else{ echo $pe->name; }?> </td>
					</tr>
					<?php $i++;}	?>
				</tbody>
			</table>
		</div>
		<script>
			document.getElementById('searchInput').addEventListener('keyup', function() {
				var filter = this.value.toUpperCase();
				var table = document.getElementById('table-sort');
				var rows = table.getElementsByTagName('tr');

				for (var i = 1; i < rows.length; i++) { 
					var cells = rows[i].getElementsByTagName('td');
					var rowContainsSearchTerm = false;

					for (var j = 0; j < cells.length; j++) {
						var cell = cells[j];
						if (cell) {
							if (cell.textContent.toUpperCase().indexOf(filter) > -1) {
								rowContainsSearchTerm = true;
								break;
							}
						}
					}
					if (rowContainsSearchTerm) {
						rows[i].style.display = '';
					} else {
						rows[i].style.display = 'none';
					}
				}
			});
		</script>
</div>