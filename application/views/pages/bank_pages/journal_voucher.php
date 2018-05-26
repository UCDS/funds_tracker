<script src="<?php echo base_url(); ?>css_js/js_frameworks/jquery-3.1.0.min.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_frameworks/angular.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_frameworks/lodash.min.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_frameworks/angular-route.min.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_custom/funds_tracker.js"></script>
    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css_js/css_frameworks/css/bootstrap.min.css" rel="stylesheet">  

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>css_js/css_custom/dashboard.css" rel="stylesheet">
<style>
	.details label{
		width:150px;
	}
	h4{
		font-weight:bold !important;
	}
	.details>div{
		min-height:50px;
		padding-top:15px;
		
	}
	.normal-label{
		font-weight:normal !important;
	}
	.span-bold{
		font-weight:bold;
	}
	table { border-collapse: collapse; }
	tr { 
		border: none; 
		height:30px;
	}
	td,th {
	  border-right: 1px solid #000; 
	  border-left: 1px solid #000;
	}
	td{
		
		padding:5px;
	}
	th {
	  border-top: 1px solid #000; 
	  border-bottom: 1px solid #000;
	}
	tbody{
		border-bottom: 1px solid #000;
	}
	
	body{
		font-size:16px;
	}
</style>	
<div ng-app="PrintVoucher">
	<div class="container" ng-controller="PrintVoucherCtrl as PVCtrl">
		<div class="col-md-12" style="border:1px solid grey;">
			<div class="row" style="text-align:center;"> 
				<h3>United Care Development Services</h3>
				<h4>
					<?= $tranx->debit_credit == "Debit" ? "Payment Journal Voucher" : "Receipt Journal Voucher" ?>
				</h4>
			</div>
			<div style="width:100%; display:inline-flex;">
				<div style="width:50%;">
					<label class="normal-label">Voucher No:</label>
					<span class="span-bold"><?=$tranx->bank_annual_voucher_id?></span>
				</div>
				
				<div style="width:50%;text-align:right;">
					<label class="normal-label">Date:</label>
					<span class="span-bold"><?=$tranx->trnx_date?></span>
					
				</div>
			</div>
			<?php
				$totalAmount = 0;
				foreach($ldgrtranx as $ldtranx){
					$totalAmount += $ldtranx->amount;
				}
			?>
			<div class="row details" style="border:1px solid grey;">
				
				<table  style="width:100%;">
					<thead>
						<th>Particulars</th>
						<th style="text-align:center;">Debits (INR)</th>
						<th style="text-align:center;">Credits (INR)</th>
					</thead>
					<tbody >
					
						<?php
							if($tranx->debit_credit == "Debit"){
								foreach($ldgrtranx as $ldtranx){
						?>
								<tr>
									<td>
										<?=$ldtranx->ledger_account_name?>
										<div style="padding-left:30px; font-size:14px;" >
										<?php
											$narration = array();
											if(strlen($ldtranx->ledger_sub_account_name) > 0)
												array_push($narration,$ldtranx->ledger_sub_account_name);
											
											if(strlen($ldtranx->narration) > 0)
												array_push($narration,$ldtranx->narration);
											
											if(strlen($ldtranx->payer_party_name) > 0)
												array_push($narration,$ldtranx->payer_party_name);
											
											$narration = implode(" - ",$narration);
											if(strlen($narration) > 0)
												echo "(".$narration . ")";
											
										?>
										</div>
									</td>
									<td class="num-align" >
										<span ng-show="<?=$ldtranx->debit_credit == "Debit"?>" ng-bind="'<?= $ldtranx->debit_credit == "Debit" ? $ldtranx->amount : "" ?>' | currency : ''">
										</span>
									</td>
									<td class="num-align" >
										<span ng-show="<?=$ldtranx->debit_credit == "Credit"?>" ng-bind="'<?= $ldtranx->debit_credit == "Credit" ? $ldtranx->amount : "" ?>' | currency : ''">
										</span>
									</td>
								</tr>	
						<?php
								}
							}
						?>
						<tr>
							<td>Bank</td>
							<td class="num-align">
								<span ng-show="<?=$ldtranx->debit_credit == "Credit"?>" ng-bind="'<?= $tranx->debit_credit == "Credit" ? $tranx->transaction_amount_ui : "" ?>' | currency : ''">
								</span>
							</td>
							<td class="num-align" >
								<span ng-show="<?=$ldtranx->debit_credit == "Debit"?>" ng-bind="'<?= $tranx->debit_credit == "Debit" ? $tranx->transaction_amount_ui : "" ?>' | currency : ''">
								</span>
							</td>
						</tr>
						<?php
							if($tranx->debit_credit == "Credit"){
								foreach($ldgrtranx as $ldtranx){
						?>
								<tr>
									<td>
										<?=$ldtranx->ledger_account_name?>
										<div style="padding-left:30px; font-size:14px;" >
										<?php
											$narration = array();
											if(strlen($ldtranx->ledger_sub_account_name) > 0)
												array_push($narration,$ldtranx->ledger_sub_account_name);
											
											if(strlen($ldtranx->narration) > 0)
												array_push($narration,$ldtranx->narration);
											
											if(strlen($ldtranx->payer_party_name) > 0)
												array_push($narration,$ldtranx->payer_party_name);
											
											$narration = implode(" - ",$narration);
											if(strlen($narration) > 0)
												echo "(".$narration . ")";
											
										?>
										</div>
									</td>
									<td class="num-align">
										<span ng-show="<?=$ldtranx->debit_credit == "Debit"?>" ng-bind="'<?= $ldtranx->debit_credit == "Debit" ? $ldtranx->amount : "" ?>' | currency : ''">
										</span>
									</td>
									<td class="num-align">
										<span  ng-show="<?=$ldtranx->debit_credit == "Credit"?>" ng-bind="'<?= $ldtranx->debit_credit == "Credit" ? $ldtranx->amount : "" ?>' | currency : ''">
										</span>
									</td>
								</tr>
								
						<?php
								}
							}
						?>
						
						<tr style="border-top:1px solid #000; font-weight:bold;">
							<td>Total</td>
							<td class="num-align">
								<span ng-bind="'<?=$ldtranx->debit_credit == "Credit" ? $tranx->transaction_amount_ui : $totalAmount ?>' | currency : ''"></span>
							</td>
							<td class="num-align">
								<span ng-bind="'<?=$ldtranx->debit_credit == "Debit" ? $tranx->transaction_amount_ui : $totalAmount ?>' | currency : ''"></span>
							</td>
						</tr>
					</tbody>
				</table>
				
				<div class="col-md-12" style="border-bottom:1px solid grey;">
					
					<label><?= $tranx->debit_credit == "Debit" ? "Payee:" : "Payer:" ?></label><?=$tranx->party_name?>
					
				</div>
				<div class="col-md-12" style="border-bottom:1px solid grey;">
					
					<label>On account of :</label><?=$tranx->narration?>
					
				</div>
				
				<div class="col-md-12" style="border-bottom:1px solid grey;">
					
					<label>Through :</label>
					<?=( $tranx->bank_name ? $tranx->bank_name."-" : "" ). ($tranx->account_number ? $tranx->account_number.", " : "") . ($tranx->instrument_type ? $tranx->instrument_type."-" : "").$tranx->instrument_id_manual?>
					
				</div>

				<?php if(isset($tranx->notes) && strlen($tranx->notes)>0){?>
					<div class="col-md-12" style="border-bottom:1px solid grey;">
						<label>Notes :</label> <?php echo $tranx->notes; ?>
					</div>
				<?php }?>
				
				<div class="col-md-12" style="border-bottom:1px solid grey; display:none;">
						<label>Amount:</label> <span ng-bind="PVCtrl.amount | currency:'INR '" ></span>
						<span ng-show="PVCtrl.amount" ng-bind="'('+(PVCtrl.amount | words | capitalize)+')'"></span>
				</div>
				
				<div style="padding-top:70px; width:100%; display:inline-flex;">
					<div style="width:50%;text-align:center;">
						<label><?= $tranx->debit_credit == "Debit" ? "" : "" ?></label>
						
					</div>
					<div style="width:50%;text-align:center;">
						<label>Authorised Signatory</label>
						
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
	angular.module("PrintVoucher",[])
		.controller("PrintVoucherCtrl",[function(){
			var self = this;
			self.amount = <?=$tranx->transaction_amount_ui?>;
		}])
		.filter('words', function() {
		  function isInteger(x) {
				return x % 1 === 0;
			}

		  
		  return function(value) {
			if (value && isInteger(value))
			  return  toWords(value);
			
			return value;
		  };

		})
		.filter('capitalize', function() {
			return function(input) {
			  return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
			}
		});


