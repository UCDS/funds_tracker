<style>
	.mand{
		color:red;
	}
	label{
		width:145px;
	}
	.searchfrom label{
		width:105px;
	}
</style>
<div ng-app ="bank_accountsApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div ng-controller ="Bank_accountCtrl as bank_accountCtrl">
		<?php
			if($this->session->logged_in == 'YES'){
		?>
			<div ng-show="!bank_accountCtrl.addflag && !bank_accountCtrl.updateflag" class="row">
				<input type="button" class="btn btn-primary" ng-click="bank_accountCtrl.addflag=1" value="Add Account" />
			</div>

			<form class="form-inline" ng-show="bank_accountCtrl.addflag || bank_accountCtrl.updateflag" ng-submit="bank_accountCtrl.add()" name="addBank_account">      
				<div class="form-group col-lg-6 col-md-6">
					<label for="exampleInputName2"><span class="mand">*</span>Bank Account Name</label>
				  <input type="text" class="form-control" ng-model="bank_accountCtrl.newBank_account.account_name" required/>
				</div>
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputEmail2">Bank</label>
				  <select id="BankName" class="form-control" ng-model="bank_accountCtrl.newBank_account.bank_id" 
					  ng-options="bank.bank_id as bank.bank_name for bank in bank_accountCtrl.banks" style="width:196px;">                          
				  </select>
				</div>            
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputName2">Account Number</label>
				  <input type="text" class="form-control" ng-model="bank_accountCtrl.newBank_account.account_number"/>              
				</div>
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputName2">Bank Branch</label>
				  <input type="text" class="form-control" ng-model="bank_accountCtrl.newBank_account.branch"/>              
				</div>
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputName2">Branch Location</label>
				  <input type="text" class="form-control" ng-model="bank_accountCtrl.newBank_account.location"/>              
				</div>
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputName2">Branch IFSC Code</label>
				  <input type="text" class="form-control" ng-model="bank_accountCtrl.newBank_account.ifsc_code"/>              
				</div>
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputName2">MICR Code</label>
				  <input type="text" class="form-control" ng-model="bank_accountCtrl.newBank_account.micr_code"/>              
				</div>
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputName2">SWIFT Code</label>
				  <input type="text" class="form-control" ng-model="bank_accountCtrl.newBank_account.swift_code"/>
				</div>
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputEmail2"><span class="mand">*</span>Party</label>
				  <select id="PartyName" class="form-control" ng-model="bank_accountCtrl.newBank_account.party_id" 
						  ng-options="party.party_id as party.party_name for party in bank_accountCtrl.partys" required="" style="width:196px;">                          
				  </select>
				</div> 
				<div class="form-group col-lg-6 col-md-6">
				  <label for="exampleInputEmail2">Bank Book</label>
				  <input type="checkbox" class="form-control" ng-checked="bank_accountCtrl.newBank_account.bank_book=='1'" ng-model="bank_accountCtrl.newBank_account.bank_book" ng-true-value="1" ng-false-value="0"/>
				</div> 
			<!--    <div class="form-group">
				  <label for="exampleInputEmail2">Select Bank_account Group</label>
				  <select class="form-control" ng-model="bank_accountCtrl.newBank_account.bank_account_group_id" 
					  ng-options="group.bank_account_group_id as group.bank_account_group_name for group in bank_accountCtrl.bank_account_groups">                          
				  </select>
				</div> -->
				<input type="submit" class="btn btn-default" value="{{bank_accountCtrl.getSubmitButtonText()}}" ng-disabled="addBank_account.$invalid">
				<input type="button" class="btn btn-default" value="Cancel" ng-click="bank_accountCtrl.cancelUpdate()" ng-show="bank_accountCtrl.updateflag || bank_accountCtrl.addflag">
			</form>
		<?php
			}
		?>
		<div  class="row">
			<h3>Search</h3>
			<div class="searchfrom col-lg-12">
				<form class="form-inline" name="search_bankaccounts" ng-submit="bank_accountCtrl.searchBankAccounts()">
						<div class="from-group col-lg-4 col-md-6">
							<label>Account Name</label>
							<input type="text" class="form-control" ng-model="bank_accountCtrl.searchBank_account.account_name" ng-required="!bank_accountCtrl.searchBank_account.account_number"/>
						</div>	
						<div class="from-group col-lg-4 col-md-6">
							<label>Account No.</label>
							<input type="text" class="form-control " ng-model="bank_accountCtrl.searchBank_account.account_number" ng-required="!bank_accountCtrl.searchBank_account.account_name"/>
						</div>	
					<input type="submit" class="btn btn-default" value="Search" ng-show="bank_accountCtrl.updateflag == 0" ng-disabled="search_bankaccounts.$invalid"/>
				</form>
			</div>
		</div>
		<div class="row" style="margin-top: 5px;">
			<div class="panel panel-yellow ">
				<div class="panel-heading"><i class="fa fa-bell fa-fw"></i>Bank Accounts</div>
				<table class="table table-hover tableevenodd">
					<thead>
						<tr>                    
							<th>S.No.</th>
							<th>Bank Account Name</th>
							<th style="display:none;">Bank Account ID</th>
							<th>Bank ID</th>
							<th>Account Number</th>
							<th>Bank Branch</th>
							<th>Branch Location</th>
							<th>Branch IFSC Code</th>
							<th>MICR Code</th>
							<th>SWIFT Code</th>
							<th>Party</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($this->session->logged_in == 'YES'){
						?>
							<tr class="active">
								<td ></td>
								<td ng-bind="bank_accountCtrl.newBank_account.account_name"></td>
								<td style="display:none;" ng-bind="bank_accountCtrl.newBank_account.account_id"></td>
								<td ng-bind="bank_accountCtrl.getBankName()"></td>
								<td ng-bind="bank_accountCtrl.newBank_account.account_number"></td>
								<td ng-bind="bank_accountCtrl.newBank_account.branch"></td>
								<td ng-bind="bank_accountCtrl.newBank_account.location"></td>
								<td ng-bind="bank_accountCtrl.newBank_account.ifsc_code"></td>
								<td ng-bind="bank_accountCtrl.newBank_account.micr_code"></td>
								<td ng-bind="bank_accountCtrl.newBank_account.swift_code"></td>
								<td ng-bind="bank_accountCtrl.getPartyName()"></td>     
							</tr>
							<tr ng-repeat="bank_account in bank_accountCtrl.bank_accounts" ng-click="bank_accountCtrl.editRecord(bank_account,$index)">
						<?php
							}else{
						?>
							<tr ng-repeat="bank_account in bank_accountCtrl.bank_accounts">
						<?php
							}
						?>
							<td ng-bind="$index+1"></td>
							<td ng-bind="bank_account.account_name"></td>
							<td style="display:none;" ng-bind="bank_account.account_id"></td>
							<td ng-bind="bank_account.bank_name"></td>
							<td ng-bind="bank_account.account_number"></td>
							<td ng-bind="bank_account.branch"></td>
							<td ng-bind="bank_account.location"></td>
							<td ng-bind="bank_account.ifsc_code"></td>
							<td ng-bind="bank_account.micr_code"></td>
							<td ng-bind="bank_account.swift_code"></td>
							<td ng-bind="bank_account.party_name"></td>          
						</tr>
					</tbody>
				</table>
			</div>
		</div>
        <script>
			
			angular.module('bank_accountsApp', [])
            .controller('Bank_accountCtrl', ['$http', function($http) {
				$("#LefNaveBankAct").addClass("active");
				var self = this;
				self.bank_accounts = [];
				self.banks = [];
				self.partys = [];
				self.bank_account_groups = [];
				self.updateflag = 0;
				self.addflag = 0;
				self.bank_account_index ;
				self.bank_account_editing ;
				self.newBank_account = {};
				self.searchBank_account = {};
				self.getSubmitButtonText = function(){
				  return self.updateflag == 0 ? "Add" : "Update"  ;
				};
				self.cancelUpdate = function(){
				  self.newBank_account = {};
				  if(self.updateflag == 1){
					  self.bank_accounts.splice(self.bank_account_index,0,self.bank_account_editing);
				  }
				  self.updateflag = 0;
				  self.addflag = 0;
				  self.bank_account_index = 0;
				  self.bank_account_editing = {};
				};
				self.editRecord = function(record,vIndex){
					self.addflag = 0;
					var temp_bank_account_editing = self.bank_accounts.splice(vIndex,1);
					if(self.updateflag == 1){
					  self.bank_accounts.splice(self.bank_account_index,0,self.bank_account_editing);
					}
					self.bank_account_index = vIndex;
					self.bank_account_editing = temp_bank_account_editing[0];

					self.newBank_account.account_name = record.account_name;
					self.newBank_account.bank_account_id = record.bank_account_id;
					self.newBank_account.account_number = record.account_number;
					self.newBank_account.bank_id = record.bank_id;
					self.newBank_account.branch = record.branch;
					self.newBank_account.location = record.location;
					self.newBank_account.ifsc_code = record.ifsc_code;
					self.newBank_account.micr_code = record.micr_code;
					self.newBank_account.swift_code = record.swift_code;
					self.newBank_account.party_id = record.party_id;
					self.newBank_account.bank_book = record.bank_book;

					self.updateflag = 1;
				};
				self.getPartyName = function(){
					return $("#PartyName option:selected").text();
				};
				self.getBankName = function(){
					return $("#BankName option:selected").text();
				};
				var fetchbank_accounts = function() {
				  return $http.get('index.php/bank_account/get_bank_accounts').then(
					  function(response) {
						  self.bank_accounts = response.data;
						  self.searchBank_account = {};
					  },
					  function(errResponse) {
						  console.error(errResponse.data.msg);
					  }
				  );
				};
				var fetch_banks = function() {
					return $http.get('index.php/bank/get_all_banks').then(
						function(response) {
							self.banks = response.data;                  
						}, function(errResponse) {
							console.error(errResponse.data.msg);
						}
					);
				};
				var fetch_partys = function() {
				  return $http.get('index.php/party/get_party').then(
					  function(response) {
//						  console.log(response.data);
					self.partys = response.data;                  
				  }, function(errResponse) {
					console.error(errResponse.data.msg);
				  });
				};
              
				fetch_banks();
				fetch_partys();
				fetchbank_accounts();

				self.add = function() {
				  $http.post('index.php/bank_account/add_bank_account', self.newBank_account)
					  .then(fetchbank_accounts)
					  .then(function(response) {
						  self.addflag = 0;
						  self.updateflag = 0;
						  self.bank_account_index = 0;
						  self.bank_account_editing = {};
						  self.newBank_account = {};
					  });
				};
				self.searchBankAccounts = function(){
					$http.post('index.php/bank_account/search_bank_accounts', self.searchBank_account).then(
						function(response) {
//							console.log(response.data);
							self.bank_accounts = response.data;
						},
						function(errResponse) {
							console.error(errResponse.data.msg);
						}
					);
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
			}]);;
        </script>
    </div>
    </div>
