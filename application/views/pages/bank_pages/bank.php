<?php ?>

<div ng-app ="banksApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div ng-controller ="BankCtrl as bankCtrl">
		<form class="form-inline" ng-submit="bankCtrl.add()" name="addBank">            
			<div class="form-group">
			  <label for="exampleInputName2">Bank Name</label>
			  <input type="text" class="form-control" ng-model="bankCtrl.newBank.bank_name" required/>              
			</div>
			<!--
			<div class="form-group">
			  <label for="exampleInputEmail2">Select Bank Group</label>
			  <select class="form-control" ng-model="bankCtrl.newBank.bank_group_id" 
				  ng-options="group.bank_group_id as group.bank_group_name for group in bankCtrl.bank_groups">                          
			  </select>
			</div> -->
			<div class="form-group">
				<label for="note">Note</label>
				<input type="text" class="form-control" ng-model="bankCtrl.newBank.note" />
			</div>
			<input type="submit" class="btn btn-default" value="Add" ng-disabled="addBank.$invalid">
		</form>
		<div class="row" style="margin-top: 10px;">
			<div class="panel panel-yellow ">
				<div class="panel-heading"><i class="fa fa-bell fa-fw"></i>Banks</div>
					<table class="table table-hover tableevenodd">
						<thead>
							<tr>                    
								<th>Bank Name</th>
								<th>Note</th> 
							</tr>
						</thead>
						<tbody>
						<tr class="active">
							<td ng-bind="bankCtrl.newBank.bank_name"></td>
							<td ng-bind="bankCtrl.newBank.note"></td>
						</tr>
						<tr ng-repeat="bank in bankCtrl.banks">
							<td ng-bind="bank.bank_name"></td>
							<td ng-bind="bank.note"></td> 
						</tr>
						</tbody>
					</table>
			</div>
		</div>
        
        <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
        <script>
          angular.module('banksApp', [])
            .controller('BankCtrl', ['$http', function($http) {
			  $("#LefNaveBank").addClass("active");
              var self = this;
              self.banks = [];
         //     self.bank_groups = [];
              self.newBank = {};
              self.not = {};
              var fetchbanks = function() {
                return $http.get('index.php/bank/get_banks').then(
                    function(response) {
                  self.banks = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              /*
              var fetchgroups = function(){
                return $http.get('index.php/bank/get_bank_groups').then(
                    function(response){
                        self.bank_groups = response.data;
                    },function(errResponse){
                        console.error(errResponse.data.msg);
                    }
              )};
              fetchgroups(); */
              fetchbanks();
              
              self.add = function() {
                $http.post('index.php/bank/add_bank', self.newBank)
                    .then(fetchbanks)
                    .then(function(response) {
                      self.newBank = {};
                    });
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