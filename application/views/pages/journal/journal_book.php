<?php
?>
<style>
	fieldset.scheduler-border {
		border: 1px groove #ddd !important;
		padding: 0 1.4em 1.4em 1.4em !important;
		margin: 0 0 1.5em 0 !important;
		-webkit-box-shadow:  0px 0px 0px 0px #000;
				box-shadow:  0px 0px 0px 0px #000;
	}
	legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
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
	.table tbody{
		cursor: pointer;
	}
	.link{ 
		color: #009fff; 
		cursor: pointer;
		/*text-decoration: underline;*/
	}
	
</style>
<div ng-app="bank_booksApp">
	<div ng-controller ="Journal_bookCtrl as JournalCtrl">
		
		<?php
			if($this->session->logged_in == 'YES'){
		?>
			
			<div  class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2" >
				
					<div class="alert alert-info" role="alert">
						<label>Journal</label>
					</div>					
			</div>
			<div  class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2" ng-show="!JournalCtrl.addflag && !JournalCtrl.updateflag">
				<div class="  col-lg-4 col-md-6">
					<input type="button" class="btn btn-primary" ng-show="!JournalCtrl.PreDefTrnxType" ng-click="JournalCtrl.addflag=1" value="Add" />
				</div>
			</div>
			
			<div ng-show="JournalCtrl.addflag || JournalCtrl.updateflag" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				
				<form class="form-custom" ng-submit="JournalCtrl.addTransaction()" name="addTransaction">
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputEmail2"><span class="mand">*</span>Date</label>
					<input type="datetime-local" class="form-control" name="date" ng-model="JournalCtrl.newJournalTranx.journal_date_time" required="">              
				</div>
				<div class=" form-group col-lg-4 col-md-6">
					<label for="exampleInputName2">Narration</label>
					<input type="text" class="form-control" name="narration" ng-model="JournalCtrl.newJournalTranx.journal_narration"/>
				</div>
				<div class="col-sm-12 col-md-12">
					<fieldset class="scheduler-border">
						<legend class="scheduler-border">
							Debit
							<span class="glyphicon glyphicon-plus-sign" ng-click="JournalCtrl.addNewDebitRecord()" style="color: #13ad2f; cursor:pointer;" title="Add"></span>
						</legend>
						<div class="searchfrom col-lg-12">
							<table class="table tableevenodd table-hover" style="font-size: 11px;">
								<thead>
									<tr>
										<th>S.No.</th>
										<th><span class="mand">*</span>Amount</th>
										<th><span class="mand">*</span>Account</th>
										<th>Sub Account</th>
										<th>Narration</th>
										<th><span class="mand">*</span><span ng-bind="JournalCtrl.newJournalTranx.debit_credit == 'Credit' ? 'Payer Party' : 'Payee Party'"></span></th>
										<th>Item</th>
										<th>Project</th>
										<th>Donor Party</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="debitrecord in JournalCtrl.newJournalTranx.debitDetails">
										<th ng-bind="$index+1"></th>
										<th><input type="text" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" ng-model="debitrecord.amount" style="width:70px;"/></th>
										<th>
											<select required style="width:115px;" ng-model="debitrecord.ledger_account_id" ng-options="ledgerAccount.ledger_account_id as ledgerAccount.ledger_account_name for ledgerAccount in JournalCtrl.ledgerList">
											</select>
										
										</th>
										<th>
											<select  style="width:100px;" ng-model="debitrecord.ledger_sub_account_id" ng-options="ledgerSubAccount.ledger_sub_account_id as ledgerSubAccount.ledger_sub_account_name for ledgerSubAccount in JournalCtrl.ledgerSubAcntList">
											</select>
										
										</th>
										<th>
											<input type="text" ng-model="debitrecord.narration" style="width:70px;"/>
										</th>
										<th>
											<select required style="width:115px;" ng-model="debitrecord.payee_party_id" ng-options="party.party_id as party.party_name for party in JournalCtrl.parties">
											</select>
										</th>
										<th>
											<select style="width:115px;" ng-model="debitrecord.item_id" ng-options="item.item_id as item.item_name for item in JournalCtrl.itemsList">
											</select>
										</th>
										<th>
											<select style="width:115px;" ng-model="debitrecord.project_id" ng-options="project.project_id as project.project_name for project in JournalCtrl.projects">
											</select>
										</th>
										<th>
											<select style="width:115px;" ng-model="debitrecord.donor_party_id" ng-options="party.party_id as party.party_name for party in JournalCtrl.parties">
											</select>
										</th>
										<th>
											<span ng-click="JournalCtrl.deleteDebitRecord($index)"  class="glyphicon glyphicon-remove" title="Delete" style="color:#ea3131; cursor:pointer;"></span>
										</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
				<div class="col-sm-12 col-md-12">
					<fieldset class="scheduler-border">
						<legend class="scheduler-border">
							Credit
							<span class="glyphicon glyphicon-plus-sign" ng-click="JournalCtrl.addNewCreditRecord()" style="color: #13ad2f; cursor:pointer;" title="Add"></span>
						</legend>
						<div class="searchfrom col-lg-12">
							<table class="table tableevenodd table-hover" style="font-size: 11px;">
								<thead>
									<tr>
										<th>S.No.</th>
										<th><span class="mand">*</span>Amount</th>
										<th><span class="mand">*</span>Account</th>
										<th>Sub Account</th>
										<th>Narration</th>
										<th><span class="mand">*</span><span ng-bind="JournalCtrl.newJournalTranx.debit_credit == 'Credit' ? 'Payer Party' : 'Payee Party'"></span></th>
										<th>Item</th>
										<th>Project</th>
										<th>Donor Party</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="creditrecord in JournalCtrl.newJournalTranx.creditDetails">
										<th ng-bind="$index+1"></th>
										<th><input type="text" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" ng-model="creditrecord.amount" style="width:70px;"/></th>
										<th>
											<select required style="width:115px;" ng-model="creditrecord.ledger_account_id" ng-options="ledgerAccount.ledger_account_id as ledgerAccount.ledger_account_name for ledgerAccount in JournalCtrl.ledgerList">
											</select>
										
										</th>
										<th>
											<select  style="width:100px;" ng-model="creditrecord.ledger_sub_account_id" ng-options="ledgerSubAccount.ledger_sub_account_id as ledgerSubAccount.ledger_sub_account_name for ledgerSubAccount in JournalCtrl.ledgerSubAcntList">
											</select>
										
										</th>
										<th>
											<input type="text" ng-model="creditrecord.narration" style="width:70px;"/>
										</th>
										<th>
											<select required style="width:115px;" ng-model="creditrecord.payee_party_id" ng-options="party.party_id as party.party_name for party in JournalCtrl.parties">
											</select>
										</th>
										<th>
											<select style="width:115px;" ng-model="creditrecord.item_id" ng-options="item.item_id as item.item_name for item in JournalCtrl.itemsList">
											</select>
										</th>
										<th>
											<select style="width:115px;" ng-model="creditrecord.project_id" ng-options="project.project_id as project.project_name for project in JournalCtrl.projects">
											</select>
										</th>
										<th>
											<select style="width:115px;" ng-model="creditrecord.donor_party_id" ng-options="party.party_id as party.party_name for party in JournalCtrl.parties">
											</select>
										</th>
										<th>
											<span ng-click="JournalCtrl.deleteCreditRecord($index)"  class="glyphicon glyphicon-remove" title="Delete" style="color:#ea3131; cursor:pointer;"></span>
										</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-sm-12 col-md-12">
						<input type="submit" class="btn btn-default" value="{{JournalCtrl.getSubmitButtonText()}}" ng-disabled="addTransaction.$invalid">
						<input type="button" class="btn btn-default" value="Cancel" ng-click="JournalCtrl.cancelUpdate()" ng-show="JournalCtrl.updateflag || JournalCtrl.addflag">
					</div>
					
					</form>
				</div>
			</fieldset>
		<?php
			}
		?>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 " ng-show="!JournalCtrl.PreDefTrnxType">
			<h3>Search</h3>
			<div class="searchfrom col-lg-12">
				<form class="form-inline" name="search_bankbook" ng-submit="JournalCtrl.searchJournalRecords()">
						<div class="from-group col-lg-4 col-md-4">
							<label>From Date</label>
							<input type="date" id="fromdate" class="form-control" ng-model="JournalCtrl.searchBank_book.fromdate" ng-required="!JournalCtrl.searchBank_book.todate"/>
						</div>	
						<div class="from-group col-lg-4 col-md-4">
							<label>To Date</label>
							<input type="date" id="todate" class="form-control " ng-model="JournalCtrl.searchBank_book.todate" ng-required="!JournalCtrl.searchBank_book.fromdate"/>
						</div>
					<input type="submit" class="btn btn-default" value="Search" ng-show="JournalCtrl.updateflag == 0" ng-disabled="search_bankbook.$invalid"/>
				</form>
			</div>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="panel panel-yellow ">
				<div class="panel-heading">Transactions</div>
				<div style="overflow-x: scroll">
					<table class="table table table-hover" style="font-size: 11px;">
						<thead>
							<tr>
								<th>
									S.No.
								</th>
								<th>
									Voucher ID
								</th>
								<th title="Operations">
									Opp.
								</th>
								<th title="Transaction Date" ng-click="JournalCtrl.sortBy('date')">
									Journal Date

									<span class="sortorder" ng-show="JournalCtrl.propertyName === 'date'" ng-class="{reverse: JournalCtrl.reverse}"></span>
								</th>
								<th ng-click="JournalCtrl.sortBy('narration')">
									Narration
									<span class="sortorder" ng-show="JournalCtrl.propertyName === 'narration'" ng-class="{reverse: JournalCtrl.reverse}"></span>
								</th>
								<th title="Attachments">
									Att.
								</th>
								<th title="Transaction Type" ng-click="JournalCtrl.sortBy('debit_credit')">
									Trnx. Type
									<span class="sortorder" ng-show="JournalCtrl.propertyName === 'debit_credit'" ng-class="{reverse: JournalCtrl.reverse}"></span>
								</th>
								<th title="Transaction Amount" ng-click="JournalCtrl.sortBy('transaction_amount_ui')">
									Trnx. Amt.
									<span class="sortorder" ng-show="JournalCtrl.propertyName === 'transaction_amount_ui'" ng-class="{reverse: JournalCtrl.reverse}"></span>
								</th>
								<th title="Account">
									Act.
								</th>
								<th title="Sub Account">
									Sub Act.
								</th>
								<th >
									Narration
								</th>
								<th title="Payee Party">
									Payee
								</th>
								<th title="Item Name">
									Item
								</th>
								<th title="Project Name">
									Project
								</th>
								<th title="Donor Party">
									Donor
								</th>
							</tr>
						</thead>
						
						<tbody >
						
							<?php
							
								if($this->session->logged_in == 'YES'){
							?>
							
							<tr class="active">
								<td rowspan="{{ JournalCtrl.newJournalTranx.debitDetails.length + JournalCtrl.newJournalTranx.creditDetails.length + 1 }}" ></td>
								<td rowspan="{{ JournalCtrl.newJournalTranx.debitDetails.length + JournalCtrl.newJournalTranx.creditDetails.length + 1 }}" ></td>
								<td rowspan="{{ JournalCtrl.newJournalTranx.debitDetails.length + JournalCtrl.newJournalTranx.creditDetails.length + 1 }}" ></td>
								<td rowspan="{{ JournalCtrl.newJournalTranx.debitDetails.length + JournalCtrl.newJournalTranx.creditDetails.length + 1 }}" ng-bind="JournalCtrl.newJournalTranx.journal_date_time | date:'dd-MMM-yyyy HH:mm'"></td>
								<td rowspan="{{ JournalCtrl.newJournalTranx.debitDetails.length + JournalCtrl.newJournalTranx.creditDetails.length + 1 }}" ng-bind="JournalCtrl.newJournalTranx.journal_narration"></td>
								<td rowspan="{{ JournalCtrl.newJournalTranx.debitDetails.length + JournalCtrl.newJournalTranx.creditDetails.length + 1 }}" class="link" ng-bind="ledgerrecord.attachments_count" ng-click="JournalCtrl.AttachFiles(ledgerrecord)"></td>
							</tr>
							
							<tr class="active" ng-repeat="ledgerrecord in JournalCtrl.newJournalTranx.debitDetails">
								<td ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.debit_credit"></td>
								<td nowrap ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.amount | currency : '&#x20b9 ' "></td>
								<td ng-bind="ledgerrecord.ledger_account_name"></td>
								<td ng-bind="ledgerrecord.ledger_sub_account_name"></td>
								<td ng-bind="ledgerrecord.narration"></td>
								<td ng-bind="ledgerrecord.payee_party"></td>
								<td ng-bind="ledgerrecord.item_name"></td>
								<td ng-bind="ledgerrecord.project_name"></td>
								<td ng-bind="ledgerrecord.donor_party"></td>
								
							</tr>
							<tr class="active" ng-repeat="ledgerrecord in JournalCtrl.newJournalTranx.creditDetails">
								<td ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.debit_credit"></td>
								<td nowrap ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.amount | currency : '&#x20b9 ' "></td>
								<td class="link" ng-bind="ledgerrecord.attachments_count" ng-click="JournalCtrl.AttachFiles(ledgerrecord)"></td>
								<td ng-bind="ledgerrecord.ledger_account_name"></td>
								<td ng-bind="ledgerrecord.ledger_sub_account_name"></td>
								<td ng-bind="ledgerrecord.narration"></td>
								<td ng-bind="ledgerrecord.payee_party"></td>
								<td ng-bind="ledgerrecord.item_name"></td>
								<td ng-bind="ledgerrecord.project_name"></td>
								<td ng-bind="ledgerrecord.donor_party"></td>
								
							</tr>
							<?php
								}
							?>
							<tbody  ng-repeat="journalRecord in JournalCtrl.journalRecords">
							
								<tr > <!-- | orderBy:JournalCtrl.propertyName:JournalCtrl.reverse -->
									<td rowspan="{{ journalRecord.debits.length + journalRecord.credits.length + 1 }}" style="vertical-align:middle;" ng-bind="$index+1"></td>
									<td rowspan="{{ journalRecord.debits.length + journalRecord.credits.length + 1 }}" style="vertical-align:middle;" ng-bind="journalRecord.journal_annual_voucher_id"></td>
									<td rowspan="{{ journalRecord.debits.length + journalRecord.credits.length + 1 }}" style="vertical-align:middle;" >
										<?php
											if($this->session->logged_in == 'YES'){
										?>
											<span class="fa-buttons" title="Edit" ng-click="JournalCtrl.editRecord(journalRecord,$index)"> <i class="fa fa-pencil-square-o fa-2" aria-hidden="true"></i> </span>
										<?php
											}
										?>	
												
										
										<input type="button" ng-click="JournalCtrl.JournalVoucher(journalRecord)" value="Journal Voucher" />	
									</td>
									<td rowspan="{{ journalRecord.debits.length + journalRecord.credits.length + 1 }}" style="vertical-align:middle;" ng-bind="journalRecord.journal_date_time | date:'dd-MMM-yyyy HH:mm'"></td>
									<td rowspan="{{ journalRecord.debits.length + journalRecord.credits.length + 1 }}" style="vertical-align:middle;" ng-bind="journalRecord.journal_narration"></td>
									<td rowspan="{{ journalRecord.debits.length + journalRecord.credits.length + 1 }}" style="vertical-align:middle;" class="link" ng-bind="journalRecord.attachments_count" ng-click="JournalCtrl.AttachFiles(journalRecord)"></td>
								</tr>
								<tr ng-repeat="ledgerrecord in journalRecord.debits">
									<td ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.debit_credit"></td>
									<td nowrap ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.amount | currency : '&#x20b9 ' "></td>
									<td ng-bind="ledgerrecord.ledger_account_name"></td>
									<td ng-bind="ledgerrecord.ledger_sub_account_name"></td>
									<td ng-bind="ledgerrecord.narration"></td>
									<td ng-bind="ledgerrecord.payee_party"></td>
									<td ng-bind="ledgerrecord.item_name"></td>
									<td ng-bind="ledgerrecord.project_name"></td>
									<td ng-bind="ledgerrecord.donor_party"></td>
									
								</tr>
								<tr ng-repeat="ledgerrecord in journalRecord.credits">
									<td ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.debit_credit"></td>
									<td nowrap ng-class="ledgerrecord.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="ledgerrecord.amount | currency : '&#x20b9 ' "></td>
									<td ng-bind="ledgerrecord.ledger_account_name"></td>
									<td ng-bind="ledgerrecord.ledger_sub_account_name"></td>
									<td ng-bind="ledgerrecord.narration"></td>
									<td ng-bind="ledgerrecord.payee_party"></td>
									<td ng-bind="ledgerrecord.item_name"></td>
									<td ng-bind="ledgerrecord.project_name"></td>
									<td ng-bind="ledgerrecord.donor_party"></td>
									
								</tr>
							
							</tbody>
							<tr class="success" align="center" ng-show="JournalCtrl.journalRecords.length == 0"><td colspan="17">There are no transactions during this period</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>
		angular.module('bank_booksApp', [])
		.controller('Journal_bookCtrl', ['$http',"formatDataFilter","DateFormater", function($http,formatData,DateFormater) {
			var self = this;
			self.vTempLoopID = 0;
//			self.propertyName = 'date';
//  			self.reverse = true;
  			self.sortBy = function(propertyName) {
			    self.reverse = (self.propertyName === propertyName) ? ! self.reverse : false;
			    self.propertyName = propertyName;
			  };
			$("#LefNaveJournal").addClass("active");
			self.projects = <?=json_encode($projects)?>;
			self.projects.splice(0, 0, {"project_id":"0","project_name":""});
			self.parties = <?=json_encode($parties)?>;
			self.parties.splice(0, 0, {"party_id":"0","party_name":""});

			self.journalRecords = [];
			self.banks = [];
			self.partys = [];
			self.updateflag = 0;
			self.addflag = 0;
			self.bank_book_index ;
			self.bank_book_editing ;
			self.newJournalTranx = {};
			self.staticData = {};
			
			
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
				var vNewForm = "<form method='post' action='/funds_tracker/upload' id='form_"+vBook.journal_id+"' style='display:none;'>";
				vNewForm += '<input type="hidden" name="bank_account_id" value="'+self.staticData.bank_account_id+'" />';
				vNewForm += '<input type="hidden" name="bank" value="'+self.staticData.bank_id+'" />';
				vNewForm += '<input type="hidden" name="account_name" value="'+self.staticData.bank_account_name+'" />';
				vNewForm += '<input type="hidden" name="account_number" value="'+self.staticData.bank_account_number+'" />';
				vNewForm += '<input type="hidden" name="TrnxType" value="'+self.PreDefTrnxType+'" />';
				vNewForm += '<input type="hidden" name="StartDate" value="'+DateFormater.convertJsDate(self.searchBank_book.fromdate)+'" />';
				vNewForm += '<input type="hidden" name="Date" value="'+DateFormater.convertJsDateTime(vBook.journal_date_time)+'" />';
				vNewForm += '<input type="hidden" name="PartyName" value="'+(vBook.party_name == null ? "" :vBook.party_name) +'" />';
				vNewForm += '<input type="hidden" name="Narration" value="'+vBook.journal_narration+'" />';
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
				vNewForm += '<input type="hidden" name="ledgerType" value="2" />';
				vNewForm += '<input type="hidden" name="Module" value="journal" />';

				vNewForm += '<input type="hidden" name="EndDate" value="'+DateFormater.convertJsDate(self.searchBank_book.todate)+'" />';
				vNewForm += '<input type="hidden" name="TranxID" value="'+vBook.journal_id+'" />';
			  	vNewForm += "</form>";
			  	$("body").append(vNewForm);
			  	$("#form_"+vBook.journal_id).submit();
			};
			self.fetchbank_books = function() {
				return $http.get('<?php echo base_url(); ?>index.php/bank_book/get_bank_books/<?php echo $bank_account_id; ?>').then(
					function(response) {
						
						var data = formatData(response.data);
						var formatedData = {};
						angular.forEach(data,function(value,key){
							if(!formatedData[value.journal_id]){
								var vTranxDetails = {};
								vTranxDetails['journal_date_time'] = value.journal_date_time;
								vTranxDetails['journal_narration'] = value.journal_narration;
								vTranxDetails['attachments_count'] = value.attachments_count;
								vTranxDetails['debits'] = [];
								vTranxDetails['credits'] = [];
								formatedData[value.journal_id] = vTranxDetails;
							}
							if(value.debit_credit == "Debit")
								formatedData[value.journal_id].debits.push(value);
							else
								formatedData[value.journal_id].credits.push(value);
						});
						self.journalRecords = formatedData;
						
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
			self.searchJournalRecords = function(){
				var tempDetails = {};
				if(!self.PreDefTrnxType){
					tempDetails.fromdate = DateFormater.convertJsDate(self.searchBank_book.fromdate);
					tempDetails.todate = DateFormater.convertJsDate(self.searchBank_book.todate);
				}else{

					tempDetails.TranxType = self.PreDefTrnxType;
					tempDetails.clearancestatus = 0;
				}
				return $http.post('<?php echo base_url(); ?>index.php/journal/searchJournalRecords', tempDetails).then(
					function(response) {
						self.journalRecords = [];
						var vData = formatData(response.data.Journals);
						
						var formatedData = {};
						angular.forEach(vData,function(value,key){
							if(!formatedData[value.journal_id]){
								var vTranxDetails = {};
								vTranxDetails['journal_annual_voucher_id'] = value.journal_annual_voucher_id;
								vTranxDetails['journal_date_time'] = value.journal_date_time;
								vTranxDetails['journal_narration'] = value.journal_narration;
								vTranxDetails['attachments_count'] = value.attachments_count;
								vTranxDetails['debits'] = [];
								vTranxDetails['credits'] = [];
								formatedData[value.journal_id] = vTranxDetails;
							}
							if(value.debit_credit == "Debit")
								formatedData[value.journal_id].debits.push(value);
							else
								formatedData[value.journal_id].credits.push(value);
						});
						$.each(formatedData,function(key,value){
							value['journal_id'] = key;
							self.journalRecords.push(value);
						});
					},
					function(errResponse) {
						console.error(errResponse.data.msg);
					}
				);
			};
			self.editRecord = function(record,vIndex){
				self.addflag = 0;
				var temp_bank_account_editing = self.journalRecords.splice(vIndex,1);
				if(self.updateflag == 1){
					self.journalRecords.splice(self.bank_book_index,0,self.bank_book_editing);
				}
				self.bank_book_index = vIndex;
				self.bank_book_editing = temp_bank_account_editing[0];

				self.newJournalTranx.journal_id				= record.journal_id;
				self.newJournalTranx.journal_date_time			= record.journal_date_time;
				self.newJournalTranx.journal_narration			= record.journal_narration;

				self.newJournalTranx.debitDetails  = record.debits;
				self.newJournalTranx.creditDetails  = record.credits;
				
				self.updateflag = 1;
				//self.getLedgerTransactions(record.journal_id);
			};

			self.cancelUpdate = function(){
				self.newJournalTranx = {};
				if(self.updateflag == 1){
					self.journalRecords.splice(self.bank_book_index,0,self.bank_book_editing);
				}
				self.updateflag = 0;
				self.addflag = 0;
				self.bank_book_index = 0;
				self.bank_book_editing = {};
			};

			self.searchJournalRecords();
			self.addTransaction = function() {
				var vDebitAmount = 0;
				if(self.newJournalTranx.debitDetails && self.newJournalTranx.debitDetails.length > 0){
					$.each(self.newJournalTranx.debitDetails,function(i,v){
						if($.isNumeric(v.amount)){
							vDebitAmount += parseFloat(v.amount);
						}else{
							alert("Only numbers are allowed in amount");
						}
					});
				}else{
					alert("Please add atleast one Debit record to continue");
					return false;
				}
				var vCreditAmount = 0;
				if(self.newJournalTranx.creditDetails && self.newJournalTranx.creditDetails.length > 0){
					$.each(self.newJournalTranx.creditDetails,function(i,v){
						if($.isNumeric(v.amount)){
							vCreditAmount += parseFloat(v.amount);
						}else{
							alert("Only numbers are allowed in amount");
						}
					});
				}else{
					alert("Please add atleast one Credit record to continue");
					return false;
				}
				if(vDebitAmount != vCreditAmount){
					alert("Sum of debit transactions amount "+vDebitAmount+", and credit transaction amount "+vCreditAmount+" must be equal");
					return false;
				}
				var tempDetails = {};
				jQuery.extend(tempDetails, self.newJournalTranx);
				tempDetails.journal_date_time = $("input[name=date]").val();
				$http.post('journal/addJournalTransaction', tempDetails)
					.then(function(data){
						if(data){
							data = data.data;
							return data;
						}
					})
					.then(function(data){
						if(data){
							$.each(self.newJournalTranx.debitDetails,function(i,v){
								v["transaction_id"] = data.journal_id;
								v["debit_credit"] = "Debit";
								v["ledger_reference_table"] = 2;
								$http.post('ledger/addLedgerTransaction', v).then(function(){},function(){});
							});

							$.each(self.newJournalTranx.creditDetails,function(i,v){
								v["transaction_id"] = data.journal_id;
								v["debit_credit"] = "Credit";
								v["ledger_reference_table"] = 2;
								$http.post('ledger/addLedgerTransaction', v).then(function(){},function(){});
							});
						}
					})
					.then(function(){
						self.searchJournalRecords();
					})
					.then(function(response) {
						self.updateflag = 0;
						self.addflag = 0;
						self.bank_account_index = 0;
						self.bank_account_editing = {};
						self.newJournalTranx = {};
					});
			};
			self.getLedgerTransactions = function(vTrnxID){
				$http.post('ledger/getLedgerTransactions/'+vTrnxID+"/2")
					.then(function(data){
						self.newJournalTranx.debitDetails = data.data;
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

			self.addNewDebitRecord = function(){
				if(!self.newJournalTranx.debitDetails){
					self.newJournalTranx.debitDetails = [{"amount":self.newJournalTranx.transaction_amount,"ledger_account_id":"","ledger_sub_account_id":"","payee_party_id":self.newJournalTranx.party_id,"item_id":"","project_id":"","donor_party_id":""}];
				}
				else{
					var vRemainingBal = self.newJournalTranx.transaction_amount;
					$.each(self.newJournalTranx.debitDetails,function(i,v){
						if($.isNumeric(v.amount))
							vRemainingBal -= parseFloat(v.amount);
					});
					if(vRemainingBal < 0) vRemainingBal = 0;
					self.newJournalTranx.debitDetails.push({"amount":vRemainingBal,"ledger_account_id":"","ledger_sub_account_id":"","payee_party_id":self.newJournalTranx.party_id,"item_id":"","project_id":"","donor_party_id":""});
				}
			};
			self.deleteDebitRecord = function(vIndex){
				
				if(self.newJournalTranx.debitDetails[vIndex] && self.newJournalTranx.debitDetails[vIndex].ledger_id){
					if(confirm("Are you sure you want to delete this record?")){
						return $http.get('<?php echo base_url(); ?>index.php/ledger/deleteLedgerTransaction/'+self.newJournalTranx.debitDetails[vIndex].ledger_id).then(
							function(response) {
								self.newJournalTranx.debitDetails.splice(vIndex,1);
								return true;
							}, function(errResponse) {
								console.error(errResponse.statusText);
							}
						);
					}
				}else{
					self.newJournalTranx.debitDetails.splice(vIndex,1);
				}
			};
			
			self.addNewCreditRecord = function(){
				if(!self.newJournalTranx.creditDetails){
					self.newJournalTranx.creditDetails = [{"amount":self.newJournalTranx.transaction_amount,"ledger_account_id":"","ledger_sub_account_id":"","payee_party_id":self.newJournalTranx.party_id,"item_id":"","project_id":"","donor_party_id":""}];
				}
				else{
					var vRemainingBal = self.newJournalTranx.transaction_amount;
					$.each(self.newJournalTranx.creditDetails,function(i,v){
						if($.isNumeric(v.amount))
							vRemainingBal -= parseFloat(v.amount);
					});
					if(vRemainingBal < 0) vRemainingBal = 0;
					self.newJournalTranx.creditDetails.push({"amount":vRemainingBal,"ledger_account_id":"","ledger_sub_account_id":"","payee_party_id":self.newJournalTranx.party_id,"item_id":"","project_id":"","donor_party_id":""});
				}
			};
			self.deleteCreditRecord = function(vIndex){
				
				if(self.newJournalTranx.creditDetails[vIndex] && self.newJournalTranx.creditDetails[vIndex].ledger_id){
					if(confirm("Are you sure you want to delete this record?")){
						return $http.get('<?php echo base_url(); ?>index.php/ledger/deleteLedgerTransaction/'+self.newJournalTranx.creditDetails[vIndex].ledger_id).then(
							function(response) {
								self.newJournalTranx.creditDetails.splice(vIndex,1);
								return true;
							}, function(errResponse) {
								console.error(errResponse.statusText);
							}
						);
					}
				}else{
					self.newJournalTranx.creditDetails.splice(vIndex,1);
				}
			};
			
			
			
			self.JournalVoucher = function(vBook){
				window.open("<?php echo base_url(); ?>journal/print_journal_voucher/"+vBook.journal_id, ""	);
			}
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
							tempBankBook.journal_date_time = DateFormater.convertDtToJSDate(tempBankBook.journal_date_time) ;
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
						var vTDate = Date.parse(vStringDate);
						return new Date(vTDate);
						
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
						var vTDate = Date.parse(vStringDate);
						return new Date(vTDate);
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