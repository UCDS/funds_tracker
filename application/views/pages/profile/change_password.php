<?php
?>
<style type="text/css">
  
  .mand{
    color:red;
  }

</style>
<div ng-app ="ChangePasswordApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="row col-md-10 col-md-offset-1" ng-controller ="ChangePasswordCtrl as pwdCtrl">
		<form ng-submit="pwdCtrl.update()" name="changePassword">
			<div class="panel panel-default" ng-if="!pwdCtrl.pwdUpdated">
				<div class="panel-heading">
					<h4>Change Password</h4>
				</div>
				<div class="panel-body">
					
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="old_password" class="control-label">Old Password</label>
						</div>
						<div class="col-md-6">
							<input type="password" class="form-control" placeholder="Old Password" ng-model="pwdCtrl.FormData.old_password" name="old_password" id="old_password" required="">
							<span class="alert-danger" ng-show="changePassword.old_password.$touched && changePassword.old_password.$error.required" >
								This field is required
							</span>
						</div>
					</div>	
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="password" class="control-label">Password</label>
						</div>
						<div class="col-md-6">
							<input type="password" class="form-control" placeholder="Password" ng-model="pwdCtrl.FormData.password" id="password" name="password" required="" ng-minlength="5">
							<span class="alert-danger" ng-show="changePassword.password.$error.minlength" >
								Minimum of 5 characters
							</span>
							<span class="alert-danger" ng-show="changePassword.password.$touched && changePassword.password.$error.required" >
								This field is required
							</span>
						</div>
						
					</div>
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="password" class="control-label">Confirm Password</label>
						</div>
						<div class="col-md-6">
							<input type="password" class="form-control" placeholder="Confirm Password" ng-model="pwdCtrl.FormData.confirm_password" name="confirm_password" id="confirm_password" required="" ng-minlength="5">
							<span class="alert-danger" ng-show="changePassword.confirm_password.$error.minlength" >
								Minimum of 5 characters
							</span>
							<span class="alert-danger" ng-show="changePassword.confirm_password.$touched && changePassword.confirm_password.$error.required" >
								This field is required
							</span>
							<div class="alert alert-danger confirm_error " hidden="">Please re-enter your password correctly</div>
						</div>
					</div>
					
				</div>
				<div class="panel-footer">
					<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" ng-disabled="changePassword.$invalid" />
				</div>
			</div>
			<div class="alert alert-success" ng-if="pwdCtrl.pwdUpdated">
				<strong>Success!</strong> Password updated successfully.
			</div>
		</form>
	</div>
	<script>
	  angular.module('ChangePasswordApp', [])
		.controller('ChangePasswordCtrl', ['$http', function($http) {
			var self = this;
			self.pwdUpdated = 0;
			self.update = function(){
				$(".confirm_error").hide();
				if(self.FormData){
					if(self.FormData.confirm_password != self.FormData.password){
						$(".confirm_error").show();
						return false;
					}
					$http.post('<?php echo base_url(); ?>index.php/profile/updatepassword', self.FormData)
					.then(function(response){
						var data = response.data;
						if(data.ErroMsg){
							alert(data.ErroMsg);
						}else if(data.Status == 1){
							self.pwdUpdated = 1;
							//alert("Password updated successfully");
							//window.location.href="<?php echo base_url(); ?>bank_account/bank_book_summary";
						}
						
					},function(errResponse){
						console.error(errResponse.statusText);
					});
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
		}]);;
	</script>
</div>
