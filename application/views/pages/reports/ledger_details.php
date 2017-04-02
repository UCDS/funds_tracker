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
				<label>Search By: {{PDetails.searchByName}}.&nbsp;</label>
				<label>Name: {{PDetails.searchIDName}}.&nbsp;</label>
				<label ng-show="PDetails.account_name && PDetails.account_name!='undefined'">Account Name: {{PDetails.account_name}}.&nbsp;</label>
				<label ng-show="PDetails.account_name && PDetails.account_name!='undefined'">Account Number: {{PDetails.account_number}}.</label>		
			</div>
		<div >
			<div class="panel panel-yellow ">
				<div class="panel-heading"><i class="fa fa-bell fa-fw"></i>Transactions</div>
				<div style="overflow-x: scroll">
					<table class="table tableevenodd table-hover" style="font-size: 11px;">
						<thead>
							<tr>
								<th>S.No.</th>
								<th title="Transaction Date">Trnx. Date</th>
								<th ng-show="!PDetails.account_name || PDetails.account_name=='undefined'">Act. Number</th>
								<th title="Transaction Type">Trnx. Type</th>
								<th title="Transaction Amount">Trnx. Amt.</th>
								<th title="Ledger Account">L. Act.</th>
								<th title="Ledger Sub Account">L. Sub Act.</th>
								<th>Narration</th>
								<th>Payee Party</th>
								<th>Item</th>
								<th>Project</th>
								<th>Donor Party</th>
								<th title="Instrument Type">Inst. Type</th>
								<th title="Instrument ID">Inst. ID</th>
								<!--<th title="Bank Clearance Status">Clearance</th>
								<th>Clearance Date</th>-->
								<th title="Bill Received">Bill Rcvd.</th>
								<th title="Attachments">Att.</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="bank_book in PDetails.bank_books">
								<td ng-bind="$index+1"></td>
								<td ng-bind="bank_book.TrnxDate"></td>
								<td ng-show="!PDetails.account_name || PDetails.account_name=='undefined'" ng-bind="bank_book.account_number"></td>
								<td class="center-align" ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.debit_credit"></td>
								<td nowrap style="text-align: right;" ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.amount | currency : '&#x20b9 ' "></td>
								<td ng-bind="bank_book.ledger_account_name"></td>
								<td ng-bind="bank_book.ledger_sub_account_name"></td>
								<td ng-bind="bank_book.ledger_narration"></td>
								<td ng-bind="bank_book.payer_party_name"></td>
								<td ng-bind="bank_book.item_name"></td>
								<td ng-bind="bank_book.project_name"></td>
								<td ng-bind="bank_book.donor_party_name"></td>
								<td ng-bind="bank_book.instrument_type"></td>
								<td ng-bind="bank_book.instrument_id_manual"></td>
								<!--<td class="center-align" ng-bind="bank_book.clearance_status | mapYesNo"></td>
								<td ng-bind="bank_book.TrnxClearance_date"></td>-->
								<td class="center-align" ng-bind="bank_book.bill_recieved | mapYesNo"></td>
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