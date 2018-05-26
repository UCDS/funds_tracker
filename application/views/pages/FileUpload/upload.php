


<script src="<?php echo base_url(); ?>css_js/js_custom/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/tmpl.min.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/jquery.iframe-transport.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/jquery.fileupload.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/jquery.fileupload-process.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/jquery.fileupload-validate.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/jquery.fileupload-ui.js"></script>
<script src="<?php echo base_url(); ?>css_js/js_custom/main.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css_js/css_custom/style.css" >
<link rel="stylesheet" href="<?php echo base_url();?>css_js/css_custom/jquery.fileupload-ui.css" >
<link rel="stylesheet" href="<?php echo base_url();?>css_js/css_custom/jquery.fileupload.css" >
<link rel="stylesheet" href="<?php echo base_url();?>css_js/css_custom/blueimp-gallery.min.css" >
<div ng-app ="uploadApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div ng-controller ="LedgerReport as LedgerCtrl">
		<?php 
		if( (isset($Module) == false || $Module != "journal") && $ledgerType != 2){	
		?>
		<div class="panel panel-yellow ">
			<div class="panel-heading">Transactions</div>
			<table class="table tableevenodd table-hover" style="font-size: 11px;">
				<thead>
					<tr>
						<th>Voucher Number</th>
						<th>Transaction Date</th>
						<th>Party Name</th>
						<th >Narration</th>
						<th >Instrument Type</th>
						<th >Instrument ID</th>
						<th >Instrument Date
						</th>
						<th >Bank Name</th>
						<th >Transaction Type
						</th>
						<th >Transaction Amount
						</th>
						<th >Bank Clearance Status
						</th>
						<th >Clearance Date
						</th>
						<th >Bill Received
						</th>
						<th >Notes
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td ng-bind="<?=isset($PaymentVoucherNumber) ? $PaymentVoucherNumber : ''?>"></td>
						<td ng-bind=" '<?=$Date?>' | formatDateTime | date:'dd-MMM-yyyy HH:mm'"></td>
						<td><?=$PartyName?></td>
						<td><?=$Narration?></td>
						<td><?=$IType?></td>
						<td><?=$IID?></td>
						<td ng-bind="'<?=$IDate?>' | formatDate | date:'dd-MMM-yyyy'"></td>
						<td><?=$BName?></td>
						<td><?=$TType?></td>
						<td ng-bind=" '<?=$TAmt?>' | currency : '&#x20b9 '"></td>
						<td><?=$BCS?></td>
						<td><?=$CD?></td>
						<td><?=$BR?></td>
						<td><?=$Notes?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php } ?>
		<div  class="panel panel-green ">
			<div class="panel-heading">Ledger</div>
			<div>
				<table class="table tableevenodd table-hover" style="font-size: 11px;">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Amount</th>
							<th>Trnx Type</th>
							<th>Account</th>
							<th>Sub Account</th>
							<th>Narration</th>
							<th>Payee Party</th>
							<th>Item</th>
							<th>Project</th>
							<th>Donor Party</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="ledgerrecord in LedgerCtrl.ledgerDetails">
							<td ng-bind="$index+1"></td>
							<td>
								<span ng-bind="ledgerrecord.amount | currency : '&#x20b9 '"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.debit_credit"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.ledger_account_name"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.ledger_sub_account_name"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.narration"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.payer_party_name"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.item_name"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.project_name"></span>
							</td>
							<td>
								<span ng-bind="ledgerrecord.donor_party_name"></span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<?php 
			if(isset($Module) && $Module == "PartyReport")
				echo form_open("report/party#/PartyDetails");
			else if(isset($Module) && $Module == "LedgerReport")
				echo form_open("report/ledger#/LedgerDetails",array('role'=>'form','class'=>'form-custom',"autofill"=>"off")); 
			else if(isset($Module) && $Module == "journal")
				echo form_open("journal",array('role'=>'form','class'=>'form-custom',"autofill"=>"off"));
			else if(isset($Module) && $Module == "PaymentsReport"){
				echo form_open("report/payments",array('role'=>'form','class'=>'form-custom',"autofill"=>"off"));
			}
			else if(isset($Module) && $Module == "ReceiptsReport"){
				echo form_open("report/receipts",array('role'=>'form','class'=>'form-custom',"autofill"=>"off"));
			}
			else
				echo form_open("bank_book",array('role'=>'form','class'=>'form-custom',"autofill"=>"off")); 
		?>
			<input type="hidden" name="bank_account_id" value="<?=$bank_account_id?>" />
			<input type="hidden" name="bank" value="<?=$bank?>"/>
			<input type="hidden" name="account_name" value="<?=$account_name?>" />
			<input type="hidden" name="account_number" value="<?=$account_number?>" />
			<input type="hidden" name="TrnxType" value="<?=$TrnxType?>" />
			<input type="hidden" name="FromDate" value="<?=$StartDate?>" />
			<input type="hidden" name="ToDate" value="<?=$EndDate?>" />
			<input type="hidden" name="PartyID" value="<?=$PartyID?>" />
			<input type="hidden" name="PartyName" value="<?=$PartyName?>" />
			<input type="hidden" name="ClearanceStatus" value="<?=$ClearanceStatus?>" />
			<input type="hidden" name="searchID" value="<?=$searchID?>" />
			<input type="hidden" name="searchBy" value="<?=$searchBy?>" />
			<input type="hidden" name="project_id" value="<?=$project_id?>" />
			<input type="hidden" name="ledger_reference_table" value="<?=$ledger_reference_table?>" />
			
			<button type="submit" class="btn" style="float:right">
				<i class="glyphicon glyphicon-arrow-left"></i>
				<span>Back</span>
			</button>
		<?php echo form_close(); ?>
		
		<form id="fileupload" action="" method="POST" enctype="multipart/form-data">
			<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
			<?php
				if($this->session->logged_in == 'YES'){
			?>
				<div class="row fileupload-buttonbar">
					<div class="col-lg-7">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Add files...</span>
							<input type="file" name="files[]" multiple>
						</span>
						<button type="submit" class="btn btn-primary start">
							<i class="glyphicon glyphicon-upload"></i>
							<span>Start upload</span>
						</button>
						<button type="reset" class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancel upload</span>
						</button>
						<button type="button" class="btn btn-danger delete">
							<i class="glyphicon glyphicon-trash"></i>
							<span>Delete</span>
						</button>
						<input type="checkbox" class="toggle">
						<!-- The global file processing state -->
						<span class="fileupload-process"></span>
					</div>
					<!-- The global progress state -->
					<div class="col-lg-5 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar progress-bar-success" style="width:0%;"></div>
						</div>
						<!-- The extended global progress state -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
			<?php
				}
			?>
			<!-- The table listing the files available for upload/download -->
			<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
		</form>
	</div>
