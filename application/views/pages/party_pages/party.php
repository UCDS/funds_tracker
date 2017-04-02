<?php
?>
<style type="text/css">
  
  label{
    width:100px;
  }
  .mand{
    color:red;
  }

</style>
<div ng-app ="partysApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div ng-controller ="PartyCtrl as partyCtrl">

        <div ng-show="!partyCtrl.addflag && !partyCtrl.updateflag" class="row">
          <input type="button" class="btn btn-primary" ng-click="partyCtrl.addflag=1" value="Add Party" />
        </div>
          <form class="form-inline" ng-show="partyCtrl.addflag || partyCtrl.updateflag" ng-submit="partyCtrl.add()" name="addParty">            
            <div class="col-lg-12 col-md-12" style="padding: 0px;">
              <div class="form-group  col-lg-4 col-md-6">
                <label for="exampleInputName2"><span class="mand">*</span>Party Name</label>
                <input type="text" class="form-control" ng-model="partyCtrl.newParty.party_name" required/>              
              </div>
              <div class="form-group col-lg-6 col-md-6">
                <label >Gender</label>
                <input type="radio" class="form-control" ng-model="partyCtrl.newParty.gender" value="M">
                <label> Male</label>
                <input type="radio" class="form-control" ng-model="partyCtrl.newParty.gender" value="F">
                <label>Female</label>
                <input type="radio" class="form-control" ng-model="partyCtrl.newParty.gender" value="O">
                <label>Other</label>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-6">
              <label for="exampleInputEmail2">Address</label>
              <input type="text" class="form-control" ng-model="partyCtrl.newParty.address">              
            </div>
            <div class="form-group col-lg-4 col-md-6">
              <label for="exampleInputName2">Place</label>
              <input type="text" class="form-control" ng-model="partyCtrl.newParty.place"/>              
            </div>
            <div class="form-group col-lg-4 col-md-6">
              <label for="exampleInputName2">Phone</label>
              <input type="text" class="form-control" ng-model="partyCtrl.newParty.phone"/>              
            </div>            
            <div class="form-group col-lg-4 col-md-6">
              <label for="exampleInputEmail2">Alt Phone</label>
              <input type="text" class="form-control" ng-model="partyCtrl.newParty.alt_phone">              
            </div>
            <div class="form-group col-lg-4 col-md-6">
              <label for="exampleInputEmail2">Email</label>
              <input type="email" class="form-control" ng-model="partyCtrl.newParty.email">              
            </div>
            <div class="form-group col-lg-4 col-md-6">
              <label for="exampleInputName2">Notes</label>
              <input type="text" class="form-control" ng-model="partyCtrl.newParty.note"/>              
            </div>
            <!--
            <div class="form-group col-lg-4 col-md-6">
              <label for="exampleInputName2">Project</label>
              <select class="form-control" ng-model="partyCtrl.newParty.project_id" 
                  ng-options="project.project_id as project.project_name for project in partyCtrl.projects" style="width: 195px;">                          
              </select>
            </div>-->
            <input type="submit" class="btn btn-default" value="{{partyCtrl.getSubmitButtonText()}}" ng-disabled="addParty.$invalid">
            <input type="button" class="btn btn-default" value="Cancel" ng-click="partyCtrl.cancelUpdate()" ng-show="partyCtrl.updateflag || partyCtrl.addflag">
          </form>    
        
            
          <div style="margin-top: 10px;">
            <div class="panel panel-yellow ">
              <div class="panel-heading"><i class="fa fa-bell fa-fw"></i>Parties</div>
                <table class="table tableevenodd table-hover">
                  <thead>
                    <tr>
                      <th>Party ID</th>
                      <th>Party Name</th>
                      <th>Gender</th>
                      <th>Address</th>
                      <th>Place</th>
                      <th>Phone</th>
                      <th>Alt Phone</th>
                      <th>Email</th>
                      <th>Notes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="active">
                      <td ng-bind="partyCtrl.newParty.party_id"></td>
                      <td ng-bind="partyCtrl.newParty.party_name"></td>
                      <td ng-bind="partyCtrl.newParty.gender"></td>
                      <td ng-bind="partyCtrl.newParty.address"></td>
                      <td ng-bind="partyCtrl.newParty.place"></td>
                      <td ng-bind="partyCtrl.newParty.phone"></td>
                      <td ng-bind="partyCtrl.newParty.alt_phone"></td>
                      <td ng-bind="partyCtrl.newParty.email"></td>
                      <td ng-bind="partyCtrl.newParty.note"></td>
                    </tr>
                    <tr ng-repeat="party in partyCtrl.partys" ng-click="partyCtrl.editRecord(party,$index)">
                      <td ng-bind="party.party_id"></td>
                      <td ng-bind="party.party_name"></td>
                      <td ng-bind="party.gender"></td>
                      <td ng-bind="party.address"></td>
                      <td ng-bind="party.place"></td>
                      <td ng-bind="party.phone"></td>
                      <td ng-bind="party.alt_phone"></td>
                      <td ng-bind="party.email"></td>
                      <td ng-bind="party.note"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
        <script>
          angular.module('partysApp', [])
            .controller('PartyCtrl', ['$http', function($http) {
		  $("#LefNaveParty").addClass("active");
              var self = this;
              self.partys = [];
              self.banks = [];
              self.projects = [];
              self.instrument_types = [];
              self.cheque_leaves = [];
              self.newParty = {};
              self.updateflag = 0;
              self.addflag = 0;

              self.party_index ;
              self.party_editing ;

              self.cancelUpdate = function(){
                self.newParty = {};
                if(self.updateflag == 1){
                  self.partys.splice(self.party_index,0,self.party_editing);
                }
                self.updateflag = 0;
                self.addflag = 0;
                self.party_index = 0;
                self.party_editing = {};
              };
              self.editRecord = function(record,vIndex){
                self.addflag = 0;
                var temp_party_editing = self.partys.splice(vIndex,1);
                if(self.updateflag == 1){
                  self.partys.splice(self.party_index,0,self.party_editing);
                }
                self.party_index = vIndex;
                self.party_editing = temp_party_editing[0];

                jQuery.extend(self.newParty, record);
                self.updateflag = 1;
              };
              
              self.getSubmitButtonText = function(){
                return self.updateflag == 0 ? "Add" : "Update"  ;
              };
            
              var fetch_partys = function() {
                return $http.get('index.php/party/get_party').then(
                    function(response) {
                  self.partys = response.data;
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              
              var fetch_projects = function() {
                return $http.get('index.php/project/get_projects').then(
                    function(response) {
                  self.projects = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              
              fetch_projects();
              fetch_partys();             
              
              
              self.add = function() {
                $http.post('index.php/party/add_party', self.newParty)
                    .then(fetch_partys)
                    .then(function(response) {
                      self.newParty = {};
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
