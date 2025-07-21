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
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 ">
			<h3 style="text-align:center;">Add / Update Opening Balance</h3><br/>
		<div class="col-lg-12">
			<?php echo form_open("report/add_upd_opening_balance",array('role'=>'form','class'=>'row form-custom','id'=>'')); ?> 
				<div class="form-group col-lg-4 col-md-4 d-flex align-items-center">
					<label for="date" class="me-2 mb-0">Select Date</label>
					<input type="date" class="form-control" value="<?php 
						if ($this->input->post('date')) { 
							echo date('Y-m-d', strtotime($this->input->post('date'))); 
						} else { 
							echo date('Y-m-d'); 
						} 
					?>" 
					name="date" id="select-date" required>
				</div>
				<div class="col-lg-4 col-md-4">
					<input type="submit" class="btn btn-primary" value="Search" style="margin-top: 25px;">
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
    <div class="col-sm-9 col-sm-offset-3 col-md-11 col-md-offset-2 ">
       <?php if (!empty($ledger_opening_balances)) : ?>
			<form method="post" action="<?= base_url('report/update_opening_balances') ?>">
				<input type="hidden" name="date" id="hidden-date">
				<div class="table-responsive mt-4">
					<?php
						$grouped_data = [];
						foreach ($ledger_opening_balances as $row) {
							// Normalize account type just in case
							$row->account_type = ucfirst(strtolower(trim($row->account_type)));
							$grouped_data[$row->account_type][] = $row;
						}

						$order = ['Income', 'Expenditure', 'Assets', 'Liabilities'];
						$sorted_grouped_data = [];
						foreach ($order as $type) {
							if (isset($grouped_data[$type])) {
								$sorted_grouped_data[$type] = $grouped_data[$type];
							}
						}
					?>
					<?php foreach ($sorted_grouped_data as $account_type => $entries): ?>
						<h4 style="color:#e86507;"><?= ucfirst($account_type) ?></h4>
						<style>
							.table {
								table-layout: fixed;
								width: 100%;
							}
							.table th, .table td {
								width: 25%;
							}
						</style>
						<table class="table table-bordered table-striped" id="table-sort">
							<thead class="table-dark">
								<tr>
									<th style="text-align: center;">#</th>
									<th>Ledger Account</th>
									<th>Balance Type</th>
									<th>Balance</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; foreach ($entries as $entry): ?>
									<tr>
										<td style="text-align: center;"><?= $i++ ?></td>
										<td><?= htmlspecialchars($entry->ledger_account_name) ?></td>
										<td>
											<label>
												<input type="radio" name="balances[<?= $entry->ledger_account_id ?>][balance_type]" value="1"
													<?= ($entry->balance_type == 1) ? 'checked' : '' ?>> Debit
											</label>
											<label>
												<input type="radio" name="balances[<?= $entry->ledger_account_id ?>][balance_type]" value="2"
													<?= ($entry->balance_type == 2) ? 'checked' : '' ?>> Credit
											</label>
										</td>
										<td style="text-align:right;">
											<input type="text" name="balances[<?= $entry->ledger_account_id ?>][balance]"
												value="<?= htmlspecialchars($entry->balance) ?>" class="form-control text-right" />
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endforeach; ?>
				</div>

				<!-- Totals Display -->
				<div class="row mt-3 mb-3">
					<div class="col-md-6">
						<strong style="color: green;font-size:20px;">Total Debit: ₹ <span id="debit-total">0.00</span></strong>
					</div>
					<div class="col-md-6 text-right">
						<strong style="color: red;font-size:20px;">Total Credit: ₹ <span id="credit-total">0.00</span></strong>
					</div>
				</div>

				<!-- Warning -->
				<div id="balance-warning" class="alert alert-danger text-center mt-5" style="display:none;">
					Debit and Credit totals must be equal or greater than 0 to save the opening balance.
				</div>

				<!-- Submit Button -->
				<div class="text-center mt-4">
					<button type="submit" class="btn btn-primary" id="save-btn" style="display:none;">Save Opening Balance</button>
				</div><br/><br/>
			</form>
		<?php else: ?>
			<div class="alert alert-info mt-4">No opening balances found.</div>
		<?php endif; ?>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const submitBtn = document.getElementById('save-btn');
    const notice = document.getElementById('balance-warning');

    function calculateTotals() {
        let debitTotal = 0;
        let creditTotal = 0;

        document.querySelectorAll('input[type="text"]').forEach(input => {
            const balance = parseFloat(input.value) || 0;
            const id = input.name.match(/\d+/)[0];

            const debitRadio = document.querySelector(`input[name="balances[${id}][balance_type]"][value="1"]`);
            const creditRadio = document.querySelector(`input[name="balances[${id}][balance_type]"][value="2"]`);

            if (debitRadio && debitRadio.checked) {
                debitTotal += balance;
            } else if (creditRadio && creditRadio.checked) {
                creditTotal += balance;
            }
        });

        document.getElementById('debit-total').textContent = debitTotal.toFixed(2);
        document.getElementById('credit-total').textContent = creditTotal.toFixed(2);

        if (
			debitTotal.toFixed(2) === creditTotal.toFixed(2) &&
			debitTotal > 0 && creditTotal > 0
		) {
			submitBtn.style.display = 'inline-block';
			notice.style.display = 'none';
		} else {
			submitBtn.style.display = 'none';
			notice.style.display = 'block';
		}
    }

    calculateTotals();

    document.querySelectorAll('input[type="radio"], input[type="text"]').forEach(el => {
        el.addEventListener('change', calculateTotals);
    });
});
</script>


<script>
    document.querySelector('form[action*="update_opening_balances"]').addEventListener('submit', function() {
        const selectedDate = document.getElementById('select-date').value;
        document.getElementById('hidden-date').value = selectedDate;
    });
</script>