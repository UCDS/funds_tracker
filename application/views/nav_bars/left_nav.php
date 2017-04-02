<?php ?>

<style>
	.sidebar a{
		color:#062a48 !important;
	}
</style>
	
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li ><a>Transaction</a>
			<ul class="nav nav-sidebar" style="margin-left: 20px;">
			  <li id="LefNaveBankBook"><a href="<?php echo base_url(); ?>bank_account/bank_book_summary">Bank Book</a></li>
		  </ul>
	  </li>
	</ul>
	
    <ul class="nav nav-sidebar">
		<li ><a>Reports</a>
			<ul class="nav nav-sidebar" style="margin-left: 20px;">
			  <li id="LefNavePartyReport"><a href="<?php echo base_url(); ?>report/party">Bank</a></li>
			  <li id="LefNaveLedgerReport"><a href="<?php echo base_url(); ?>report/ledger">Ledger</a></li>
		  </ul>
	  </li>
    </ul>
	
    <ul class="nav nav-sidebar">
		<li ><a>Masters</a>
			<ul class="nav nav-sidebar" style="margin-left: 20px;">
				<?php if($this->session->logged_in == 'YES'){ ?> 
					<li id="LefNaveParty"><a href="<?php echo base_url(); ?>party">Party</a></li>
					<li id="LefNaveBank"><a href="<?php echo base_url(); ?>bank">Bank</a></li>
				<?php } ?>
				<li id="LefNaveBankAct"><a href="<?php echo base_url(); ?>bank_account"><i class="fa fa-address-book" aria-hidden="true"></i>Bank Account</a></li>
				<?php if($this->session->logged_in == 'YES'){ ?>	
					<li id="LefNaveChequeBook"><a href="<?php echo base_url(); ?>cheque_book">Cheque Book</a></li>
					<li id="LefNaveChequeLeaf"><a href="<?php echo base_url(); ?>cheque_leaf">Cheque Leaf</a></li>
					<li id="LefNaveInstrumentType"><a href="<?php echo base_url(); ?>instrument_type">Instrument Type</a></li>
					
					<li id=""><a>Ledger Account</a></li>
					<li id=""><a>Sub Account</a></li>
					<li id=""><a>Item</a></li>
					
					<li id="LefNaveProject"><a href="<?php echo base_url(); ?>project">Project </a></li>
				<?php } ?>
			</ul>
	  </li>
    </ul>
	<!--
    <ul class="nav nav-sidebar">
      <li id="LefNaveLogOut"><a href="<?php echo base_url(); ?>welcome/logout">Logout</a></li>
    </ul>
	-->
</div>
