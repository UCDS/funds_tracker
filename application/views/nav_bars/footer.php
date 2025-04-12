<?php ?>

</div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
   <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>css_js/js_frameworks/jquery-3.1.0.min.js"><\/script>')</script>
    <script src="<?php echo base_url(); ?>css_js/css_frameworks/js/bootstrap.min.js"></script>  
  </body><script>
	$(function(){
	$(".sidebar").find('li').click(function(){
		$(".sidebar li").removeClass("active");
		$(this).addClass("active");
	})});
</script>
</html>
