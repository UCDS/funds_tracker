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
	.table th{
		cursor: pointer;
	}
	.center-align{
		text-align: center;
	}
</style>
<div>
	<div>
		<div  style="margin-top: 5px;" >
			<div class="alert alert-warning" role="alert" >
				<label>Party Name: {{PDetails.party_name}}</label>&nbsp;.&nbsp;
				<label ng-show="PDetails.account_name && PDetails.account_name!='undefined'">Account Name: {{PDetails.account_name}}</label>&nbsp;.&nbsp;
				<label ng-show="PDetails.account_name && PDetails.account_name!='undefined'">Account Number: {{PDetails.account_number}}</label>&nbsp;		
			</div>
		<div >
			<div class="panel panel-yellow ">
				<div class="panel-heading"><i class="fa fa-bell fa-fw"></i>Transactions</div>
				<div style="overflow-x: scroll">
					<table class="table tableevenodd table-hover" style="font-size: 11px;">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Transaction Date</th>
								<th ng-show="!PDetails.account_name || PDetails.account_name=='undefined'">Account Number</th>
								<th>Narration</th>
								<th>Instrument Type</th>
								<th>Instrument ID</th>
								<th>Instrument Date</th>
								<th>Bank Name</th>
								<th>Transaction Type</th>
								<th>Transaction Amount</th>
								<th>Bank Clearance Status</th>
								<th>Clearance Date</th>
								<th>Bill Received</th>
								<th>Notes</th>
								<th>Attachments</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="bank_book in PDetails.bank_books">
								<td ng-bind="$index+1"></td>
								<td ng-bind="bank_book.TrnxDate"></td>
								<td ng-show="!PDetails.account_name || PDetails.account_name=='undefined'" ng-bind="bank_book.account_number"></td>
								<td ng-bind="bank_book.narration"></td>
								<td ng-bind="bank_book.instrument_type"></td>
								<td ng-bind="bank_book.instrument_id_manual"></td>
								<td ng-bind="bank_book.TrnxInstrument_date"></td>
								<td ng-bind="bank_book.bank_name"></td>
								<td class="center-align" ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.debit_credit"></td>
								<td nowrap style="text-align: right;" ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.transaction_amount_ui | currency : '&#x20b9 ' "></td>
								<td class="center-align" ng-bind="bank_book.clearance_status | mapYesNo"></td>
								<td ng-bind="bank_book.TrnxClearance_date"></td>
								<td class="center-align" ng-bind="bank_book.bill_recieved | mapYesNo"></td>
								<td ng-bind="bank_book.notes"></td>
								<td class="link center-align" ng-bind="bank_book.attachments_count" ng-click="PDetails.AttachFiles(bank_book)"></td>
							</tr>
							<tr class="success" align="center" ng-show="PDetails.bank_books.length == 0"><td colspan="17">There are no transactions during this period</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>