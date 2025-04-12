<div ng-app ="cheque_leavesApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div ng-controller ="Cheque_leafCtrl as cheque_leavesCtrl">
        <form class="form-inline" ng-submit="cheque_leavesCtrl.add()" name="addCheque_leaf">            
            <div class="form-group">
              <label for="exampleInputName2">Cheque Book ID</label>
              <select class="form-control" ng-model="cheque_leavesCtrl.newBank_account.cheque_leaves_id" 
                  ng-options="bank.cheque_leaves_id as bank.cheque_leaves_id for bank in cheque_leavesCtrl.cheque_leaves">                          
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Leaf Number</label>
              <input type="text" class="form-control" ng-model="cheque_leavesCtrl.newCheque_leaf.cheque_leaf_number"/>              
            </div>            
            <div class="form-group">
              <label for="exampleInputName2">Status</label>
              <label>
              <input type="radio" class="form-control" ng-model="bank_bookCtrl.newBank_book.clearance_status" value="USED">
              Used
              </label>
              <label>
              <input type="radio" class="form-control" ng-model="bank_bookCtrl.newBank_book.clearance_status" value="UNUSED">
              Unused
              </label>
              <label>
              <input type="radio" class="form-control" ng-model="bank_bookCtrl.newBank_book.clearance_status" value="CANCELLED">
              Cancelled
              </label>
              <label>
              <input type="radio" class="form-control" ng-model="bank_bookCtrl.newBank_book.clearance_status" value="EXPIRED">
              Expired
              </label>
            </div>            
            <input type="submit" class="btn btn-default" value="Add" ng-disabled="addCheque_leaf.$invalid">
        </form>    
        
        <h3>Cheque_leafs Added</h3>
        
        <table class="table table-bordered table-hover">
            <thead>
                <tr>                    
                    <th>Cheque book ID</th>
                    <th>Cheque Leaf Number</th>
                    <th>Status</th>                    
                </tr>
            </thead>
            <tr class="success" ng-repeat="cheque_leaves in cheque_leavesCtrl.cheque_leaves">
                <td ng-bind="cheque_leaves.cheque_book_id"></td>                
                <td ng-bind="cheque_leaves.cheque_leaf_number"></td>
                <td ng-bind="cheque_leaves.status"></td>                
          <!--      <td ng-bind="cheque_leaves.cheque_leaves_group_name"></td> -->
            </tr>
            <tr class="active">
                <td>{{ cheque_leavesCtrl.newCheque_leaf.cheque_book_id }}</td>                
                <td>{{ cheque_leavesCtrl.newCheque_leaf.cheque_leaf_number }}</td>
                <td>{{ cheque_leavesCtrl.newCheque_leaf.status }}</td>                
     <!--           <td>{{ cheque_leavesCtrl.newCheque_leaf.cheque_leaves_group_id }}</td> -->
            </tr>
        </table>
        
        <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
        <script>
          angular.module('cheque_leavesApp', [])
            .controller('Cheque_leafCtrl', ['$http', function($http) {
              var self = this;
              self.cheque_leaves = [];
              self.banks = [];
              self.partys = [];
              self.cheque_leaves_groups = [];
              self.newCheque_leaf = {};
              var fetchcheque_leaves = function() {
                return $http.get('index.php/cheque_leaves/get_cheque_leaves').then(
                    function(response) {
                  self.cheque_leaves = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              var fetch_cheque_books = function() {
                return $http.get('index.php/bank/get_banks').then(
                    function(response) {
                  self.banks = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              
              
              fetch_cheque_books;
              fetchcheque_leaves();
              
              self.add = function() {
                $http.post('index.php/cheque_leaves/add_cheque_leaves', self.newCheque_leaf)
                    .then(fetchcheque_leaves)
                    .then(function(response) {
                      self.newCheque_leaf = {};
                    });
              };
              
            }]);
        </script>
    </div>
    </div>

