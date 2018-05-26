<div ng-app ="cheque_leavesApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div ng-controller ="Cheque_leafCtrl as cheque_leavesCtrl">
        <form class="form-inline" ng-submit="cheque_leavesCtrl.add()" name="addCheque_leaf">            
            <div class="form-group">
              <label for="exampleInputName2">Cheque Book ID</label>
              <select class="form-control" ng-model="cheque_leavesCtrl.newCheque_leaf.cheque_book_id" 
                  ng-options="cheque_book.cheque_book_id as cheque_book.cheque_book_id for cheque_book in cheque_leavesCtrl.cheque_books">                          
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Leaf Number</label>
              <input type="text" class="form-control" ng-model="cheque_leavesCtrl.newCheque_leaf.cheque_leaf_number"/>              
            </div>            
            <div class="form-group">
              <label for="exampleInputName2">Status</label>
              <label>
              <input type="radio" class="form-control" ng-model="cheque_leavesCtrl.newCheque_leaf.clearance_status" value="USED">
              Used
              </label>
              <label>
              <input type="radio" class="form-control" ng-model="cheque_leavesCtrl.newCheque_leaf.clearance_status" value="UNUSED">
              Unused
              </label>
              <label>
              <input type="radio" class="form-control" ng-model="cheque_leavesCtrl.newCheque_leaf.clearance_status" value="CANCELLED">
              Cancelled
              </label>
              <label>
              <input type="radio" class="form-control" ng-model="cheque_leavesCtrl.newCheque_leaf.clearance_status" value="EXPIRED">
              Expired
              </label>
            </div>            
            <input type="submit" class="btn btn-default" value="Add" ng-disabled="addCheque_leaf.$invalid">
        </form>    
        
        <div class="panel panel-yellow " style="margin-top:10px; ">
		<div class="panel-heading">Cheque Leafs</div>
		<table class="table table-hover tableevenodd">
			<thead>
				<tr>                    
					<th>Cheque Book ID</th>
					<th>Cheque Leaf Number</th>
					<th>Status</th>                    
				</tr>
			</thead>
			<tbody>
				<tr class="active">
					<td ng-bind="cheque_leavesCtrl.newCheque_leaf.cheque_book_id"></td>                
					<td ng-bind="cheque_leavesCtrl.newCheque_leaf.cheque_leaf_number"></td>
					<td ng-bind="cheque_leavesCtrl.newCheque_leaf.clearance_status"></td>                
		 <!--           <td>{{ cheque_leavesCtrl.newCheque_leaf.cheque_leaves_group_id }}</td> -->
				</tr>
				<tr ng-repeat="cheque_leaves in cheque_leavesCtrl.cheque_leaves">
					<td ng-bind="cheque_leaves.cheque_book_id"></td>                
					<td ng-bind="cheque_leaves.cheque_leaf_number"></td>
					<td ng-bind="cheque_leaves.clearance_status"></td>                
			  <!--      <td ng-bind="cheque_leaves.cheque_leaves_group_name"></td> -->
				</tr>
			</tbody>
		</table>
        </div>
        <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
        <script>
          angular.module('cheque_leavesApp', [])
            .controller('Cheque_leafCtrl', ['$http', function($http) {
		  $("#LefNaveChequeLeaf").addClass("active");
              var self = this;
              self.cheque_leaves = [];
              self.cheque_books = [];              
              self.newCheque_leaf = {};
              var fetch_cheque_leaves = function() {
                return $http.get('index.php/cheque_leaf/get_cheque_leaves').then(
                    function(response) {
                  self.cheque_leaves = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              var fetch_cheque_books = function() {
                return $http.get('index.php/cheque_book/get_cheque_books').then(
                    function(response) {
                  self.cheque_books = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              
              
              fetch_cheque_books();
              fetch_cheque_leaves();
              
              self.add = function() {
                $http.post('index.php/cheque_leaf/add_cheque_leaf', self.newCheque_leaf)
                    .then(fetch_cheque_leaves)
                    .then(function(response) {
                      self.newCheque_leaf = {};
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

