<style>
	.mand{
		color:red;
	}
	label{
		min-width:90px;
	}
	.searchfrom label{
		width:105px;
	}
	input:not([type]),input[type="date"]{
		width:220px !important;
	}
	.link{ 
		color: #009fff; 
		cursor: pointer;
		/*text-decoration: underline;*/
	}
	table, th, td {
	   border: 1px solid #dad7d7;
	}
	.Totaltr td{
		background-color: #edf0f3;
	}
	.TotalRecord td{
		background: #11495a;
		font-weight: bold;
		color: white;
	}
	.AcntTypeTotal td{
		background: lightgrey;
		font-weight: bold;
		/*color: white;*/
	}
</style>


<div ng-app ="bank_accountsApp" id="PartyApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="padding-left:0px; padding-right:0px;">
    <div ng-controller ="LedgerReport as LedgerCtrl">
        <div ng-view></div>
		<div class="col-lg-12">
			<form class="form-inline" ng-show="LedgerCtrl.selectedDiv != '/LedgerDetails'" ng-submit="LedgerCtrl.searchData()" name="PartyReportForm">
				<div class="form-group col-lg-4 col-md-6">
				  <label for="SearchBy"><span class="mand">*</span>Search By</label>
				  <select id="SearchBy" class="form-control" ng-model="LedgerCtrl.search.searchBy" style="width:220px;" required="">
					<option selected value="1">Ledger Account</option>
					<option value="7">Ledger vs Project R1</option>
					<option value="8">Ledger vs Project R2</option>
					<option value="2">Ledger Sub Account</option>
					<option value="3">Payee Party</option>
					<option value="4">Item</option>
					<option value="5">Project</option>
					<option value="6">Donor Party</option>
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '3' || LedgerCtrl.search.searchBy == '6'">
				  <label for="PartyName">Party</label>
				  <select id="PartyName" class="form-control" ng-model="LedgerCtrl.search.partyID" 
					  ng-options="Party.party_id as Party.party_name for Party in LedgerCtrl.Parties" style="width:220px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '4'">
				  <label for="ItemID">Items</label>
				  <select id="ItemID" class="form-control" ng-model="LedgerCtrl.search.itemID" 
					  ng-options="Item.item_id as Item.item_name for Item in LedgerCtrl.items" style="width:220px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '5'">
				  <label for="ProjectName">Project</label>
				  <select id="ProjectName" class="form-control" ng-model="LedgerCtrl.search.projectID" 
					  ng-options="Project.project_id as Project.project_name for Project in LedgerCtrl.projects" style="width:220px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '1'|| LedgerCtrl.search.searchBy == '7'|| LedgerCtrl.search.searchBy == '8'">
				  <label for="LedgerAcntID" title="Ledger Account">Account</label>
				  <select id="LedgerAcntID" class="form-control" ng-model="LedgerCtrl.search.ledgerAcntID" 
					  ng-options="LedgerAcnt.ledger_account_id as LedgerAcnt.ledger_account_name for LedgerAcnt in LedgerCtrl.ledgerAccounts" style="width:220px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '2'">
				  <label for="LedgerSubAcntID" title="Ledger Sub Account">Sub Account</label>
				  <select id="LedgerSubAcntID" class="form-control" ng-model="LedgerCtrl.search.ledgerSubAcntID" 
					  ng-options="LedgerSubAcnt.ledger_sub_account_id as LedgerSubAcnt.ledger_sub_account_name for LedgerSubAcnt in LedgerCtrl.ledgerSubAccounts" style="width:220px;" >
				  </select>
				</div>
				 <div class="form-group col-lg-4 col-md-6">
					<label for="startdate">Start Date</label>
					<input type="date" id="startdate" date-format="dd-MMM-yyyy" class="form-control" name="startdate" ng-model="LedgerCtrl.search.startDate">
				</div>
				<div class="form-group col-lg-4 col-md-6">
					<label for="enddate">End Date</label>
					<input type="date" id="enddate" date-format="dd-MMM-yyyy" class="form-control" name="enddate" ng-model="LedgerCtrl.search.endDate">
				</div>
				<div class="form-group col-lg-4 col-md-6">
					<label for="bankaccount">Account</label>
					<select name="bankaccount" id="bankaccount" class="form-control" ng-model="LedgerCtrl.search.bankaccount" style="width:220px;">
						<option value=""></option>
						<?php
						foreach($bankaccounts as $tempbank){ ?>
						<option value='<?php echo $tempbank->bank_account_id; ?>'><?php echo $tempbank->account_name; ?></option>";
						<?php }
						?>
						<option value="Journal">Journal</option>
					</select>
					</div>
				<div class="form-group col-lg-12 col-md-12">
					<input style="margin-top: 15px; margin-left: 15px;" type="submit" class="btn btn-default" value="Search" ng-disabled="PartyReportForm.$invalid">
					<input style="margin-top: 15px;" type="button" class="btn btn-default" value="Clear" ng-click="LedgerCtrl.clear()">
				</div>
			</form>
		</div>
		<div class="col-lg-12" ng-show="LedgerCtrl.selectedDiv != '/LedgerDetails'" style="margin-top: 5px; ">
			<div class="panel panel-yellow " >
				<div class="panel-heading">Ledger Accounts</div>
				<div style="overflow-x: scroll">
					<table class="table table-hover " >
						<thead>
							<tr>
								<th rowspan="2">S.No.</th>
								<th rowspan="2" ng-if="!LedgerCtrl.recentsearch.searchID">Account</th>
								<th rowspan="2">Account Name</th>
								<th rowspan="2" ng-if="LedgerCtrl.recentsearch.searchBy == '7'">Project</th>
								<th colspan="2" style="text-align: center;">Debits</th>
								<th colspan="2" style="text-align: center;">Credits</th>
								<th rowspan="2" style="text-align: center;" title="Balance Type">Bal. Type</th>
								<th rowspan="2" style="text-align: center;" title="Balance">Balance</th>
								<th colspan="6" ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat="(id,name) in LedgerCtrl.ProjectsList" ng-bind="name || 'Unassigned'" style="text-align: center;" ></th>
							</tr>
							<tr>
								<th >#</th>
								<th class="num-align">Amount</th>
								<th >#</th>
								<th class="num-align">Amount</th>

								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" >#</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >Debit</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >#</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >Credit</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >Bal Type</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat-end >Bal</th>

							</tr>
						</thead>
						<tbody>
							<tbody ng-repeat="(acnttype,acntTypeData) in LedgerCtrl.PartiesData">
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '1'">								
									<td  colspan="{{LedgerCtrl.recentsearch.searchID ? 8 : 9}}" ng-bind="acnttype" style="background-color: #fbf9c9;"></td>
								</tr>
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '7'">								
									<td  colspan="{{LedgerCtrl.recentsearch.searchID ? 9 : 10}}" ng-bind="acnttype" style="background-color: #fbf9c9;"></td>
								</tr>
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '8'">								
									<td  colspan="{{LedgerCtrl.getColSpan()}}" ng-bind="acnttype" style="background-color: #fbf9c9;"></td>
								</tr>
								<tr ng-repeat-start="(typename,TypePartiesData) in acntTypeData">
									<td rowspan="{{LedgerCtrl.getRowSpan(TypePartiesData)}}" ng-bind="$index+1"></td>
									<td ng-if="!LedgerCtrl.recentsearch.searchID" rowspan="{{LedgerCtrl.getRowSpan(TypePartiesData)}}" ng-bind="typename"></td>
								</tr>
								<tr ng-repeat="PartyData in TypePartiesData" ng-if="LedgerCtrl.recentsearch.searchBy != '7' && LedgerCtrl.recentsearch.searchBy != '8'">
									<td ng-bind="PartyData.account_name"></td>
									<td class="num-align" ng-if=" LedgerCtrl.recentsearch.searchBy == '7'" ></td>
									<td class="num-align" ng-bind="PartyData.PayTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit')" ng-bind="PartyData.PayTotal | currency:''"></td>
									<td class="num-align" ng-bind="PartyData.RecptTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit')" ng-bind="PartyData.RecptTotal | currency:''"></td>
									<td ng-bind="(parseFloat(PartyData.PayTotal) > parseFloat(PartyData.RecptTotal)) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(PartyData.PayTotal - PartyData.RecptTotal) | abs | currency:''"></td>
								</tr>
								<tr ng-repeat-start="PartyData in TypePartiesData" ng-if="LedgerCtrl.recentsearch.searchBy == '7'">
									<td ng-bind="LedgerCtrl.getAccountName(PartyData)"></td>
									<td ng-if=" LedgerCtrl.recentsearch.searchBy == '7'" >
										<!--<div ng-repeat="PrjctTrnx in PartyData">
											<span ng-if="PrjctTrnx.project_name || PrjctTrnx.amount " ng-bind="(PrjctTrnx.project_name || 'Unassigned')+':'+ (PrjctTrnx.amount | currency:'')"></span>
										</div>-->
									</td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'PayTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'PayTotal') | currency:''"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'RecptTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'RecptTotal') | currency:''"></td>
									<td ng-bind="(parseFloat(LedgerCtrl.sumByFloat(PartyData,'PayTotal')) > parseFloat(LedgerCtrl.sumByFloat(PartyData,'RecptTotal'))) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(PartyData,'PayTotal') - LedgerCtrl.sumByFloat(PartyData,'RecptTotal')) | abs | currency:''"></td>
								</tr>


								<tr ng-repeat-end ng-repeat="PrjctTrnx in PartyData" ng-if="LedgerCtrl.recentsearch.searchBy == '7'">
									<td ></td>
									<td class="num-align" ng-bind="PrjctTrnx.project_name || 'Unassigned'" ></td>
									<td class="num-align" ng-bind="PrjctTrnx.PayTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PrjctTrnx,'','Debit', PrjctTrnx.project_id)" ng-bind="PrjctTrnx.PayTotal | currency:''"></td>
									<td class="num-align" ng-bind="PrjctTrnx.RecptTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PrjctTrnx,'','Credit', PrjctTrnx.project_id)" ng-bind="PrjctTrnx.RecptTotal | currency:''"></td>
									<td ng-bind="(parseFloat(PrjctTrnx.PayTotal) > parseFloat(PrjctTrnx.RecptTotal)) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(PrjctTrnx.PayTotal - PrjctTrnx.RecptTotal) | abs | currency:''"></td>
								</tr>


								<tr ng-repeat="PartyData in TypePartiesData" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<td ng-bind="LedgerCtrl.getAccountName(PartyData)"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'PayTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'PayTotal') | currency:''"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'RecptTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'RecptTotal') | currency:''"></td>
									<td ng-bind="(parseFloat(LedgerCtrl.sumByFloat(PartyData,'PayTotal')) > parseFloat(LedgerCtrl.sumByFloat(PartyData,'RecptTotal'))) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(PartyData,'PayTotal') - LedgerCtrl.sumByFloat(PartyData,'RecptTotal')) | abs | currency:''"></td>


									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList">
										<span ng-bind="LedgerCtrl.getProjectCount('Debit', id, PartyData)"></span>
									</td>
									<td class="num-align link" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit', id)" ng-bind="LedgerCtrl.getProjectAmount('Debit', id, PartyData) | currency:''"></span>
									</td>
									<td  ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectCount('Credit', id, PartyData)"></span>
									</td>
									<td class="num-align link" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit', id)" ng-bind="LedgerCtrl.getProjectAmount('Credit', id, PartyData) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(parseFloat(LedgerCtrl.getProjectAmount('Debit', id, PartyData)) > parseFloat(LedgerCtrl.getProjectAmount('Credit', id, PartyData))) ? 'Debit' : 'Credit'"></span>
									</td>
									<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(LedgerCtrl.getProjectAmount('Debit', id, PartyData) - LedgerCtrl.getProjectAmount('Credit', id, PartyData)) | abs | currency:''"></span>
									</td>



								</tr>


								<tr class="TotalRecord" ng-repeat-end >
									<td colspan="{{LedgerCtrl.recentsearch.searchID ? 2 : 3}}" style="text-align: right;">Total</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '7'"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(TypePartiesData,'PayTotalCnt', (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))"></td>
									<td class="num-align link" ng-bind="LedgerCtrl.sumByFloat(TypePartiesData,'PayTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" style="text-align: right;"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(TypePartiesData,'RecptTotalCnt',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))"></td>
									<td class="num-align link" ng-bind="LedgerCtrl.sumByFloat(TypePartiesData,'RecptTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" style="text-align: right;"></td>
									<td ng-bind="(LedgerCtrl.sumByFloat(TypePartiesData,'PayTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) > LedgerCtrl.sumByFloat(TypePartiesData,'RecptTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(TypePartiesData,'PayTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) - LedgerCtrl.sumByFloat(TypePartiesData,'RecptTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) | abs | currency:''"></td>
									
									<td ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Debit', id, TypePartiesData)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Debit', id, TypePartiesData) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Credit', id, TypePartiesData)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Credit', id, TypePartiesData) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(parseFloat(LedgerCtrl.getProjectTotalAmount('Debit', id, TypePartiesData)) > parseFloat(LedgerCtrl.getProjectTotalAmount('Credit', id, TypePartiesData))) ? 'Debit' : 'Credit'"></span>
									</td>
									<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(LedgerCtrl.getProjectTotalAmount('Debit', id, TypePartiesData) - LedgerCtrl.getProjectTotalAmount('Credit', id, TypePartiesData)) | abs | currency:''"></span>
									</td>
									
									
									
									
								</tr>
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '1' || LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'" class="AcntTypeTotal">
									<td colspan="{{LedgerCtrl.recentsearch.searchID ? 2 : 3}}" ng-bind="acnttype + 'Total'" style="text-align: right;"></td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '7'"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(acntTypeData,'PayTotalCnt',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))" ></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByFloat(acntTypeData,'PayTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" ></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(acntTypeData,'RecptTotalCnt',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))" ></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByFloat(acntTypeData,'RecptTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" ></td>
									<td ng-bind="(LedgerCtrl.sumByFloat(acntTypeData,'PayTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) > LedgerCtrl.sumByFloat(acntTypeData,'RecptTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) ? 'Debit' : 'Credit'" ></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(acntTypeData,'PayTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) - LedgerCtrl.sumByFloat(acntTypeData,'RecptTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) | abs | currency:''" ></td>
									
									<td ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Debit', id, acntTypeData, true)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Debit', id, acntTypeData, true) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Credit', id, acntTypeData, true)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Credit', id, acntTypeData, true) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(parseFloat(LedgerCtrl.getProjectTotalAmount('Debit', id, acntTypeData, true)) > parseFloat(LedgerCtrl.getProjectTotalAmount('Credit', id, acntTypeData, true))) ? 'Debit' : 'Credit'"></span>
									</td>
									<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(LedgerCtrl.getProjectTotalAmount('Debit', id, acntTypeData, true) - LedgerCtrl.getProjectTotalAmount('Credit', id, acntTypeData, true)) | abs | currency:''"></span>
									</td>
								</tr>
							</tbody>
							<tr class="Totaltr" ng-show="LedgerCtrl.PartiesData && keys(LedgerCtrl.PartiesData).length > 0">
								<td colspan="{{LedgerCtrl.recentsearch.searchID ? 2 : 3 }}" style="text-align: right;">Grand Total</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '7'"></td>
								<td class="num-align" ng-bind="LedgerCtrl.getTotal('TPC')"></td>
								<td class="num-align " ng-bind="LedgerCtrl.getTotal('TP') | currency:''" style="text-align: right;"></td> <?php //ng-click="LedgerCtrl.showTrnxs({},'','Debit')" ?>
								<td class="num-align" ng-bind="LedgerCtrl.getTotal('TRC')"></td>
								<td class="num-align " ng-bind="LedgerCtrl.getTotal('TR') | currency:''" style="text-align: right;"></td> <?php //ng-click="LedgerCtrl.showTrnxs({},'','Credit')" ?>
								<td ng-bind="LedgerCtrl.getTotal('TP') > LedgerCtrl.getTotal('TR') ? 'Debit' : 'Credit'"></td>
								<td class="num-align" ng-bind="(LedgerCtrl.getTotal('TP') - LedgerCtrl.getTotal('TR')) | abs | currency:''"></td>
								
								
								<td ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="LedgerCtrl.getProjectTotalCount('Debit', id, LedgerCtrl.PartiesData, true, true)"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="LedgerCtrl.getProjectTotalAmount('Debit', id, LedgerCtrl.PartiesData, true, true) | currency:''"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
									<span ng-bind="LedgerCtrl.getProjectTotalCount('Credit', id, LedgerCtrl.PartiesData, true, true)"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
									<span ng-bind="LedgerCtrl.getProjectTotalAmount('Credit', id, LedgerCtrl.PartiesData, true, true) | currency:''"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="(parseFloat(LedgerCtrl.getProjectTotalAmount('Debit', id, LedgerCtrl.PartiesData, true, true)) > parseFloat(LedgerCtrl.getProjectTotalAmount('Credit', id, LedgerCtrl.PartiesData, true, true))) ? 'Debit' : 'Credit'"></span>
								</td>
								<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="(LedgerCtrl.getProjectTotalAmount('Debit', id, LedgerCtrl.PartiesData, true, true) - LedgerCtrl.getProjectTotalAmount('Credit', id, LedgerCtrl.PartiesData, true, true)) | abs | currency:''"></span>
								</td>
								
								
							</tr>
							<tr class="success" align="center" ng-show="!LedgerCtrl.PartiesData || keys(LedgerCtrl.PartiesData).length == 0"><td colspan="14">There are no transactions for selected search criteria</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	
