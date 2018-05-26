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
					<input type="submit" class="btn btn-default" value="Search"  ng-disabled="search_bankbook.$invalid"/>
				</form>
			</div>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="panel panel-yellow ">
				<div class="panel-heading">Payment Transactions</div>
				<div style="overflow-x: scroll">
					<table class="table tableevenodd table-hover" style="font-size: 11px;">
						<thead>
							<tr>
								<th>
									S.No.
								</th>
								<th ng-click="bank_bookCtrl.sortBy('bank_annual_voucher_id')">
									Voucher ID
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'bank_annual_voucher_id'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Transaction Date" ng-click="bank_bookCtrl.sortBy('date')">
									Trnx. Date
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'date'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Account Number" ng-click="bank_bookCtrl.sortBy('account_number')">
									Acc. No.
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'account_number'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
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
								<th ng-click="bank_bookCtrl.sortBy('bank_name')" style="display:none;">
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
								<th title="Received" ng-click="bank_bookCtrl.sortBy('bill_recieved')" style="display:none;">
									Bill Rcvd.
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'bill_recieved'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th ng-click="bank_bookCtrl.sortBy('notes')" style="display:none;">
									Notes
									<span class="sortorder" ng-show="bank_bookCtrl.propertyName === 'notes'" ng-class="{reverse: bank_bookCtrl.reverse}"></span>
								</th>
								<th title="Opperations">
									Opp.
								</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="bank_book in bank_bookCtrl.bank_books" > 
								<td ng-bind="$index+1"></td>
								<td ng-bind="bank_book.bank_annual_voucher_id"></td>
								<td ng-bind="bank_book.date | date:'dd-MMM-yyyy HH:mm'"></td>
								<td ng-bind="bank_book.account_number"></td>
								<td ng-bind="bank_book.party_name"></td>
								<td ng-bind="bank_book.narration"></td>
								<td ng-bind="bank_book.instrument_type"></td>
								<td ng-bind="bank_book.instrument_id_manual"></td>
								<td ng-bind="bank_book.instrument_date | date:'dd-MMM-yyyy'"></td>
								<td ng-bind="bank_book.bank_name" style="display:none;"></td>
								<td ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.debit_credit"></td>
								<td class="num-align" nowrap ng-class="bank_book.debit_credit == 'Credit' ? 'green-text' : 'red-text'" ng-bind="bank_book.transaction_amount_ui | currency : '&#x20b9 ' "></td>
								<td ng-bind="bank_book.clearance_status | mapYesNo"></td>
								<td ng-bind="bank_book.bill_recieved | mapYesNo" style="display:none;"></td>
								<td ng-bind="bank_book.notes" style="display:none;"></td>
								
								<td>
									<span class="file-count-icon" class="Attachments" ng-click="bank_bookCtrl.AttachFiles(bank_book)">
										<i aria-hidden="true" class="fa fa-file-o" ></i>
										<span class="file-count" ng-bind="bank_book.attachments_count"></span>
									</span>
									<input type="button" value="Payment Voucher" ng-click="bank_bookCtrl.PrintVoucher(bank_book)"/>
									<input type="button" value="Journal Voucher" ng-click="bank_bookCtrl.JournalVoucher(bank_book)"/>
								</td>
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
			$("#LefNavePaymentsReport").addClass("active");
			
			self.bank_book_index ;
			self.newBank_book = {};
			self.staticData = {};
			
			self.searchBank_book = {};
			var vTempFromDate = new Date();
			vTempFromDate.setDate(vTempFromDate.getDate() - 30);
			self.searchBank_book.fromdate = vTempFromDate;
			self.searchBank_book.todate = new Date();

			self.PrintVoucher = function(bankbook){
				window.open("<?php echo base_url(); ?>bank_book/print_payment_voucher/"+bankbook.transaction_id, ""	);
			}
			
			self.JournalVoucher = function(bankbook){
				window.open("<?php echo base_url(); ?>bank_book/print_payment_journal_voucher/"+bankbook.transaction_id, ""	);
			}
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
				return $http.post('<?php echo base_url(); ?>index.php/bank_book/search_bank_books/', tempDetails).then(
					function(response) {
						self.bank_books = formatData(response.data);
					},
					function(errResponse) {
						console.error(errResponse.data.msg);
					}
				);
			};
			
			self.searchBankBooks();
			
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
			self.AttachFiles = function(vBook){
				var vNewForm = "<form method='post' action='/funds_tracker/upload' id='form_"+vBook.transaction_id+"' style='display:none;'>";
				// vNewForm += '<input type="hidden" name="bank_account_id" value="'+self.staticData.bank_account_id+'" />';
				// vNewForm += '<input type="hidden" name="bank" value="'+self.staticData.bank_id+'" />';
				// vNewForm += '<input type="hidden" name="account_name" value="'+self.staticData.bank_account_name+'" />';
				// vNewForm += '<input type="hidden" name="account_number" value="'+self.staticData.bank_account_number+'" />';
				vNewForm += '<input type="hidden" name="TrnxType" value="'+self.PreDefTrnxType+'" />';
				vNewForm += '<input type="hidden" name="StartDate" value="'+DateFormater.convertJsDate(self.searchBank_book.fromdate)+'" />';
				vNewForm += '<input type="hidden" name="Date" value="'+DateFormater.convertJsDateTime(vBook.date)+'" />';
				vNewForm += '<input type="hidden" name="PartyName" value="'+(vBook.party_name == null ? "" :vBook.party_name) +'" />';
				vNewForm += '<input type="hidden" name="Narration" value="'+vBook.narration+'" />';
				vNewForm += '<input type="hidden" name="IType" value="'+vBook.instrument_type+'" />';
				vNewForm += '<input type="hidden" name="IID" value="'+vBook.instrument_id_manual+'" />';
				vNewForm += '<input type="hidden" name="IDate" value="'+DateFormater.convertJsDate(vBook.instrument_date)+'" />';
				vNewForm += '<input type="hidden" name="BName" value="'+vBook.bank_name+'" />';
				vNewForm += '<input type="hidden" name="TType" value="'+vBook.debit_credit+'" />';
				vNewForm += '<input type="hidden" name="TAmt" value="'+vBook.transaction_amount+'" />';
				vNewForm += '<input type="hidden" name="BCS" value="'+(vBook.clearance_status == 1 ? "Yes" : "No")+'" />';
				vNewForm += '<input type="hidden" name="CD" value="'+DateFormater.convertJsDate(vBook.clearance_date)+'" />';
				vNewForm += '<input type="hidden" name="BR" value="'+(vBook.bill_recieved == 1 ? "Yes" : "No")+'" />';
				vNewForm += '<input type="hidden" name="Notes" value="'+vBook.notes+'" />';
				vNewForm += '<input type="hidden" name="EndDate" value="'+DateFormater.convertJsDate(self.searchBank_book.todate)+'" />';
				vNewForm += '<input type="hidden" name="TranxID" value="'+vBook.transaction_id+'" />';
				vNewForm += '<input type="hidden" name="Module" value="PaymentsReport" />';
				vNewForm += '<input type="hidden" name="PaymentVoucherNumber" value="'+vBook.bank_annual_voucher_id+'" />';
			  	vNewForm += "</form>";
			  	$("body").append(vNewForm);
			  	$("#form_"+vBook.transaction_id).submit();
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

	</script>
</div>