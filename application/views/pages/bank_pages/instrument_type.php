<div ng-app ="instrumentsApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div ng-controller ="InstrumentCtrl as instrumentCtrl">
    <form class="form-inline" ng-submit="instrumentCtrl.add()" name="addInstrument">            
        <div class="form-group">
          <label for="exampleInputName2">Instrument Name</label>
          <input type="text" class="form-control" ng-model="instrumentCtrl.newInstrument.instrument_type" required/>              
        </div>        
        <input type="submit" class="btn btn-default" value="Add" ng-disabled="addInstrument.$invalid">
    </form>    

	<div class="panel panel-yellow " style="margin-top:10px; ">
		<div class="panel-heading">Instruments</div>
		<table class="table tableevenodd table-hover">
			<thead>
				<tr>                    
					<th>Instrument Name</th>                
				</tr>
			</thead>
			<tbody>
				<tr class="active">
					<td ng-bind="instrumentCtrl.newInstrument.instrument_type"></td>           
				</tr>
				<tr ng-repeat="instrument in instrumentCtrl.instruments">
					<td ng-bind="instrument.instrument_type"></td>
				</tr>
			</tbody>
		</table>
	</div>
    <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
    <script>
      angular.module('instrumentsApp', [])
        .controller('InstrumentCtrl', ['$http', function($http) {
		  $("#LefNaveInstrumentType").addClass("active");
          var self = this;
          self.instruments = [];          
          self.newInstrument = {};
          var fetch_instruments = function() {
            return $http.get('index.php/instrument_type/get_instrument_type').then(
                function(response) {
              self.instruments = response.data;                  
            }, function(errResponse) {
              console.error(errResponse.data.msg);
            });
          };
          
          fetch_instruments();
          
          self.add = function() {
            $http.post('index.php/instrument_type/add_instrument_type', self.newInstrument)
                .then(fetch_instruments)
                .then(function(response) {
                  self.newInstrument = {};
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