</div>


<script>
	
	angular.module('bank_accountsApp', ['ngRoute'])
	.controller('LedgerReport', ['$http','$location','$rootScope','DetailsDataProv', '$rootScope','DateFormater', "$scope", function($http,$location,$rootScope,DetailsDataProv, $rootScope,DateFormater, $scope) {
		$rootScope.keys = Object.keys;
		$scope.parseInt = parseInt;
		$scope.parseFloat = parseFloat;
		var self = this;
		$rootScope.$on('$routeChangeSuccess',function(){
			self.selectedDiv = $location.path();
		});
		$("#LefNaveLedgerReport").addClass("active");
		self.PartiesData = [];
		self.search = {"searchBy":"1"};
		self.recentsearch = {};
		self.clear = function(){
			self.search = {};
		};
		self.Parties = <?=json_encode($parties)?>;
		self.projects = <?=json_encode($projects)?>;
		self.ledgerAccounts = <?=json_encode($ledger_accounts)?>;
		self.ledgerSubAccounts = <?=json_encode($ledger_sub_accounts)?>;
		self.items = <?=json_encode($items)?>;
		self.getAccountName = function(vData){
//			console.log("test5",vData);
			if(vData){
				return vData[0].account_name;
			}
		};
		self.getProjectTotalCount = function(vType, id, vArray, vTypeTotal,vTotals){
			
			vArray = _.flatten(_.values(vArray));
			var vTempArray = [];
			$.each(vArray, function(i,v){
				vTempArray.push(_.flatten(_.values(v)));
			});
			if(vTypeTotal === true)
				vArray = _.flatten(vTempArray);
			if(vTotals){
				vArray = _.flatten(_.flatten(_.map(vArray,_.values)));
			}
			var vPayTotal = 0;
			$.each(vArray, function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal += parseInt(v.PayTotalCnt);
					}
					else if(vType == "Credit" )
					{
						vPayTotal += parseInt(v.RecptTotalCnt);
					}
				}
			});
			return vPayTotal;
		};
		self.getProjectTotalAmount = function(vType, id, vArray, vTypeTotal, vTotals){
			vArray = _.flatten(_.values(vArray));
			//console.log("in 4th")
			var vTempArray = [];
			$.each(vArray, function(i,v){
				vTempArray.push(_.flatten(_.values(v)));
			});
			if(vTypeTotal === true)
				vArray = _.flatten(vTempArray);
			if(vTotals){
				vArray = _.flatten(_.flatten(_.map(vArray,_.values)));
			}
			
			var vPayTotal = 0;
			$.each(vArray, function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal += parseFloat(v.PayTotal);
					}
					else if(vType == "Credit" )
					{
						vPayTotal += parseFloat(v.RecptTotal);
					}
				}
			});
			return vPayTotal;
		};
		self.getProjectCount = function(vType, id, PartyData){
			var vPayTotal = 0;
			$.each(_.flatten(_.values(PartyData)), function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal = v.PayTotalCnt;
					}
					else if(vType == "Credit" )
					{
						vPayTotal = v.RecptTotalCnt;
					}
				}
			});
			return vPayTotal;
		};
		self.getProjectAmount = function(vType, id, PartyData){
			var vPayTotal = 0;
			$.each(_.flatten(_.values(PartyData)), function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal = v.PayTotal;
					}
					else if(vType == "Credit" )
					{
						vPayTotal = v.RecptTotal;
					}
				}
			});
			return vPayTotal;
		};
		self.getColSpan = function(){
			return (Object.keys(self.ProjectsList).length*6) + (self.recentsearch.searchID ? 9 : 10); 
		};
		self.getRowSpan = function(vData){
			if(self.recentsearch.searchBy == 7){
				return Object.keys(vData).length + _.flatten(_.values(vData)).length + 1;
			}
			if( self.recentsearch.searchBy == 8){
				return Object.keys(vData).length + 1;
				
			}
			else {
				return vData.length + 1;
//				console.log("length>>",Object.keys(vData).length + _.flatten(_.values(vData)).length + 1);
				
			}
		};
		self.ProjectsList = {};
		self.searchData = function(){
			var vTempSearch = {"bankAccount":self.search.bankaccount, "searchBy":self.search.searchBy,"startDate":DateFormater.convertJsDate(self.search.startDate),"endDate":DateFormater.convertJsDate(self.search.endDate)};
			if(self.search.searchBy == "1" || self.search.searchBy == "7" || self.search.searchBy == "8")
				vTempSearch["searchID"]=self.search.ledgerAcntID;
			else if(self.search.searchBy == "2")
				vTempSearch["searchID"]=self.search.ledgerSubAcntID;
			else if(self.search.searchBy == "3" || self.search.searchBy == "6")
				vTempSearch["searchID"]=self.search.partyID;
			else if(self.search.searchBy == "4")
				vTempSearch["searchID"]=self.search.itemID;
			else if(self.search.searchBy == "5")
				vTempSearch["searchID"]=self.search.projectID;
			
			return $http.post('<?php echo base_url(); ?>index.php/report/getledgerdata',vTempSearch).then(
				function(response) {
					if(self.search.searchBy == "1" || self.search.searchBy == "7" || self.search.searchBy == "8"){
						if(self.search.searchBy == "8"){
							self.ProjectsList = {};
							$.each(response.data,function(i,v){
								if(v.project_id)
									self.ProjectsList[v.project_id] = v.project_name;
							});
//							console.log("self.ProjectsList>>",self.ProjectsList);
						}
						self.PartiesData = _.groupBy(response.data,"accounttype");
						_.forEach(self.PartiesData, function(v,k){
							self.PartiesData[k] = _.groupBy(v,"typename");
						});
						if(self.search.searchBy == "7" || self.search.searchBy == "8"){
							_.forEach(self.PartiesData, function(v,k){
								_.forEach(v, function(v1,k1){
									self.PartiesData[k][k1] = _.groupBy(v1,"account_number");
								});
							});
							//console.log(self.PartiesData);
						}
						var vSortOrder = ["Income","Expenditure","Assets","Liabilities"];
						var vParties = {};
						_.forEach(vSortOrder, function(v,i){
							if(self.PartiesData[v]){
								vParties[v] = self.PartiesData[v];
							}
						});
						self.PartiesData = vParties;
					}else{
						self.PartiesData = _.groupBy(response.data,"typename");
						var v = self.PartiesData;
						self.PartiesData = {};
						self.PartiesData[""] = v; 
					}
					self.recentsearch = {};
					jQuery.extend(true,self.recentsearch,vTempSearch);
				}, function(errResponse) {
					console.error(errResponse.data.msg);
				}
			);

		};
		self.getPartyName = function(vPartID){
			var vPartyName = "";
			$.each(self.Parties,function(i,v){
				if(v.party_id == vPartID){
					vPartyName = v.party_name;
					return false;
				}
			});
			return vPartyName;
		};
		self.sumByInt = function(vArray,vKey, vDeepObject, vLedgerProjTotal){
			if(vDeepObject === true){
				vArray = _.flatten(_.values(vArray));
			}
			if(vLedgerProjTotal === true){
				//console.log("in 4th")
				var vTempArray = [];
				$.each(vArray, function(i,v){
					vTempArray.push(_.flatten(_.values(v)));
				});
				vArray = _.flatten(vTempArray);
			}
			var vTotal = 0 ;
			if(vArray){
				vTotal = _.sumBy(vArray, function(o){
						return parseInt(o[vKey]);}
				);
			}
			return vTotal;
		};
		self.sumByFloat = function(vArray,vKey, vDeepObject, vLedgerProjTotal){
			if(vDeepObject === true){
				vArray = _.flatten(_.values(vArray));
			}

			if(vLedgerProjTotal){
				var vTempArray = [];
				$.each(vArray, function(i,v){
					vTempArray.push(_.flatten(_.values(v)));
				});
				vArray = _.flatten(vTempArray);
			}

			var vTotal = 0 ;
			if(vArray){
				vTotal = _.sumBy(vArray, function(o){
						return parseFloat(o[vKey]);}
				);
			}
			return vTotal;
		};
		self.getTotal = function(vType){
			var vTotalArray = _.flatten(_.flatten(_.values(_.map(self.PartiesData,function(v){return _.values(v);}))));
			if(self.recentsearch.searchBy == 7 || self.recentsearch.searchBy == 8){
				//console.log("before>",vTotalArray);
//				vTotalArray = _.flatten(_.map(vTotalArray, _.values));
				vTotalArray =_.flatten(_.flatten(_.map(vTotalArray, _.values)));
				//console.log("after>",vTotalArray);
			}
			switch(vType){
				case "TPC":

					var vTotal = 0 ;
					if(self.PartiesData){
						
						
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseInt(o.PayTotalCnt);}
						);
					}
					return vTotal;
				break;
				case "TP":
					var vTotal = 0.0 ;
					if(self.PartiesData){
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseFloat(o.PayTotal);}
						);
					}
					return vTotal.toFixed(2);
				break;
				case "TRC":
					var vTotal = 0.0 ;
					if(self.PartiesData){
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseInt(o.RecptTotalCnt);}
						);
					}
					return vTotal;
				break;
				case "TR":
					var vTotal = 0.0 ;
					if(self.PartiesData){
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseFloat(o.RecptTotal);}
						);
					}
					return vTotal.toFixed(2);
				break;
			}
		};
		self.showTrnxs = function(vParty,vType,vDebitCredit, vProjectID){
			DetailsDataProv.clear();
			if(self.recentsearch.searchBy == 7 && !vProjectID)
				vParty = vParty[0];
			if(self.recentsearch.searchBy == 8) 
				vParty = vParty[0];
			if(vProjectID)DetailsDataProv.setParam("project_id",vProjectID);
			if(vParty.bank_account_id)DetailsDataProv.setParam("bank_account_id",vParty.bank_account_id);
			if(vParty.bank_id)DetailsDataProv.setParam("bank",vParty.bank_id);
			if(vParty.account_name)DetailsDataProv.setParam("account_name",vParty.account_name);
			if(vParty.account_number)DetailsDataProv.setParam("account_number",vParty.account_number);
			if(vParty.ledger_reference_table)DetailsDataProv.setParam("ledger_reference_table",vParty.ledger_reference_table);
			if(vDebitCredit)DetailsDataProv.setParam("TrnxType",vDebitCredit);
			if(vType)DetailsDataProv.setParam("ClearanceStatus",vType);
			if(vParty.sSearchBy){
				DetailsDataProv.setParam("searchBy",vParty.sSearchBy);
				DetailsDataProv.setParam("searchID",vParty.sSearchID);
			}
			else if(self.recentsearch.searchBy){
				DetailsDataProv.setParam("searchBy",self.recentsearch.searchBy);
				DetailsDataProv.setParam("searchID",self.recentsearch.searchID);
			}
			if(vParty.sStartDate)
				DetailsDataProv.setParam("FromDate",vParty.sStartDate);
			else if(self.recentsearch.startDate)
				DetailsDataProv.setParam("FromDate",self.self.recentsearch.startDate);
			if(vParty.sEndDate)
				DetailsDataProv.setParam("ToDate",vParty.sEndDate);
			else if(self.recentsearch.endDate)
				DetailsDataProv.setParam("ToDate",self.recentsearch.endDate);
			$location.path("/LedgerDetails");
		};
		self.getSize = function(vIn){
			return  (Object.keys(vIn).length*2) + _.chain(vIn).values().flatten().value().length;
		}
		if("<?=$bank_account_id?>")	DetailsDataProv.setParam("bank_account_id","<?=$bank_account_id?>");
		if("<?=$bank?>")			DetailsDataProv.setParam("bank","<?=$bank?>");
		if("<?=$account_name?>")	DetailsDataProv.setParam("account_name","<?=$account_name?>");
		if("<?=$account_number?>")	DetailsDataProv.setParam("account_number","<?=$account_number?>");
		if("<?=$ledger_reference_table?>")	DetailsDataProv.setParam("ledger_reference_table","<?=$ledger_reference_table?>");
		if("<?=$TrnxType?>")		DetailsDataProv.setParam("TrnxType","<?=$TrnxType?>");
		if("<?=$ClearanceStatus?>")	DetailsDataProv.setParam("ClearanceStatus","<?=$ClearanceStatus?>");
		if("<?=$PartyID?>")			DetailsDataProv.setParam("PartyID","<?=$PartyID?>");
		if("<?=$PartyName?>")		DetailsDataProv.setParam("PartyName","<?=$PartyName?>");
		if("<?=$FromDate?>")		DetailsDataProv.setParam("FromDate","<?=$FromDate?>");
		if("<?=$ToDate?>")			DetailsDataProv.setParam("ToDate","<?=$ToDate?>");
		
		if("<?=$searchBy?>")			DetailsDataProv.setParam("searchBy","<?=$searchBy?>");
		if("<?=$searchID?>")			DetailsDataProv.setParam("searchID","<?=$searchID?>");
		
		if("<?=$project_id?>")			DetailsDataProv.setParam("project_id","<?=$project_id?>");
		
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
	.factory('DetailsDataProv',[function(){
		var vHiddenData = {};
		return {
			setParam : function(vParam,vValue){
				vHiddenData[vParam] = vValue;
			},
			getParam : function(vParam,vDefault){
				if(vHiddenData[vParam])
					return vHiddenData[vParam];
				else
					return vDefault;
			},
			clear : function(){
				vHiddenData = {};
			},
			getAllData : function(){
				return vHiddenData;
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
	.filter('mapYesNo',[function(){
		return function(vNum){
			if(vNum == "1") return "Yes";
			else if(vNum == "0") return "No";
			else return "";
		}
	}])
	
	.controller('LedgerDetailsCtrl',['DetailsDataProv','tranxData','DateFormater',function(DetailsDataProv,tranxData,DateFormater){
		// DetailsDataProv
		var self = this;
		self.bank_books = tranxData;
		self.searchByName = $("#SearchBy option[value='"+DetailsDataProv.getParam("searchBy")+"']").text();
		var vSearchBy = DetailsDataProv.getParam("searchBy");
		if(vSearchBy == "1" || vSearchBy == "7" || vSearchBy == "8")
			self.searchIDName=$("#LedgerAcntID option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "2")
			self.searchIDName=$("#LedgerSubAcntID option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "3" || vSearchBy == "6")
			self.searchIDName=$("#PartyName option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "4")
			self.searchIDName=$("#ItemID option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "5")
			self.searchIDName=$("#ProjectName option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		
		
		self.account_name = DetailsDataProv.getParam("account_name");
		self.account_number = DetailsDataProv.getParam("account_number");

		self.AttachFiles = function(vBook){
			//console.log(DetailsDataProv.getParam("FromDate",""));
			var vNewForm = "<form method='post' action='/funds_tracker/upload' id='form_"+vBook.transaction_id+"' style='display:none;'>";
			vNewForm += '<input type="hidden" name="bank_account_id" value="'+DetailsDataProv.getParam("bank_account_id","")+'" />';
			vNewForm += '<input type="hidden" name="bank" value="'+DetailsDataProv.getParam("bank","")+'" />';
			vNewForm += '<input type="hidden" name="searchBy" value="'+DetailsDataProv.getParam("searchBy","")+'" />';
			vNewForm += '<input type="hidden" name="searchID" value="'+DetailsDataProv.getParam("searchID","")+'" />';
			vNewForm += '<input type="hidden" name="account_name" value="'+DetailsDataProv.getParam("account_name","")+'" />';
			vNewForm += '<input type="hidden" name="account_number" value="'+DetailsDataProv.getParam("account_number","")+'" />';
			vNewForm += '<input type="hidden" name="ledger_reference_table" value="'+DetailsDataProv.getParam("ledger_reference_table","")+'" />';
			vNewForm += '<input type="hidden" name="ClearanceStatus" value="'+DetailsDataProv.getParam("ClearanceStatus","")+'" />';
			vNewForm += '<input type="hidden" name="TrnxType" value="'+DetailsDataProv.getParam("TrnxType","")+'" />';
			vNewForm += '<input type="hidden" name="StartDate" value="'+DetailsDataProv.getParam("FromDate","")+'" />';
			vNewForm += '<input type="hidden" name="Date" value="'+vBook.date+'" />';
			vNewForm += '<input type="hidden" name="PartyName" value="'+(vBook.party_name == null ? "" :vBook.party_name) +'" />';
			vNewForm += '<input type="hidden" name="Narration" value="'+vBook.narration+'" />';
			vNewForm += '<input type="hidden" name="IType" value="'+(vBook.instrument_type || "")+'" />';
			vNewForm += '<input type="hidden" name="IID" value="'+vBook.instrument_id_manual+'" />';
			vNewForm += '<input type="hidden" name="IDate" value="'+(vBook.instrument_date || "")+'" />';
			vNewForm += '<input type="hidden" name="BName" value="'+(vBook.bank_name || "")+'" />';
			vNewForm += '<input type="hidden" name="TType" value="'+vBook.debit_credit+'" />';
			vNewForm += '<input type="hidden" name="TAmt" value="'+vBook.transaction_amount+'" />';
			vNewForm += '<input type="hidden" name="BCS" value="'+(vBook.clearance_status == 1 ? "Yes" : "No")+'" />';
			vNewForm += '<input type="hidden" name="CD" value="'+(vBook.TrnxClearance_date||"")+'" />';
			vNewForm += '<input type="hidden" name="BR" value="'+(vBook.bill_recieved == 1 ? "Yes" : "No")+'" />';
			vNewForm += '<input type="hidden" name="Notes" value="'+vBook.notes+'" />';
			vNewForm += '<input type="hidden" name="Module" value="LedgerReport" />';
			vNewForm += '<input type="hidden" name="EndDate" value="'+DetailsDataProv.getParam("ToDate","")+'" />';
			vNewForm += '<input type="hidden" name="TranxID" value="'+vBook.transaction_id+'" />';
			vNewForm += '<input type="hidden" name="ledgerType" value="'+vBook.ledgerType+'" />';
			vNewForm += '<input type="hidden" name="PaymentVoucherNumber" value="'+vBook.bank_annual_voucher_id+'" />';
			vNewForm += "</form>";
			$("body").append(vNewForm);
			$("#form_"+vBook.transaction_id).submit();
		};
	}])
	.config(['$httpProvider','$routeProvider',function($httpProvider,$routeProvider){
		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
		$httpProvider.defaults.transformRequest.push(function(data){
			if(data){
				return $.param(JSON.parse(data));
			}else 
				return "";
		});
		$httpProvider.interceptors.push('HttpInterceptor');

		$routeProvider.when('/LedgerDetails', {
			templateUrl: '<?php echo base_url(); ?>index.php/report/ledgerdetailspage' ,
			resolve : {
				tranxData : ['DetailsDataProv','$http','$location',function(DetailsDataProv,$http,$location){
					if(DetailsDataProv.getAllData() && Object.keys(DetailsDataProv.getAllData()).length > 0){
						return $http.post('<?php echo base_url(); ?>index.php/report/getLedgerDetailsData',DetailsDataProv.getAllData()).then(
							function(response) {
								return response.data;                  
							}
						);
					}
					else {
						$location.path('');
						return false;
					}
				}]
			},
			controller : 'LedgerDetailsCtrl as PDetails'
		});
	}])
	.filter('abs', function () {
		return function(val) {
		  return Math.abs(val);
		}
	});
</script>