			</div>
            <!-- /container -->
            
            <!-- footer -->
			<footer class="footer" role="contentinfo">
            
             <div class="container">
             
             <div class="row">
             
              <?php footer_nav(); ?>
              
              <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/access-he-logo.png" alt="Logo" class="logo-img"></a>

				<!-- copyright -->
				<p class="copyright">
					&copy; London Higher <?php echo date('Y'); ?>. AccessHE is a Division of London Higher.<br>
Company limited by guarantee, registered in England and Wales No.05731255.<br>
Registered Charity No.1114873.
				</p>
				<!-- /copyright -->
                
                </div>
                
                </div>

			</footer>
			<!-- /footer -->

		<?php wp_footer(); ?>

	</body>
</html>
