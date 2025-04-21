<?php
?>
<style type="text/css">
  
  label{
    width:100px;
  }
  .mand{
    color:red;
  }

</style>
<div class="container">
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-1 ">
			<h3 style="text-align:center;">Add / Update Opening Balance</h3><br/>
			<div class="col-lg-12">
			<?php
				$edit = isset($edit_ledger_opening_balance) ? $edit_ledger_opening_balance : [];
			?>
			<?php if(!empty($edit_ledger_opening_balance)) { ?>
				<?php echo form_open('report/update_opening_balance',array('class'=>'row form-group','role'=>'form','id'=>'')); ?>
			<?php } else { ?>
				<?php echo form_open("report/insert_opening_balance",array('role'=>'form','class'=>'row form-custom','id'=>'')); ?> 
			<?php } ?>
				<div class="form-group col-lg-4 col-md-4 d-flex align-items-center">
					<label for="date" class="me-2 mb-0">Date</label>
					<input type="date" class="form-control" value="<?php echo !empty($edit['date']) ? $edit['date'] : date('Y-m-d'); ?>" name="date" required>
				</div>  
				<div class="form-group col-lg-4 col-md-4 d-flex align-items-center">
					<label for="ledger_account" class="me-2 mb-0" style="white-space: nowrap;">Ledger Account</label>
					<select name="ledger_account_id" class="form-control" onchange="fetchLatestAmount(this.value)" >
						<option value="">-- Select Ledger Account --</option>
						<?php
						if (!empty($ledger_account)) {
							$grouped = [];
							foreach ($ledger_account as $account) {
								$grouped[$account->account_type][] = $account;
							}

							foreach ($grouped as $type => $accounts) {
								echo '<optgroup label="' . htmlspecialchars($type) . '">';
								foreach ($accounts as $account) {
									$selected = (!empty($edit['ledger_account_id']) && $edit['ledger_account_id'] == $account->ledger_account_id) ? 'selected' : '';
									echo '<option value="' . $account->ledger_account_id . '" ' . $selected . '>' . htmlspecialchars($account->ledger_account_name) . '</option>';
								}
								echo '</optgroup>';
							}
						}
						?>
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-4 d-flex align-items-center">
					<label for="amount" class="me-2 mb-0" style="white-space: nowrap;">Add Amount</label>
					<input type="text" class="form-control" value="<?php echo !empty($edit['balance']) ? $edit['balance'] : ''; ?>" name="amount" placeholder="Add Amount" autocomplete="off" required>
				</div>
				<input type="hidden" name="record_id" value="<?php echo $edit['id']; ?>" >
				<div class="col-lg-4 col-md-4">
					<?php if(!empty($edit_ledger_opening_balance)) { ?>
						<input class="btn btn-md btn-success" type="submit" value="Update" style="margin-top:25px;">
					<?php } else { ?>
						<input type="submit" class="btn btn-primary" value="Submit" style="margin-top: 25px;">
					<?php } ?>
					
				</div>
			</form>
		</div>
	</div>
</div><br/>
<?php if (!empty($error) || $error!=0): ?>
	<span class="col-md-offset-3" style="color: red;"><?php echo $error; ?></span>
<?php elseif (isset($success)): ?>
	<span class="col-md-offset-3" style="color: green;"><?php echo $success; ?></span>
<?php endif; ?>

<div class="container">
	<div class="col-sm-9 col-sm-offset-3 text-left col-md-offset-1" style="margin-top: 20px;">
	<h3 style="text-align:left;">List Opening Balances</h3><br/>
		<div style="float: right;">
			<input type="text" id="searchInput" class="form-control" placeholder="Search..." style="width: 200px;">
		</div>
		<div>
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
		</div><br/>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-11 col-md-offset-1 ">
		<?php if (!empty($ledger_opening_balance)) : ?>
			<div class="table-responsive mt-4">
				<table class="table table-bordered table-striped" id="table-sort">
					<thead class="table-dark">
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Ledger Account</th>
							<th>Opening Balance</th>
							<th>Inserted By</th>
							<th>Inserted Time</th>
							<th>Updated By</th>
							<th>Updated Time</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1 + (($current_page - 1) * 10); foreach ($paged_history as $row): ?>
							<tr>
								<td><?= $i++; ?></td>
								<td><?= htmlspecialchars($row->date); ?></td>
								<td>
									<?php 
										if (!empty($ledger_account)) {
											foreach ($ledger_account as $account) {
												if ($account->ledger_account_id == $row->ledger_account_id) {
													echo htmlspecialchars($account->ledger_account_name);
													break;
												}
											}
										} else {
											echo 'N/A';
										}
									?>
								</td>
								<td><?= number_format($row->balance); ?></td>
								<td><?= !empty($row->name) ? $row->name : $row->user_name; ?></td>
								<td><?= $row->insert_time; ?></td>
								<td><?= !empty($row->updated_by_name) ? $row->updated_by_name : $row->updated_username; ?></td>
								<td><?= $row->update_time; ?></td>
								<td>
									<a href="<?= base_url('report/add_upd_opening_balance/' . $row->id); ?>" title="Edit">
										<i class="fa fa-edit text-primary"></i>
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<div class="alert alert-info mt-4">No opening balances found.</div>
		<?php endif; ?>
	</div>
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

<script>
	function fetchLatestAmount(ledgerAccountId) {
		if (!ledgerAccountId) {
			document.querySelector('input[name="amount"]').value = '';
			return;
		}

		fetch('<?= base_url("report/get_available_amount") ?>/' + ledgerAccountId)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					document.querySelector('input[name="amount"]').value = data.amount;
				} else {
					document.querySelector('input[name="amount"]').value = '';
					alert('No amount found for this ledger account.');
				}
			})
			.catch(error => {
				console.error('Error fetching amount:', error);
			});
	}
</script>
