<div class="comments">
	<div id="respond" class="comment-respond golden-forms">
		<h3 id="reply-title" class="comment-reply-title">
			Deja un comentario
		</h3>				
		<form action="<?php echo get_home_url(); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form golden-forms">
			<p class="comment-notes"><span id="email-notes">Tu dirección de correo electrónico no será publicada.</span> Los campos necesarios están marcados <span class="required">*</span></p>
			<section>
	            <label class="lbl-ui">
	            	<textarea id="comment" name="comment" class="textarea" placeholder="Tu comentario" required></textarea>
	            </label>                          
	        </section>
			<section>
	            <label class="lbl-ui">
	            	<div class="g-recaptcha" data-sitekey="6LeQPysUAAAAAKKvSp_e-dXSj9cUK2izOe9vGnfC"></div>
	            </label>                          
	        </section>
		
			<section>
	       		<div class="row">
	            	<div class="col6 first">
	                   
	                    <label class="lbl-ui">
	                    	<input type="text" name="author" id="author" class="input" placeholder="Nombre*" aria-required="true" required>
	                    </label>
	                </div>
	                <div class="col6 last colspacer-two">
	                    
	                    <label class="lbl-ui">
	                    	<input type="email" name="email" id="email" class="input" placeholder="Dirección de correo*" aria-required="true" required>
	                    </label>
	                </div>
	            </div>                       
	        </section> 
			
			<p class="form-submit">
				<input name="submit" type="submit" id="submit" class="submit button" value="Publicar comentario">
				<input type="hidden" name="comment_post_ID" value="<?php echo get_the_ID(); ?>" id="comment_post_ID">
				<input type="hidden" name="comment_parent" id="comment_parent" value="0">
			</p>				
		</form>
	</div>
</div>
<script type="text/javascript">
	jQuery("#commentform").submit(function(e){

		if( jQuery("#g-recaptcha-response").val() == "" ){
			event.preventDefault();
			alert( "Debes validar el CAPTCHA para continuar." );
		}

	});
</script>
    