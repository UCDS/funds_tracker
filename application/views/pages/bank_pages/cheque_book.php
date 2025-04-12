<div ng-app ="cheque_booksApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div ng-controller ="Cheque_bookCtrl as cheque_bookCtrl">
        <form class="form-inline" ng-submit="cheque_bookCtrl.add()" name="addCheque_book"> 
          <div class="row">
            <div class="col-md-5">           
              <div class="form-group" >
                <label for="exampleInputName2">Bank Account</label><font style="color:red">*</font>
                <input type="text" class="form-control" ng-model="cheque_bookCtrl.newCheque_book.account_id"  required />              
              </div>
            </div>
            <div class="col-md-5">           
              <div class="form-group" >
                <label for="exampleInputEmail2">Bank ID</label><font style="color:red">*</font>
                <select class="form-control" ng-model="cheque_bookCtrl.newBank_account.bank_id" 
                    ng-options="bank.bank_id as bank.bank_name for bank in cheque_bookCtrl.banks" required />                          
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group" >
                <label for="exampleInputName2">From Cheque Number</label><font style="color:red">*</font>
                <input type="text" class="form-control" ng-model="cheque_bookCtrl.newCheque_book.from_cheque" required />              
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group" >
                <label for="exampleInputName2">To Cheque Number</label><font style="color:red">*</font>
                <input type="text" class="form-control" ng-model="cheque_bookCtrl.newCheque_book.to_cheque" required >              
              </div>            
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-default" style="margin-left:15px;" value="Add" ng-disabled="addCheque_book.$invalid">
            </div>
          </div> 
        </form>   
        <div class="panel panel-yellow " style="margin-top:10px; ">
		<div class="panel-heading">Cheque Books</div>
        
		<table class="table table-hover tableevenodd">
			<thead>
				<tr>                    
					<th>Cheque book ID</th>
					<th>Bank Account</th>
					<th>Bank</th>
					<th>From Cheque Number</th>
					<th>To Cheque Number</th>
				</tr>
			</thead>
			<tbody>
				<tr class="active">
					<td ng-bind="cheque_bookCtrl.newCheque_book.cheque_book_id"></td>  
					<td ng-bind="cheque_bookCtrl.newCheque_book.account_id"></td>
					<td ng-bind="cheque_bookCtrl.newCheque_book.bank_id"></td>                
					<td ng-bind="cheque_bookCtrl.newCheque_book.from_cheque"></td>
					<td ng-bind="cheque_bookCtrl.newCheque_book.to_cheque"></td>                
		 <!--           <td>{{ cheque_bookCtrl.newCheque_book.cheque_book_group_id }}</td> -->
				</tr>
				<tr ng-repeat="cheque_book in cheque_bookCtrl.cheque_books">
					<td ng-bind="cheque_book.cheque_book_id"></td>                
					<td ng-bind="cheque_book.account_id"></td>
					<td ng-bind="cheque_book.bank_id"></td>                
					<td ng-bind="cheque_book.from_cheque"></td>
					<td ng-bind="cheque_book.to_cheque"></td>                
			  <!--      <td ng-bind="cheque_book.cheque_book_group_name"></td> -->
				</tr>
			</tbody>
		</table>
        </div>
        <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
        <script>
          angular.module('cheque_booksApp', [])
            .controller('Cheque_bookCtrl', ['$http', function($http) {
			  $("#LefNaveChequeBook").addClass("active");
              var self = this;
              self.cheque_books = [];
              self.banks = [];
              self.partys = [];
              self.cheque_book_groups = [];
              self.newCheque_book = {};
              var fetchcheque_books = function() {
                return $http.get('index.php/cheque_book/get_cheque_books').then(
                    function(response) {
                  self.cheque_books = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              var fetch_banks = function() {
                return $http.get('index.php/bank/get_banks').then(
                    function(response) {
                  self.banks = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              var fetch_partys = function() {
                return $http.get('index.php/party/get_party').then(
                    function(response) {
                  self.partys = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              /*
              var fetchgroups = function(){
                return $http.get('index.php/cheque_book/get_cheque_book_groups').then(
                    function(response){
                        self.cheque_book_groups = response.data;
                    },function(errResponse){
                        console.error(errResponse.data.msg);
                    }
              )};
              fetchgroups(); */
              fetch_banks();
              fetch_partys();
              fetchcheque_books();
              
              self.add = function() {
                $http.post('index.php/cheque_book/add_cheque_book', self.newCheque_book)
                    .then(fetchcheque_books)
                    .then(function(response) {
                      self.newCheque_book = {};
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

