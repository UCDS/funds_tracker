<?php ?>


    <div ng-app ="projectsApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div ng-controller ="ProjectCtrl as projectCtrl">
        <form class="form-inline" ng-submit="projectCtrl.add()" name="addProject">            
            <div class="form-group">
              <label for="exampleInputName2">Project Name</label>
              <input type="text" class="form-control" ng-model="projectCtrl.newProject.project_name" required/>              
            </div>
            <!--<div class="form-group">
              <label for="exampleInputEmail2">Select Project Group</label>
              <select class="form-control" ng-model="projectCtrl.newProject.project_group_id" 
                  ng-options="group.project_group_id as group.project_group_name for group in projectCtrl.project_groups">                          
              </select>
            </div>-->
            <input type="submit" class="btn btn-default" value="Add" ng-disabled="addProject.$invalid">
        </form>    
        
        <h3>Projects</h3>
        
        <table class="table table-bordered table-hover">
            <thead>
                <tr>                    
                    <th>Project Name</th>
                </tr>
            </thead>
			<tbody>
				<tr class="active">
					<td ng-bind="projectCtrl.newProject.project_name"></td>
				</tr>
				<tr class="success" ng-repeat="project in projectCtrl.projects">
					<td ng-bind="project.project_name"></td>
				</tr>
            </tbody>
        </table>

        <script>
          angular.module('projectsApp', [])
            .controller('ProjectCtrl', ['$http', function($http) {
		  $("#LefNaveProject").addClass("active");
              var self = this;
              self.projects = [];
              self.project_groups = [];
              self.newProject = {};
              var fetchprojects = function() {
                return $http.get('index.php/project/get_projects').then(
                    function(response) {
	                  self.projects = response.data;                  
                }, function(errResponse) {
                  console.error(errResponse.data.msg);
                });
              };
              var fetchgroups = function(){
                return $http.get('index.php/project/get_project_groups').then(
                    function(response){
                        self.project_groups = response.data;
                    },function(errResponse){
                        console.error(errResponse.data.msg);
                    }
              )};
              fetchgroups();
              fetchprojects();
              
              self.add = function() {
                $http.post('index.php/project/add_project', self.newProject)
                    .then(fetchprojects)
                    .then(function(response) {
                      self.newProject = {};
                    });
              };
              
            }]);
        </script>
    </div>
    </div>