var th = ['','thousand','million', 'billion','trillion'];
var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; 
var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen'];
var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety']; 


function toWords(s)
{  
    s = s.toString(); 
    s = s.replace(/[\, ]/g,''); 
    if (s != parseFloat(s)) return 'not a number'; 
    var x = s.indexOf('.'); 
    if (x == -1) x = s.length; 
    if (x > 15) return 'too big'; 
    var n = s.split(''); 
    var str = ''; 
    var sk = 0; 
    for (var i=0; i < x; i++) 
    {
        if ((x-i)%3==2) 
        {
            if (n[i] == '1') 
            {
                str += tn[Number(n[i+1])] + ' '; 
                i++; 
                sk=1;
            }
            else if (n[i]!=0) 
            {
                str += tw[n[i]-2] + ' ';
                sk=1;
            }
        }
        else if (n[i]!=0) 
        {
            str += dg[n[i]] +' '; 
            if ((x-i)%3==0) str += 'hundred ';
            sk=1;
        }


        if ((x-i)%3==1)
        {
            if (sk) str += th[(x-i-1)/3] + ' ';
            sk=0;
        }
    }
    if (x != s.length)
    {
        var y = s.length; 
        str += 'point '; 
        for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';
    }
    return str.replace(/\s+/g,' ');
}

window.toWords = toWords;;
</script>
