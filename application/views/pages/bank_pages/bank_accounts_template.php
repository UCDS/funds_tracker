<style>
	.Totaltr td{
		background-color: #edf0f3;
	}
</style>
<div ng-app ="bank_accountsTempApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div ng-controller ="Bank_accountTempCtrl as bank_accountCtrl" style="overflow: auto;">        
		<div class="panel panel-yellow " id="MainDiv">
			<div class="panel-heading"><i class="fa fa-university" aria-hidden="true"></i>&nbsp;Bank Accounts</div>    
			<table class="table table-hover tableevenodd">
				<thead>
					<tr>
						<th rowspan="2" style="text-align: center;">S.No.</th>
						<th rowspan="2">Bank Account Name</th>
						<th rowspan="2">Bank</th>
						<th rowspan="2">Account Number</th>
						<th rowspan="2" style="text-align: right;">Book Balance</th>
						<th rowspan="2" style="text-align: right;">Bank Balance</th>
						<th colspan="2" style="text-align: center;">Uncleared Debits</th>
						<th colspan="2" style="text-align: center;">Uncleared Credits</th>
						<th rowspan="2">Last Updated</th>
						<th rowspan="2"></th>
					</tr>
					<tr>
						<th style="text-align: center;">Count</th>
						<th style="text-align: center;">Amount</th>
						<th style="text-align: center;">Count</th>
						<th style="text-align: center;">Amount</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="bank_account in bank_accountCtrl.bank_accounts">
						<td ng-bind="$index+1" style="text-align: center;"></td>
						<td ng-bind="bank_account.account_name"></td>
						<td ng-bind="bank_account.bank_name"></td>
						<td ng-bind="bank_account.account_number"></td>
						<td nowrap ng-bind="bank_account.balance | currency : '&#x20b9 '" style="text-align: right;"></td>
						<td nowrap ng-bind="bank_account.statement_balance | currency : '&#x20b9 '" style="text-align: right;"></td>
						<td ng-bind="bank_account.count_debits" ng-click="bank_accountCtrl.getUnclearedAmounts('Debit',bank_account)" style="text-align: center; color: #0000FF; cursor: pointer; text-decoration: underline;"></td>
						<td nowrap ng-bind="bank_account.total_debits | currency : '&#x20b9 '" style="text-align: right;"></td>
						<td ng-bind="bank_account.count_credits" ng-click="bank_accountCtrl.getUnclearedAmounts('Credit',bank_account)" style="text-align: center; color: #0000FF; cursor: pointer; text-decoration: underline;"></td>
						<td nowrap ng-bind="bank_account.total_credits  | currency : '&#x20b9 '" style="text-align: right;"></td>
						<td ng-bind="bank_account.lastupatedatetime"></td>
						<td><?php echo form_open("bank_book",array('role'=>'form','class'=>'form-custom','autocomplete'=>'off')); ?>
							<input type="hidden" name="bank_account_id" value="{{ bank_account.bank_account_id }}" />                    
							<input type="hidden" name="bank" value="{{ bank_account.bank_id }}" />                    
							<input type="hidden" name="account_name" value="{{ bank_account.account_name }}" />
							<input type="hidden" name="account_number" value="{{ bank_account.account_number }}" />
							<?php
								if($this->session->logged_in == 'YES'){
							?>
							<button type="submit" class="btn btn-primary" title="Update"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
							<?php
								}else{
							?>
							<button type="submit" class="btn btn-primary" title="View"><i class="fa fa-search" aria-hidden="true"></i></button>
							<?php
								}
							?>
							<?php echo form_close(); ?>
						</td>
					</tr>
					<tr class="Totaltr" ng-show="bank_accountCtrl.bank_accounts && bank_accountCtrl.bank_accounts.length > 0">
						<td colspan="4" style="text-align: right;">Total</td>
						<td style="text-align: right;" ng-bind="bank_accountCtrl.getTotal('BookBal') | currency:'&#x20b9'"></td>
						<td style="text-align: right;" ng-bind="bank_accountCtrl.getTotal('BankBal') | currency:'&#x20b9'"></td>
						<td style="text-align: center;" ng-bind="bank_accountCtrl.getTotal('UCDC')"></td>
						<td style="text-align: right;" ng-bind="bank_accountCtrl.getTotal('UCD') | currency:'&#x20b9'"></td>
						<td style="text-align: center;" ng-bind="bank_accountCtrl.getTotal('CCC')"></td>
						<td style="text-align: right;" ng-bind="bank_accountCtrl.getTotal('CC') | currency:'&#x20b9'"></td>
						<td ></td>
						<td ></td>
					</tr>
					<tr class="success" align="center" ng-show="!bank_accountCtrl.bank_accounts || bank_accountCtrl.bank_accounts.length == 0"><td colspan="14">There are no transactions for selected search criteria</td></tr>
				</tbody>
			</table>
		</div>
		<div class="panel panel-green " id="MainDiv">
			<div class="panel-heading">Accrued Accounts</div>
			<table class="table table-hover tableevenodd">
				<thead>
					<tr>
						<th rowspan="2" style="text-align: center;">S.No.</th>
						<th colspan="2" style="text-align: center;">Accrued Payments</th>
						<th colspan="2" style="text-align: center;">Accrued Receipts</th>
						<th rowspan="2">Last Updated</th>
						<th rowspan="2"></th>
					</tr>
					<tr>
						<th style="text-align: center;">Count</th>
						<th style="text-align: center;">Amount</th>
						<th style="text-align: center;">Count</th>
						<th style="text-align: center;">Amount</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
    </div>
