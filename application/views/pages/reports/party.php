<style>
	.mand{
		color:red;
	}
	label{
		/*width:145px;*/
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
</style>


<div ng-app ="bank_accountsApp" id="PartyApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div ng-controller ="PartyReport as PRCtrl">
        <div ng-view></div>
        <form class="form-inline" ng-show="PRCtrl.selectedDiv != '/PartyDetails'" ng-submit="PRCtrl.searchData()" name="PartyReportForm">
            <div class="form-group col-lg-4 col-md-6">
              <label for="PartyName"><span class="mand">*</span>Party</label>
              <select id="PartyName" class="form-control" ng-model="PRCtrl.search.partyID" 
                  ng-options="Party.party_id as Party.party_name for Party in PRCtrl.Parties" style="width:220px;" required="">
              </select>
            </div>
             <div class="form-group col-lg-4 col-md-6">
				<label for="startdate">Start Date</label>
				<input type="date" id="startdate" date-format="dd-MMM-yyyy" class="form-control" name="date" ng-model="PRCtrl.search.startDate">
			</div>
             <div class="form-group col-lg-4 col-md-6">
				<label for="enddate">End Date</label>
				<input type="date" id="enddate" date-format="dd-MMM-yyyy" class="form-control" name="date" ng-model="PRCtrl.search.endDate">
			</div>
	            <input style="margin-top: 15px; margin-left: 15px;" type="submit" class="btn btn-default" value="Search" ng-disabled="PartyReportForm.$invalid">
	            <input style="margin-top: 15px;" type="button" class="btn btn-default" value="Clear" ng-click="PRCtrl.clear()">
        </form>
		<div class="row " ng-show="PRCtrl.selectedDiv != '/PartyDetails'" style="margin-top: 5px;">
			<div class="panel panel-yellow ">
				<div class="panel-heading">Bank Accounts</div>
				<table class="table table-hover tableevenodd" >
					<thead>
						<tr>
							<th rowspan="3">S.No.</th>
							<th rowspan="3">Bank Account Name</th>
							<th colspan="6" style="text-align: center;">Payments</th>
							<th colspan="6" style="text-align: center;">Receipts</th>
						</tr>
						<tr>
							<th colspan="2" style="text-align: center;">Cleared</th>
							<th colspan="2" style="text-align: center;">Uncleared</th>
							<th colspan="2" style="text-align: center;">Total</th>
							<th colspan="2" style="text-align: center;">Cleared</th>
							<th colspan="2" style="text-align: center;">Uncleared</th>
							<th colspan="2" style="text-align: center;">Total</th>
						</tr>
						<tr>
							<th >#</th>
							<th class="num-align">Amount</th>
							<th >#</th>
							<th class="num-align">Amount</th>
							<th >#</th>
							<th class="num-align">Amount</th>
							<th >#</th>
							<th class="num-align">Amount</th>
							<th >#</th>
							<th class="num-align">Amount</th>
							<th >#</th>
							<th class="num-align">Amount</th>
						</tr>
					</thead>
					<tr ng-repeat="PartyData in PRCtrl.PartiesData">
						<td ng-bind="$index+1"></td>
						<td ng-bind="PartyData.account_name"></td>
						<td ng-bind="PartyData.PayClearedCnt"></td>
						<td class="num-align link" ng-click="PRCtrl.showTrnxs(PartyData,'1','Debit')" ng-bind="PartyData.PayCleared | currency:''"></td>
						<td ng-bind="PartyData.PayUnClearedCnt"></td>
						<td class="num-align link" ng-click="PRCtrl.showTrnxs(PartyData,'0','Debit')" ng-bind="PartyData.PayUnCleared | currency:''"></td>
						<td ng-bind="(+PartyData.PayClearedCnt+ +PartyData.PayUnClearedCnt)"></td>
						<td class="num-align link" ng-click="PRCtrl.showTrnxs(PartyData,'','Debit')" ng-bind="(+PartyData.PayCleared+ +PartyData.PayUnCleared).toFixed(2) | currency:''"></td>
						<td ng-bind="PartyData.RecptClearedCnt"></td>
						<td class="num-align link" ng-click="PRCtrl.showTrnxs(PartyData,'1','Credit')" ng-bind="PartyData.RecptCleared | currency:''"></td>
						<td ng-bind="PartyData.RecptUnclearedCnt"></td>
						<td class="num-align link" ng-click="PRCtrl.showTrnxs(PartyData,'0','Credit')" ng-bind="PartyData.RecptUncleared | currency:''"></td>
						<td ng-bind="(+PartyData.RecptClearedCnt+ +PartyData.RecptUnclearedCnt)"></td>
						<td class="num-align link" ng-click="PRCtrl.showTrnxs(PartyData,'','Credit')" ng-bind="(+PartyData.RecptCleared+ +PartyData.RecptUncleared).toFixed(2) | currency:''"></td>
					</tr>
					<tr class="Totaltr" ng-show="PRCtrl.PartiesData && PRCtrl.PartiesData.length > 0">
						<td colspan="2" style="text-align: right;">Total</td>
						<td ng-bind="PRCtrl.getTotal('CPC')"></td>
						<td class="num-align link" ng-bind="PRCtrl.getTotal('CP') | currency:''" ng-click="PRCtrl.showTrnxs({},'1','Debit')" style="text-align: right;"></td>
						<td ng-bind="PRCtrl.getTotal('UCPC')"></td>
						<td class="num-align link" ng-bind="PRCtrl.getTotal('UCP') | currency:''" ng-click="PRCtrl.showTrnxs({},'0','Debit')" style="text-align: right;"></td>
						<td ng-bind="PRCtrl.getTotal('TPC')"></td>
						<td class="num-align link" ng-bind="PRCtrl.getTotal('TP') | currency:''" ng-click="PRCtrl.showTrnxs({},'','Debit')" style="text-align: right;"></td>
						<td ng-bind="PRCtrl.getTotal('CRC')"></td>
						<td class="num-align link" ng-bind="PRCtrl.getTotal('CR') | currency:''" ng-click="PRCtrl.showTrnxs({},'1','Credit')" style="text-align: right;"></td>
						<td ng-bind="PRCtrl.getTotal('UCRC')"></td>
						<td class="num-align link" ng-bind="PRCtrl.getTotal('UCR') | currency:''" ng-click="PRCtrl.showTrnxs({},'0','Credit')" style="text-align: right;"></td>
						<td ng-bind="PRCtrl.getTotal('TRC')"></td>
						<td class="num-align link" ng-bind="PRCtrl.getTotal('TR') | currency:''" ng-click="PRCtrl.showTrnxs({},'','Credit')" style="text-align: right;"></td>
					</tr>
					<tr class="success" align="center" ng-show="!PRCtrl.PartiesData || PRCtrl.PartiesData.length == 0"><td colspan="14">There are no transactions for selected search criteria</td></tr>
				</table>
			</div>
		</div>
        <script>
			
			angular.module('bank_accountsApp', ['ngRoute'])
    		.controller('PartyReport', ['$http','$location','$rootScope','DetailsDataProv', 'DateFormater', function($http,$location,$rootScope,DetailsDataProv, DateFormater) {

				var self = this;
            	$rootScope.$on('$routeChangeSuccess',function(){
            		self.selectedDiv = $location.path();
            	});
				$("#LefNavePartyReport").addClass("active");
				self.PartiesData = [];
				self.search = {};
				self.resentsearch = {};
				self.clear = function(){
					self.search = {};
				};
				var fetch_partys = function() {
				  return $http.get('<?php echo base_url(); ?>index.php/party/get_party').then(
					  function(response) {  
						self.Parties = response.data;                  
					  }, function(errResponse) {
						console.error(errResponse.data.msg)                        ;
					  });
				};
              
				fetch_partys();

				self.searchData = function(){
					var vTempSearch = {};
					jQuery.extend(true,vTempSearch, self.search);
					vTempSearch["startDate"] = DateFormater.convertJsDate(vTempSearch["startDate"]);
					vTempSearch["endDate"] = DateFormater.convertJsDate(vTempSearch["endDate"]);
					return $http.post('<?php echo base_url(); ?>index.php/report/getpartydata',vTempSearch).then(
						function(response) {
							self.PartiesData = response.data;
							self.resentsearch = {};
							jQuery.extend(true,self.resentsearch,self.search);
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
				self.getTotal = function(vType){
					switch(vType){
						case "CPC":
							var vTotal = 0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseInt(vParty.PayClearedCnt);
								});
							}
							return vTotal;
						break;
						case "CP":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseFloat(vParty.PayCleared);
								});
							}
							return vTotal.toFixed(2);
						break;
						case "UCPC":
							var vTotal = 0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseInt(vParty.PayUnClearedCnt);
								});
							}
							return vTotal;
						break;
						case "UCP":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseFloat(vParty.PayUnCleared);
								});
							}
							return vTotal.toFixed(2);
						break;
						case "TPC":

							var vTotal = 0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseInt(vParty.PayUnClearedCnt) + parseInt(vParty.PayClearedCnt);
								});
							}
							return vTotal;
						break;
						case "TP":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseFloat(vParty.PayCleared) + parseFloat(vParty.PayUnCleared);
								});
							}
							return vTotal.toFixed(2);
						break;
						case "CRC":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseInt(vParty.RecptClearedCnt);
								});
							}
							return vTotal;
						break;
						case "CR":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseFloat(vParty.RecptCleared);
								});
							}
							return vTotal.toFixed(2);
						break;
						case "UCRC":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseInt(vParty.RecptUnclearedCnt);
								});
							}
							return vTotal;
						break;
						case "UCR":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseFloat(vParty.RecptUncleared);
								});
							}
							return vTotal.toFixed(2);
						break;
						case "TRC":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseInt(vParty.RecptClearedCnt) + parseInt(vParty.RecptUnclearedCnt);
								});
							}
							return vTotal;
						break;
						case "TR":
							var vTotal = 0.0 ;
							if(self.PartiesData){
								$.each(self.PartiesData,function(i,vParty){
									vTotal += parseFloat(vParty.RecptCleared) + parseFloat(vParty.RecptUncleared);
								});
							}
							return vTotal.toFixed(2);
						break;
					}
				};
				self.showTrnxs = function(vParty,vType,vDebitCredit){
					DetailsDataProv.clear();
					if(vParty.bank_account_id)DetailsDataProv.setParam("bank_account_id",vParty.bank_account_id);
					if(vParty.bank_id)DetailsDataProv.setParam("bank",vParty.bank_id);
					if(vParty.account_name)DetailsDataProv.setParam("account_name",vParty.account_name);
					if(vParty.account_number)DetailsDataProv.setParam("account_number",vParty.account_number);
					if(vDebitCredit)DetailsDataProv.setParam("TrnxType",vDebitCredit);
					if(vType)DetailsDataProv.setParam("ClearanceStatus",vType);
					if(vParty.sPartyID){
						DetailsDataProv.setParam("PartyID",vParty.sPartyID);
						DetailsDataProv.setParam("PartyName",self.getPartyName(vParty.sPartyID));
					}
					else if(self.resentsearch.partyID){
						DetailsDataProv.setParam("PartyID",self.resentsearch.partyID);
						DetailsDataProv.setParam("PartyName",self.getPartyName(self.resentsearch.partyID));
					}
					if(vParty.sStartDate)
						DetailsDataProv.setParam("FromDate",vParty.sStartDate);
					else if(self.resentsearch.startDate)
						DetailsDataProv.setParam("FromDate",self.resentsearch.startDate);
					if(vParty.sEndDate)
						DetailsDataProv.setParam("ToDate",vParty.sEndDate);
					else if(self.resentsearch.endDate)
						DetailsDataProv.setParam("ToDate",self.resentsearch.endDate);
					$location.path("/PartyDetails");
				};
				if("<?=$bank_account_id?>")	DetailsDataProv.setParam("bank_account_id","<?=$bank_account_id?>");
				if("<?=$bank?>")			DetailsDataProv.setParam("bank","<?=$bank?>");
				if("<?=$account_name?>")	DetailsDataProv.setParam("account_name","<?=$account_name?>");
				if("<?=$account_number?>")	DetailsDataProv.setParam("account_number","<?=$account_number?>");
				if("<?=$TrnxType?>")		DetailsDataProv.setParam("TrnxType","<?=$TrnxType?>");
				if("<?=$ClearanceStatus?>")	DetailsDataProv.setParam("ClearanceStatus","<?=$ClearanceStatus?>");
				if("<?=$PartyID?>")			DetailsDataProv.setParam("PartyID","<?=$PartyID?>");
				if("<?=$PartyName?>")		DetailsDataProv.setParam("PartyName","<?=$PartyName?>");
				if("<?=$FromDate?>")		DetailsDataProv.setParam("FromDate","<?=$FromDate?>");
				if("<?=$ToDate?>")			DetailsDataProv.setParam("ToDate","<?=$ToDate?>");
				
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
			
			.controller('PartyDetailsCtrl',['DetailsDataProv','tranxData','DateFormater',function(DetailsDataProv,tranxData,DateFormater){
				// DetailsDataProv
				var self = this;
				self.bank_books = tranxData;
				self.party_name = DetailsDataProv.getParam("PartyName");
				self.account_name = DetailsDataProv.getParam("account_name");
				self.account_number = DetailsDataProv.getParam("account_number");

				self.AttachFiles = function(vBook){
					var vNewForm = "<form method='post' action='/funds_tracker/upload' id='form_"+vBook.transaction_id+"' style='display:none;'>";
					vNewForm += '<input type="hidden" name="bank_account_id" value="'+DetailsDataProv.getParam("bank_account_id","")+'" />';
					vNewForm += '<input type="hidden" name="bank" value="'+DetailsDataProv.getParam("bank","")+'" />';
					vNewForm += '<input type="hidden" name="account_name" value="'+DetailsDataProv.getParam("account_name","")+'" />';
					vNewForm += '<input type="hidden" name="account_number" value="'+DetailsDataProv.getParam("account_number","")+'" />';
					vNewForm += '<input type="hidden" name="ClearanceStatus" value="'+DetailsDataProv.getParam("ClearanceStatus","")+'" />';
					vNewForm += '<input type="hidden" name="PartyID" value="'+DetailsDataProv.getParam("PartyID","")+'" />';
					vNewForm += '<input type="hidden" name="PartyName" value="'+DetailsDataProv.getParam("PartyName","")+'" />';
					vNewForm += '<input type="hidden" name="TrnxType" value="'+DetailsDataProv.getParam("TrnxType","")+'" />';
					console.log(DetailsDataProv.getParam("FromDate",""));
					vNewForm += '<input type="hidden" name="StartDate" value="'+DateFormater.convertJsDate(DetailsDataProv.getParam("FromDate",""))+'" />';
					vNewForm += '<input type="hidden" name="Date" value="'+vBook.date+'" />';
					vNewForm += '<input type="hidden" name="PartyName" value="'+(vBook.party_name == null ? "" :vBook.party_name) +'" />';
					vNewForm += '<input type="hidden" name="Narration" value="'+vBook.narration+'" />';
					vNewForm += '<input type="hidden" name="IType" value="'+vBook.instrument_type+'" />';
					vNewForm += '<input type="hidden" name="IID" value="'+vBook.instrument_id_manual+'" />';
					vNewForm += '<input type="hidden" name="IDate" value="'+vBook.instrument_date+'" />';
					vNewForm += '<input type="hidden" name="BName" value="'+(vBook.bank_name ? vBook.bank_name : "")+'" />';
					vNewForm += '<input type="hidden" name="TType" value="'+vBook.debit_credit+'" />';
					vNewForm += '<input type="hidden" name="TAmt" value="'+vBook.transaction_amount+'" />';
					vNewForm += '<input type="hidden" name="BCS" value="'+(vBook.clearance_status == 1 ? "Yes" : "No")+'" />';
					vNewForm += '<input type="hidden" name="CD" value="'+vBook.TrnxClearance_date+'" />';
					vNewForm += '<input type="hidden" name="BR" value="'+(vBook.bill_recieved == 1 ? "Yes" : "No")+'" />';
					vNewForm += '<input type="hidden" name="Notes" value="'+vBook.notes+'" />';
					vNewForm += '<input type="hidden" name="Module" value="PartyReport" />';
					vNewForm += '<input type="hidden" name="ledgerType" value="1" />';
					vNewForm += '<input type="hidden" name="EndDate" value="'+DateFormater.convertJsDate(DetailsDataProv.getParam("ToDate",""))+'" />';
					vNewForm += '<input type="hidden" name="TranxID" value="'+vBook.transaction_id+'" />';
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

				$routeProvider.when('/PartyDetails', {
					templateUrl: '<?php echo base_url(); ?>index.php/report/partydetailspage' ,
					resolve : {
						tranxData : ['DetailsDataProv','$http','$location',function(DetailsDataProv,$http,$location){
							if(DetailsDataProv.getAllData() && Object.keys(DetailsDataProv.getAllData()).length > 0){
								return $http.post('<?php echo base_url(); ?>index.php/report/getpartydetailsdata',DetailsDataProv.getAllData()).then(
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
					controller : 'PartyDetailsCtrl as PDetails'
				});
			}]);
        </script>
    </div>
    </div>