</div>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->

<script>
	function getTranxID(){
		return '<?php echo $TranxID;?>';
	}
	function getLedgerType(){
		return '<?=isset($ledgerType) ?$ledgerType : "1"?>';
	}
	// download="{%=file.name%}"
	// download="{%=file.name%}"
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" target="_blank" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" target="_blank"  {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
<?php
	if($this->session->logged_in == 'YES'){
?>
        <td>
            {% if (file.deleteUrl) { %}

                <button class="btn btn-success" style="background-color: #c0cac7; border-color: #e0e6e0;">
                    <i class="glyphicon glyphicon-download"></i>
                    <a href="{%=file.url%}" download="{%=file.name%}" title="{%=file.name%}" style="color: #fff;">Download</a>
                </button>
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}

            {% if (file.renameUrl) { %}
                <button class="btn btn-success rename" data-type="POST" data-url="{%=file.renameUrl%}" style="background-color: #6fb19d; border-color: #e0e6e0;">
                    <i class="glyphicon glyphicon-edit"></i>
                    <span>Rename</span>
                </button>
            {% } %}

        </td>
<?php
	}
?>
    </tr>
{% } %}
</script>

	<script>
		angular.module('uploadApp', [])
		.controller('LedgerReport', ['$http', function($http) {
			var self = this;
			$http.post('ledger/getLedgerTransactions/<?=$TranxID?>/<?=isset($ledgerType) ?$ledgerType : "1"?>')
			.then(function(data){
				self.ledgerDetails = data.data;
			});
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
		.filter('formatDateTime',[function(){
			return function(vStringDate){
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
			}
		}])
		.filter('formatDate',[function(){
			return function(vStringDate){
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
			}
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
