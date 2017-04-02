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
	  content: '\25b2';   // BLACK UP-POINTING TRIANGLE
	}
	.sortorder.reverse:after {
	  content: '\25bc';   // BLACK DOWN-POINTING TRIANGLE
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
<div ng-app="bank_booksApp">
	<div ng-controller ="Bank_bookCtrl as bank_bookCtrl">
		
		<div  class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2" style="margin-top: 5px;">
			
				<div class="alert alert-warning" role="alert"><label>Account Name: <?php echo $account_name.'.'; ?></label>&nbsp;
				<label>Bank Name: <?php foreach($banks as $bank) if($bank->bank_id == $bank_id){ echo $bank->bank_name; break; }?></label></div>              
				<input type="hidden" class="form-control" name="account_id" ng-model="bank_bookCtrl.newBank_book.account_id"/>
				<input type="hidden" class="form-control" name="bank_account_id" ng-model="bank_bookCtrl.newBank_book.bank_account_id"/>
			
		</div>
		<?php
			if($this->session->logged_in == 'YES'){
		?>
			<div  class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2" ng-show="!bank_bookCtrl.addflag && !bank_bookCtrl.updateflag">
				<div class=" form-group col-lg-4 col-md-6">
					<input type="button" class="btn btn-primary" ng-show="!bank_bookCtrl.PreDefTrnxType" ng-click="bank_bookCtrl.addflag=1" value="Add Transaction" />
				</div>
			</div>
			<div ng-show="bank_bookCtrl.addflag || bank_bookCtrl.updateflag" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<form class="form-custom" ng-submit="bank_bookCtrl.addTransaction()" name="addTransaction">
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2"><span class="mand">*</span>Transaction Type:</label>
					<label>
						<input type="radio" class="" name="debit_credit" id="debit_credit" value="Credit" required="" ng-disabled="!bank_bookCtrl.addflag" ng-model="bank_bookCtrl.newBank_book.debit_credit">
					Credit
					</label>
					<label>
						<input type="radio" class="" name="debit_credit" value="Debit" required="" ng-disabled="!bank_bookCtrl.addflag" ng-model="bank_bookCtrl.newBank_book.debit_credit">
					Debit
					</label>
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputEmail2"><span class="mand">*</span>Transaction Date</label>
					<input type="datetime-local" class="form-control" name="date" ng-disabled="!bank_bookCtrl.addflag" ng-model="bank_bookCtrl.newBank_book.date" required="">              
				</div>  
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2"><span class="mand">*</span>Party Name</label>
					<select name="party_id" id="party_id" class="form-control" required ng-model="bank_bookCtrl.newBank_book.party_id">
					  <option value="">Party Name</option>
					  <?php 
					  foreach($parties as $party){ ?>
							  <option value='<?php echo $party->party_id; ?>'><?php echo $party->party_name; ?></option>";
					 <?php }
					  ?>
					</select>              
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Narration</label>
					<input type="text" class="form-control" name="narration" ng-model="bank_bookCtrl.newBank_book.narration"/>
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Instrument Type</label>
					<!--<select  name="instrument_type_id" id="instrument_type_id" class="form-control" ng-model="bank_bookCtrl.instrumenttypeid" ng-change="bank_bookCtrl.change()">-->
					<select  name="instrument_type_id" id="instrument_type_id" class="form-control" ng-model="bank_bookCtrl.newBank_book.instrument_type_id">
					  <option value="">Instrument Type</option>
					  <?php 
					  foreach($instrument_types as $instrument_type){ ?>
							  <option value='<?php echo $instrument_type->instrument_type_id; ?>'><?php echo $instrument_type->instrument_type; ?></option>";
					 <?php }
					  ?>
					</select>
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Instrument ID</label>
					<!--<select name="instrument_id" id="instrument_id" class="form-control" ng-show="bank_bookCtrl.vSelectedInstrumentType === 'CHEQUE'">
					 <option value="">Instrument ID</option>-->
					  <?php 
					  //foreach($cheque_leaves as $cheque_leaf){ ?>
							<!--  <option value='<?php //echo $cheque_leaf->cheque_leaf_id; ?>'><?php //echo $cheque_leaf->cheque_leaf_number; ?></option>";-->
					 <?php 
					 //			}
					  ?>
					<!-- 
						ng-show="bank_bookCtrl.vSelectedInstrumentType !== 'CHEQUE'"
					-->
					</select>
					<input type="text" name="instrument_id_manual" id="instrument_id_manual"  class="form-control" ng-model="bank_bookCtrl.newBank_book.instrument_id_manual"/>
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Instrument Date</label>
					<input type="date" class="form-control" name="instrument_date" ng-model="bank_bookCtrl.newBank_book.instrument_date"/>
				</div>

				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Bank</label>
					<select name="bank_id" id="bank_id" class="form-control" ng-model="bank_bookCtrl.newBank_book.bank_id">
						  <option value="">Bank</option>
						  <?php
						  foreach($banks as $bank){ ?>
								  <option value='<?php echo $bank->bank_id; ?>'><?php echo $bank->bank_name; ?></option>";
						 <?php }
						  ?>
					 </select>              
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2"><span class="mand">*</span>Transaction Amount</label>
					<input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control" name="transaction_amount" ng-required="true" ng-model="bank_bookCtrl.newBank_book.transaction_amount"/>
					<span class="mand" ng-show="!addTransaction.transaction_amount.$valid && addTransaction.transaction_amount.$dirty">
						Invalid Amount
					</span>
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Bank Clearance Status</label>
					<input type="checkbox" class="form-control" name="clearance_status" ng-false-value="0" ng-true-value="1" ng-model="bank_bookCtrl.newBank_book.clearance_status"/>
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputEmail2">Clearance Date</label>
					<input type="date" class="form-control" name="clearance_date" ng-model="bank_bookCtrl.newBank_book.clearance_date"/>
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Bill Received</label>
					<input type="checkbox" class="form-control" name="bill_recieved" ng-false-value="0" ng-true-value="1" ng-model="bank_bookCtrl.newBank_book.bill_recieved">
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Notes</label>
					<input type="text" class="form-control" name="notes" ng-model="bank_bookCtrl.newBank_book.notes"/>              
				</div>
				<div class="col-sm-12 col-md-12">
					<h4>Ledger
						<span class="glyphicon glyphicon-plus-sign" ng-click="bank_bookCtrl.addNewLedgerRecord()" style="color: #13ad2f; cursor:pointer;" title="Add"></span>

					</h4>
					<div class="searchfrom col-lg-12">
						<table class="table tableevenodd table-hover" style="font-size: 11px;">
							<thead>
								<tr>
									<th>S.No.</th>
									<th><span class="mand">*</span>Amount</th>
									<th><span class="mand">*</span>Account</th>
									<th>Sub Account</th>
									<th>Narration</th>
									<th><span class="mand">*</span><span ng-bind="bank_bookCtrl.newBank_book.debit_credit == 'Credit' ? 'Payer Party' : 'Payee Party'"></span></th>
									<th>Item</th>
									<th>Project</th>
									<th>Donor Party</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="ledgerrecord in bank_bookCtrl.newBank_book.ledgerDetails">
									<th ng-bind="$index+1"></th>
									<th><input type="text" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" ng-model="ledgerrecord.amount" style="width:70px;"/></th>
									<th>
										<select required style="width:115px;" ng-model="ledgerrecord.ledger_account_id" ng-options="ledgerAccount.ledger_account_id as ledgerAccount.ledger_account_name for ledgerAccount in bank_bookCtrl.ledgerList">
										</select>
									
									</th>
									<th>
										<select  style="width:100px;" ng-model="ledgerrecord.ledger_sub_account_id" ng-options="ledgerSubAccount.ledger_sub_account_id as ledgerSubAccount.ledger_sub_account_name for ledgerSubAccount in bank_bookCtrl.ledgerSubAcntList">
										</select>
									
									</th>
									<th>
										<input type="text" ng-model="ledgerrecord.narration" style="width:70px;"/>
									</th>
									<th>
										<select required style="width:115px;" ng-model="ledgerrecord.payee_party_id" ng-options="party.party_id as party.party_name for party in bank_bookCtrl.parties">
										</select>
									</th>
									<th>
										<select style="width:115px;" ng-model="ledgerrecord.item_id" ng-options="item.item_id as item.item_name for item in bank_bookCtrl.itemsList">
										</select>
									</th>
									<th>
										<select style="width:115px;" ng-model="ledgerrecord.project_id" ng-options="project.project_id as project.project_name for project in bank_bookCtrl.projects">
										</select>
									</th>
									<th>
										<select style="width:115px;" ng-model="ledgerrecord.donor_party_id" ng-options="party.party_id as party.party_name for party in bank_bookCtrl.parties">
										</select>
									</th>
									<th>
										<span ng-click="bank_bookCtrl.deleteLedgerRecord($index)"  class="glyphicon glyphicon-remove" title="Delete" style="color:#ea3131; cursor:pointer;"></span>
									</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-sm-12 col-md-12">
					<input type="submit" class="btn btn-default" value="{{bank_bookCtrl.getSubmitButtonText()}}" ng-disabled="addTransaction.$invalid">
					<input type="button" class="btn btn-default" value="Cancel" ng-click="bank_bookCtrl.cancelUpdate()" ng-show="bank_bookCtrl.updateflag || bank_bookCtrl.addflag">
				</div>
				
				</form>
			</div>
			
		<?php
			}
		?>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 " ng-show="!bank_bookCtrl.PreDefTrnxType">
			<h3>Search</h3>
			<div class="searchfrom col-lg-12">
				<form class="form-inline" name="search_bankbook" ng-submit="bank_bookCtrl.searchBankBooks()">
						<div class="from-group col-lg-4 col-md-4">
							<label>From Date</label>
							<input type="date" id="fromdate" class="form-control" ng-model="bank_bookCtrl.searchBank_book.fromdate" ng-required="!bank_bookCtrl.searchBank_book.todate"/>
						</div>	
						<div class="from-group col-lg-4 col-md-4">
							<label>To Date</label>
							<input type="date" id="todate" class="form-control " ng-model="bank_bookCtrl.searchBank_book.todate" ng-required="!bank_bookCtrl.searchBank_book.fromdate"/>
						</div>
					<input type="submit" class="btn btn-default" value="Search" ng-show="bank_bookCtrl.updateflag == 0" ng-disabled="search_bankbook.$invalid"/>
				</form>
			</div>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="panel panel-yellow ">
				<div class="panel-heading"><i class="fa fa-bell fa-fw"></i>Transactions</div>
				<div style="overflow-x: scroll">
					<table class="table tableevenodd table-hover" style="font-size: 11px;">
						<thead>
							<tr>
								<th>
									S.No.
								</th>
								<th title="Transaction Date" ng-click="bank_bookCtrl.sortBy('date')">
									Trnx. Date

									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'date'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th ng-click="bank_bookCtrl.sortBy('party_name')">
									Party Name

									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'party_name'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th ng-click="bank_bookCtrl.sortBy('narration')">
									Narration
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'narration'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Instrument Type" ng-click="bank_bookCtrl.sortBy('instrument_type')">
									Inst. Type
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'instrument_type'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Instrument ID" ng-click="bank_bookCtrl.sortBy('instrument_id_manual')">
									Inst. ID
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'instrument_id_manual'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Instrument Date" ng-click="bank_bookCtrl.sortBy('instrument_date')">
									Inst. Date
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'instrument_date'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th ng-click="bank_bookCtrl.sortBy('bank_name')">
									Bank Name
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'bank_name'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Transaction Type" ng-click="bank_bookCtrl.sortBy('debit_credit')">
									Trnx. Type
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'debit_credit'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Transaction Amount" ng-click="bank_bookCtrl.sortBy('transaction_amount_ui')">
									Trnx. Amt.
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'transaction_amount_ui'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Bank Clearance Status" ng-click="bank_bookCtrl.sortBy('clearance_status')">
									Clearance
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'clearance_status'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th ng-click="bank_bookCtrl.sortBy('clearance_date')">
									Clearance Date
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'clearance_date'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Book Balance" ng-click="bank_bookCtrl.sortBy('balance_ui')">
									Book Bal.
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'balance_ui'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Bank Statement Balance" ng-click="bank_bookCtrl.sortBy('statement_balance_ui')">
									Bank Stmt. Bal.
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'statement_balance_ui'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Received" ng-click="bank_bookCtrl.sortBy('bill_recieved')">
									Bill Rcvd.
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'bill_recieved'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th ng-click="bank_bookCtrl.sortBy('notes')">
									Notes
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'notes'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Attachments">
									Att.
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($this->session->logged_in == 'YES'){
							?>
							<tr class="active">
								<td></td>
								<td ng-bind="bank_bookCtrl.newBank_book.date | date:'dd-MMM-yyyy HH:mm'"></td>
								<td ng-bind="bank_bookCtrl.MapPartyName(bank_bookCtrl.newBank_book.party_id)"></td>
								<td ng-bind="bank_bookCtrl.newBank_book.narration"></td>
								<td ng-bind="bank_bookCtrl.MapInstrumentType(bank_bookCtrl.newBank_book.instrument_type_id)"></td>
								<td ng-bind="bank_bookCtrl.newBank_book.instrument_id_manual"></td>
								<td ng-bind="bank_bookCtrl.newBank_book.instrument_date | date:'dd-MMM-yyyy'"></td>
								<td ng-bind="bank_bookCtrl.MapBankName(bank_bookCtrl.newBank_book.bank_id)"></td>
								<td ng-bind="bank_bookCtrl.newBank_book.debit_credit"></td>
								<td ng-bind="bank_bookCtrl.newBank_book.transaction_amount | currency : '&#x20b9 ' "></td>
								<td ng-bind="bank_bookCtrl.newBank_book.clearance_status | mapYesNo"></td>
								<td ng-bind="bank_bookCtrl.newBank_book.clearance_date | date:'dd-MMM-yyyy'"></td>
								<td ></td>
								<td ></td>
								<td ng-bind="bank_bookCtrl.newBank_book.bill_recieved | mapYesNo"></td>
								<td ng-bind="bank_bookCtrl.newBank_book.notes"></td>
								<td ></td>
							</tr>
							<?php
								}
								if($this->session->logged_in == 'YES'){
							?>
								<tr ng-repeat="bank_book in bank_bookCtrl.bank_books"  ng-click="bank_bookCtrl.editRecord(bank_book,$index)"> <!-- | orderBy:bank_bookCtrl.propertyName:bank_bookCtrl.reverse -->
							<?php
								}else{
							?>
								<tr ng-repeat="bank_book in bank_bookCtrl.bank_books" > <!-- | orderBy:bank_bookCtrl.propertyName:bank_bookCtrl.reverse -->
							<?php
								}
							?>
								<td ng-bind="$index+1"></td>
								<td ng-bind="bank_book.date | date:'dd-MMM-yyyy HH:mm'"></td>
								<td ng-bind="bank_book.party_name"></td>
								<td ng-bind="bank_book.narration"></td>
								<td ng-bind="bank_book.instrument_type"></td>
								<td ng-bind="bank_book.instrument_id_manual"></td>
								<td ng-bind="bank_book.instrument_date | date:'dd-MMM-yyyy'"></td>
								<td ng-bind="bank_book.bank_name"></td>
								<td ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.debit_credit"></td>
								<td nowrap ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.transaction_amount_ui | currency : '&#x20b9 ' "></td>
								<td ng-bind="bank_book.clearance_status | mapYesNo"></td>
								<td ng-bind="bank_book.clearance_date | date:'dd-MMM-yyyy'"></td>
								<td nowrap ng-bind="bank_book.balance_ui | currency : '&#x20b9 ' "></td>
								<td nowrap ng-bind="bank_book.statement_balance_ui| currency : '&#x20b9 ' "></td>
								<td ng-bind="bank_book.bill_recieved | mapYesNo"></td>
								<td ng-bind="bank_book.notes"></td>
								<td class="link" ng-bind="bank_book.attachments_count" ng-click="bank_bookCtrl.AttachFiles(bank_book)"></td>
							</tr>
							<tr class="success" align="center" ng-show="bank_bookCtrl.bank_books.length == 0"><td colspan="17">There are no transactions during this period</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>
		angular.module('bank_booksApp', [])
		.controller('Bank_bookCtrl', ['$http',"formatDataFilter","DateFormater", function($http,formatData,DateFormater) {
			var self = this;
			self.vTempLoopID = 0;
//			self.propertyName = 'date';
//  			self.reverse = true;
  			self.sortBy = function(propertyName) {
			    self.reverse = (self.propertyName === propertyName) ? ! self.reverse : false;
			    self.propertyName = propertyName;
			  };
			$("#LefNaveBankBook").addClass("active");
			self.projects = <?=json_encode($projects)?>;
			self.projects.splice(0, 0, {"project_id":"0","project_name":""});
			self.parties = <?=json_encode($parties)?>;
			self.parties.splice(0, 0, {"party_id":"0","party_name":""});

			self.bank_accounts = [];
			self.bank_books = [];
			self.banks = [];
			//self.projects = [];
			self.instrument_types = [];              
			self.partys = [];
			self.cheque_leaves = [];
			self.updateflag = 0;
			self.addflag = 0;
			self.bank_book_index ;
			self.bank_book_editing ;
			self.newBank_book = {};
			self.staticData = {};
			self.staticData.bank_id = "<?=$bank_id?>";
			self.staticData.account_id = "<?=$bank_account_id?>";
			self.staticData.bank_account_id = "<?=$bank_account_id?>";
			self.staticData.bank_account_name = "<?=$account_name?>";
			self.staticData.bank_account_number = "<?=$account_number?>";

			self.newBank_book.account_id = "<?=$bank_account_id?>";
			self.newBank_book.bank_account_id = "<?=$bank_account_id?>";
			
			self.searchBank_book = {};
			if('<?=$FromDate?>' || '<?=$ToDate?>'){
				self.searchBank_book.fromdate = DateFormater.convertToJSDate('<?=$FromDate?>');
				self.searchBank_book.todate = DateFormater.convertToJSDate('<?=$ToDate?>');

			}

			else{
				var vTempFromDate = new Date();
				vTempFromDate.setDate(vTempFromDate.getDate() - 30);
				self.searchBank_book.fromdate = vTempFromDate;
				self.searchBank_book.todate = new Date();

			}
			self.PreDefTrnxType = '<?= $TrnxType?>';


			self.getSubmitButtonText = function(){
				  return self.updateflag == 0 ? "Add" : "Update"  ;
				};
			self.AttachFiles = function(vBook){
				var vNewForm = "<form method='post' action='/funds_tracker/upload' id='form_"+vBook.transaction_id+"' style='display:none;'>";
				vNewForm += '<input type="hidden" name="bank_account_id" value="'+self.staticData.bank_account_id+'" />';
				vNewForm += '<input type="hidden" name="bank" value="'+self.staticData.bank_id+'" />';
				vNewForm += '<input type="hidden" name="account_name" value="'+self.staticData.bank_account_name+'" />';
				vNewForm += '<input type="hidden" name="account_number" value="'+self.staticData.bank_account_number+'" />';
				vNewForm += '<input type="hidden" name="TrnxType" value="'+self.PreDefTrnxType+'" />';
				vNewForm += '<input type="hidden" name="StartDate" value="'+DateFormater.convertJsDate(self.searchBank_book.fromdate)+'" />';
				vNewForm += '<input type="hidden" name="Date" value="'+DateFormater.convertJsDateTime(vBook.date)+'" />';
				vNewForm += '<input type="hidden" name="PartyName" value="'+(vBook.party_name == null ? "" :vBook.party_name) +'" />';
				vNewForm += '<input type="hidden" name="Narration" value="'+vBook.narration+'" />';
				vNewForm += '<input type="hidden" name="IType" value="'+self.MapInstrumentType(vBook.instrument_type_id)+'" />';
				vNewForm += '<input type="hidden" name="IID" value="'+vBook.instrument_id_manual+'" />';
				vNewForm += '<input type="hidden" name="IDate" value="'+DateFormater.convertJsDate(vBook.instrument_date)+'" />';
				vNewForm += '<input type="hidden" name="BName" value="'+self.MapBankName(vBook.bank_id)+'" />';
				vNewForm += '<input type="hidden" name="TType" value="'+vBook.debit_credit+'" />';
				vNewForm += '<input type="hidden" name="TAmt" value="'+vBook.transaction_amount+'" />';
				vNewForm += '<input type="hidden" name="BCS" value="'+(vBook.clearance_status == 1 ? "Yes" : "No")+'" />';
				vNewForm += '<input type="hidden" name="CD" value="'+DateFormater.convertJsDate(vBook.clearance_date)+'" />';
				vNewForm += '<input type="hidden" name="BR" value="'+(vBook.bill_recieved == 1 ? "Yes" : "No")+'" />';
				vNewForm += '<input type="hidden" name="Notes" value="'+vBook.notes+'" />';

				vNewForm += '<input type="hidden" name="EndDate" value="'+DateFormater.convertJsDate(self.searchBank_book.todate)+'" />';
				vNewForm += '<input type="hidden" name="TranxID" value="'+vBook.transaction_id+'" />';
			  	vNewForm += "</form>";
			  	$("body").append(vNewForm);
			  	$("#form_"+vBook.transaction_id).submit();
			};
			self.fetchbank_books = function() {
				return $http.get('<?php echo base_url(); ?>index.php/bank_book/get_bank_books/<?php echo $bank_account_id; ?>').then(
					function(response) {
						self.bank_books = formatData(response.data);                  
					}, function(errResponse) {
						console.error(errResponse.statusText);
					}
				);
			};
			var fetch_instrument_types = function() {
			  return $http.get('<?php echo base_url(); ?>index.php/instrument_type/get_instrument_type').then(
				  function(response) {
				self.instrument_types = response.data;
			  }, function(errResponse) {
				console.error(errResponse.statusText);
			  });
			};
			var fetch_cheque_leaves = function() {
				return $http.get('<?php echo base_url(); ?>index.php/cheque_leaves/get_cheque_leaves').then(
					function(response) {
						self.cheque_leaves = response.data;
					}, function(errResponse) {
						console.error(errResponse.statusText);
					}
				);
			};
			var fetchbank_accounts = function() {
				return $http.get('<?php echo base_url(); ?>index.php/bank_account/get_bank_accounts').then(
					function(response) {
						self.bank_accounts = response.data;                  
					}, function(errResponse) {
						console.error(errResponse.statusText);
					}
				);
			};
			self.itemsList = [];
			self.getItemsList = function(){
				return $http.get('<?php echo base_url(); ?>index.php/items/getItemsList').then(
					function(response) {
						self.itemsList = response.data;
						self.itemsList.splice(0, 0, {"item_id":"0","item_name":""});
					}, function(errResponse) {
						console.error(errResponse.statusText);
					}
				);
			};
			self.getItemsList();
			self.ledgerList = [];
			self.getLedgerList = function(){
				return $http.get('<?php echo base_url(); ?>index.php/ledger/getLedgerAccountList').then(
					function(response) {
						self.ledgerList = response.data;
					}, function(errResponse) {
						console.error(errResponse.statusText);
					}
				);
			};
			self.getLedgerList();
			self.ledgerSubAcntList = [];
			self.getLedgerSubAcntList = function(){
				return $http.get('<?php echo base_url(); ?>index.php/ledger/getLedgerSubAccountList').then(
					function(response) {
						self.ledgerSubAcntList = response.data;
						self.ledgerSubAcntList.splice(0, 0, {"ledger_sub_account_id":"0","ledger_sub_account_name":""});
					}, function(errResponse) {
						console.error(errResponse.statusText);
					}
				);
			};
			self.getLedgerSubAcntList();
			self.searchBankBooks = function(){
				var tempDetails = {};
				//jQuery.extend(tempDetails, self.searchBank_book);
				if(!self.PreDefTrnxType){
					tempDetails.fromdate = DateFormater.convertJsDate(self.searchBank_book.fromdate);
					tempDetails.todate = DateFormater.convertJsDate(self.searchBank_book.todate);
				}else{

					tempDetails.TranxType = self.PreDefTrnxType;
					tempDetails.clearancestatus = 0;
				}
				return $http.post('<?php echo base_url(); ?>index.php/bank_book/search_bank_books/<?php echo $bank_account_id; ?>', tempDetails).then(
					function(response) {
						self.bank_books = formatData(response.data);
					},
					function(errResponse) {
						console.error(errResponse.data.msg);
					}
				);
			};
			self.editRecord = function(record,vIndex){
				self.addflag = 0;
				// var vIndex = record.vRowTempID;
				var temp_bank_account_editing = self.bank_books.splice(vIndex,1);
				if(self.updateflag == 1){
					self.bank_books.splice(self.bank_book_index,0,self.bank_book_editing);
				}
				self.bank_book_index = vIndex;
				self.bank_book_editing = temp_bank_account_editing[0];

				self.newBank_book.transaction_id			= record.transaction_id;
				self.newBank_book.debit_credit				= record.debit_credit;
				self.newBank_book.date						= record.date;
				self.newBank_book.party_id					= record.party_id;
				self.newBank_book.narration					= record.narration;
				self.newBank_book.instrument_type_id		= record.instrument_type_id;
				self.newBank_book.instrument_id_manual		= record.instrument_id_manual;
				self.newBank_book.instrument_date			= record.instrument_date;
				self.newBank_book.bank_id					= record.bank_id;
				self.newBank_book.transaction_amount		= parseFloat(record.transaction_amount_ui);
				self.newBank_book.clearance_status			= record.clearance_status ? parseInt(record.clearance_status) : "";
				self.newBank_book.clearance_date			= record.clearance_date;
				self.newBank_book.bill_recieved				= record.bill_recieved ? parseInt(record.bill_recieved): "";
				self.newBank_book.notes						= record.notes;
				self.newBank_book.project_id				= record.project_id;

				self.updateflag = 1;
				$("#debit_credit").focus();
				self.getLedgerTransactions(record.transaction_id);
			};

			self.cancelUpdate = function(){
				self.newBank_book = {};
				self.newBank_book.account_id = "<?=$bank_account_id?>";
				self.newBank_book.bank_account_id = "<?=$bank_account_id?>";
				if(self.updateflag == 1){
					self.bank_books.splice(self.bank_book_index,0,self.bank_book_editing);
				}
				self.updateflag = 0;
				self.addflag = 0;
				self.bank_book_index = 0;
				self.bank_book_editing = {};
			};

			fetchbank_accounts();
			/*fetch_banks();
			fetch_projects();
			fetch_partys();*/
			fetch_instrument_types();
			//fetch_cheque_leaves();
			self.searchBankBooks();
			self.addTransaction = function() {
				if(self.newBank_book.ledgerDetails && self.newBank_book.ledgerDetails.length > 0){
					var vLedgersAmount = 0;
					$.each(self.newBank_book.ledgerDetails,function(i,v){
						if($.isNumeric(v.amount)){
							vLedgersAmount += parseFloat(v.amount);
						}else{
							alert("Only numbers are allowed in amount");
						}
					});
					if(vLedgersAmount != self.newBank_book.transaction_amount){
						alert("Sum of ledger transactions amount "+vLedgersAmount+", and total transaction amount "+self.newBank_book.transaction_amount+" must be equal");
						return false;
					}
				}else{
					alert("Please add atleast one ledger record to continue");
					return false;
				}
				var tempDetails = {};
				jQuery.extend(tempDetails, self.newBank_book);
				tempDetails.date = $("input[name=date]").val();
				tempDetails.instrument_date = $("input[name=instrument_date]").val();
				tempDetails.clearance_date = $("input[name=clearance_date]").val();

				$http.post('bank_book/add_transaction', tempDetails)
					.then(function(data){
						if(data){
							data = data.data;
							if(data){
								console.log(data);
								$.each(self.newBank_book.ledgerDetails,function(i,v){
									v["transaction_id"] = data.TrnxID;
									$http.post('ledger/addLedgerTransaction', v).then(function(){},function(){});
								});
							}
						}
					})
					.then(function(){
//						if(self.PreDefTrnxType)
						
						self.searchBankBooks();
						
//						else
//							self.fetchbank_books();
					})
					.then(function(response) {
						self.updateflag = 0;
						self.addflag = 0;
						self.bank_account_index = 0;
						self.bank_account_editing = {};
						self.newBank_book = {};
						//self.searchBank_book = {};
						self.newBank_book.account_id = "<?=$bank_account_id?>";
						self.newBank_book.bank_account_id = "<?=$bank_account_id?>";
					});
			};
			self.getLedgerTransactions = function(vTrnxID){
				$http.post('ledger/getLedgerTransactions/'+vTrnxID)
					.then(function(data){
						self.newBank_book.ledgerDetails = data.data;
					});
			}
			/**
			 * Mapping functions
			 */
			self.MapYesNo = function(vNum){
				if(vNum == "1") return "Yes";
				else if(vNum == "0") return "No";
				else return "";
				
			};
			self.MapDate = function(vDate){
				if(vDate)
					return vDate.getDate()+"-"+ (vDate.getMonth()+1) +"-"+vDate.getFullYear();
			};
			self.MapDateTime = function(vDate){
				if(vDate)
					return vDate.getDate()+"-"+ (vDate.getMonth()+1) +"-"+vDate.getFullYear()+" "+ ("0"+vDate.getHours()).slice(-2) +":"+("0"+vDate.getMinutes()).slice(-2);
			};
			self.MapPartyName = function(vPartyID){
				if(vPartyID)
					return $("#party_id option[value="+vPartyID+"]").text();
			};
			self.MapInstrumentType = function(vInstrumentTypeID){
				if(vInstrumentTypeID)
					return $("#instrument_type_id option[value="+vInstrumentTypeID+"]").text();
			};
			self.MapBankName = function(vBankID){
				if(vBankID)
					return $("#bank_id option[value="+vBankID+"]").text();
			};
			self.MapProject = function(vProjectID){
				if(vProjectID)
					return $("#project_id option[value="+vProjectID+"]").text();
			};

			/*$("#fromdate").Zebra_DatePicker({
				dateFormat:"dd-M-yy",
				changeYear:1,
				changeMonth:1
			});*/
			self.addNewLedgerRecord = function(){
				if(!self.newBank_book.ledgerDetails){
					self.newBank_book.ledgerDetails = [{"amount":self.newBank_book.transaction_amount,"ledger_account_id":"","ledger_sub_account_id":"","payee_party_id":self.newBank_book.party_id,"item_id":"","project_id":"","donor_party_id":""}];
				}
				else{
					var vRemainingBal = self.newBank_book.transaction_amount;
					$.each(self.newBank_book.ledgerDetails,function(i,v){
						if($.isNumeric(v.amount))
							vRemainingBal -= parseFloat(v.amount);
					});
					if(vRemainingBal < 0) vRemainingBal = 0;
					self.newBank_book.ledgerDetails.push({"amount":vRemainingBal,"ledger_account_id":"","ledger_sub_account_id":"","payee_party_id":self.newBank_book.party_id,"item_id":"","project_id":"","donor_party_id":""});
				}
			};
			self.deleteLedgerRecord = function(vIndex){
				
				if(self.newBank_book.ledgerDetails[vIndex] && self.newBank_book.ledgerDetails[vIndex].ledger_id){
					if(confirm("Are you sure you want to delete this record?")){
						return $http.get('<?php echo base_url(); ?>index.php/ledger/deleteLedgerTransaction/'+self.newBank_book.ledgerDetails[vIndex].ledger_id).then(
							function(response) {
								self.newBank_book.ledgerDetails.splice(vIndex,1);
								return true;
							}, function(errResponse) {
								console.error(errResponse.statusText);
							}
						);
					}
				}else{
					self.newBank_book.ledgerDetails.splice(vIndex,1);
				}
			};
		}])
		.filter('mapYesNo',[function(){
			return function(vNum){
				if(vNum == "1") return "Yes";
				else if(vNum == "0") return "No";
				else return "";
			}
		}])
		.filter('formatData',["DateFormater",function(DateFormater){
			return function(vBankBooks){
				var vFormatedBankBook = [];
				if(vBankBooks){
					$.each(vBankBooks,function(index,tempBankBook){
							tempBankBook.vRowTempID = index ;
							tempBankBook.date = DateFormater.convertDtToJSDate(tempBankBook.date) ;
							tempBankBook.instrument_date = DateFormater.convertToJSDate(tempBankBook.instrument_date) ;
							tempBankBook.clearance_date =  DateFormater.convertToJSDate(tempBankBook.clearance_date) ;
						
						vFormatedBankBook[index] = tempBankBook;
					});
				}
				return vFormatedBankBook;
			}
		}])
		.factory('DateFormater',[function(){
			return {
				convertDtToJSDate : function(vStringDate){
					if(vStringDate && vStringDate != "0000-00-00 00:00:00" && vStringDate.split('-').length > 2){
						var vTDate = new Date();
						var vSplitDate = vStringDate.split(' ');
						var vDatePart = vSplitDate[0].split('-');
						vTDate.setFullYear(vDatePart[0]);
						vTDate.setMonth(parseInt(vDatePart[1])-1);
						vTDate.setDate(vDatePart[2]);
						
						var vTimePart = vSplitDate[1].split(':');
						vTDate.setHours(vTimePart[0]);
						vTDate.setMinutes(vTimePart[1]);
						vTDate.setSeconds(0);
						vTDate.setMilliseconds(0);
						return  vTDate;
					}else{
						return "";
					}
				},
				convertToJSDate : function(vStringDate){
					if(vStringDate && vStringDate != "0000-00-00" && vStringDate.split('-').length > 2){
						var vTDate = new Date();
						var vSplitDate = vStringDate.split('-');
						vTDate.setFullYear(vSplitDate[0]);
						vTDate.setMonth(parseInt(vSplitDate[1])-1);
						vTDate.setDate(vSplitDate[2]);
						return vTDate;
					}else{
						return "";
					}
				},
				convertJsDate : function(vDate){
					if(vDate) return  vDate.getFullYear()+"-"+ ("0" + (vDate.getMonth()+1)).slice(-2) +"-"+ ("0" + vDate.getDate()).slice(-2);
					else return "";
				},
				convertJsDateTime : function(vDate){
					if(vDate) return  vDate.getFullYear()+"-"+ ("0" + (vDate.getMonth()+1)).slice(-2) +"-"+ ("0" + vDate.getDate()).slice(-2) + " " + vDate.getHours() + ":"+vDate.getMinutes();
					else return "";
				}
			};
		}])
		.factory('XHRCountsProv',[function(){
			var vActiveXhrCount = 0;
			return {
				newCall : function(){
					vActiveXhrCount++;
				},
				endCall : function(){
					vActiveXhrCount--;
				},
				getActiveXhrCount : function(){
					return vActiveXhrCount;
				}
			};
		}])
		.factory('HttpInterceptor',['$q','XHRCountsProv',function($q,XHRCountsProv){
			return {
				request : function(config){
					XHRCountsProv.newCall();
					$(".BusyLoopMain").removeClass("BusyLoopHide").addClass("BusyLoopShow");
					return config;
				},
				requestError: function(rejection){
					XHRCountsProv.endCall();
					if(XHRCountsProv.getActiveXhrCount() == 0)
						$(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
					return $q.reject(rejection);
				},
				response:function(response){
					XHRCountsProv.endCall();
					if(XHRCountsProv.getActiveXhrCount() == 0)
						$(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
					return response;
				},
				responseError:function(rejection){
					XHRCountsProv.endCall();
					if(XHRCountsProv.getActiveXhrCount() == 0)
						$(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
					return $q.reject(rejection);
				}

			};
		}])
		.config(['$httpProvider',function($httpProvider){
			$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
			$httpProvider.defaults.transformRequest.push(function(data){
				if(data){
					return $.param(JSON.parse(data));
				}else 
					return "";
			});
			$httpProvider.interceptors.push('HttpInterceptor');
		}]);

		/*angular.module('bank_booksApp').controller("TransactionCtrl",[function(){
			var self = this;
			console.log("setup");
			self.getInstrumentTypeDiplayParam = function(){
				console.debug(self.instrumenttypeid,vSelectedInstrumentType);
				return true ;
			};
			self.change = function(){
				self.vSelectedInstrumentType = $("#instrument_type_id option:selected").text().toUpperCase();
			};
			this.change();
		}]);*/
	</script>
</div>