</div>
<script>
  angular.module('bank_accountsTempApp', [])
	.controller('Bank_accountTempCtrl', ['$http',"BankAccounts", function($http,BankAccounts) {
		$("#LefNaveBankBook").addClass("active");
		var self = this;
		self.bank_accounts = [];
		self.banks = [];
		self.partys = [];
		self.bank_account_groups = [];
		self.newBank_account = {};
		var fetchbank_accounts = function() {
		BankAccounts.fetchAccounts().then(
			function(response) {
				self.bank_accounts = response.data;                  
			}, function(errResponse) {
				console.error(errResponse.data.msg);
			});
		};
		
		self.getTotal = function(vType){
			var vTotal = 0;
			$.each(self.bank_accounts,function(i,v){
				if(vType == "BookBal")
					vTotal += parseFloat(v.balance);
				else if(vType == "BankBal")
					vTotal += parseFloat(v.statement_balance);
				else if(vType == "UCDC")
					vTotal += parseInt(v.count_debits);
				else if(vType == "UCD")
					vTotal += parseFloat(v.total_debits);
				else if(vType == "CCC")
					vTotal += parseInt(v.count_credits);
				else if(vType == "CC")
					vTotal += parseFloat(v.total_credits);
			});
			return vTotal;
		};
	  self.getUnclearedAmounts = function(vTrnxType, vBankAccount){
		var vNewForm = "<form method='post' action='/funds_tracker/bank_book' id='form_"+vBankAccount.bank_account_id+"' style='display:none;'>";
		vNewForm += '<input type="hidden" name="bank_account_id" value="'+vBankAccount.bank_account_id+'" />';
		vNewForm += '<input type="hidden" name="bank" value="'+vBankAccount.bank_id+'" />';
		vNewForm += '<input type="hidden" name="account_name" value="'+vBankAccount.account_name+'" />';
		vNewForm += '<input type="hidden" name="account_number" value="'+vBankAccount.account_number+'" />';
		vNewForm += '<input type="hidden" name="TrnxType" value="'+vTrnxType+'" />';
		vNewForm += "</form>";
		$("#MainDiv").append(vNewForm);
		$("#form_"+vBankAccount.bank_account_id).submit();
		$("#form_"+vBankAccount.bank_account_id).remove();
	  };
	  /*var fetch_banks = function() {
		return $http.get('bank/get_banks').then(
			function(response) {
		  self.banks = response.data;                  
		}, function(errResponse) {
		  console.error(errResponse.data.msg);
		});
	  };
	  var fetch_partys = function() {
		return $http.get('party/get_party').then(
			function(response) {
		  self.partys = response.data;                  
		}, function(errResponse) {
		  console.error(errResponse.data.msg);
		});
	  };

	  fetch_banks();
	  fetch_partys();
	  */fetchbank_accounts();

	  self.add = function() {
		$http.post('<?php echo base_url(); ?>bank_account/add_bank_account', self.newBank_account)
			.then(fetchbank_accounts)
			.then(function(response) {
			  self.newBank_account = {};
			});
	  };

	}])
	.factory("BankAccounts",["$http",function($http){
			return {
				fetchAccounts : function(){
					return $http.get('<?php echo base_url(); ?>bank_account/get_bank_book_accounts');
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
		$httpProvider.interceptors.push('HttpInterceptor');
	}]);
</script>