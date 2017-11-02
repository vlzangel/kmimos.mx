<?php  

require_once("../vlz_config.php");
global $host, $user, $db, $pass, $url_base;

// Validar si existe referencia de usuario
$hidden = "";
$email = '';

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Prueba MAiling</title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/kmimos.css">

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-56422840-1', 'auto');
		  ga('send', 'pageview');
		</script>

	</head>
	<body  class="container">

		<div  class="col-md-offset-1">
			
			<section class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="z-index:9999!important;">

				<footer class="text-center">
					<div id='footer-content' class="col-md-12">
						<h2>Prueba de Email Mailing</h2>
						<form id="frm">
							<div class="<?php echo $hidden; ?>">
								<input type="hidden" id="referencia" name="referencia" class="form-control" value="<?php echo $referencia; ?>">
								<input type="email"  id="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="Correo electr&oacute;nico" required>
							</div>
							<button type="button" id="send" class="btn-kmimos btn">Enviar</button>
							<span id="msg" style="padding-top:3px;color:#fff;"></span>
						</form>
						<!-- <form action="compartir/?e=" method="post" id="temp"></form> -->
					</div>
				</footer>

			</section>

		</div>
		<script
		  src="https://code.jquery.com/jquery-2.2.4.min.js?<?php echo time(); ?>"
		  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
		  crossorigin="anonymous">  
		</script>		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script type="text/javascript">
			$(function(){
				var url = "<?php echo $url_base; ?>";
				
				$('#frm').on('submit', function(e){
				  e.preventDefault(e);
				  _registerLanding();
				});

				$('#send').on('click', function(e){
				  _registerLanding();
				});

				$("input").change(function(){
				  if( $(this).val() != "" ){
				    $('msg').html("");
				  }
				});

				function _registerLanding(){

					  if( $('#email').val() == "" || $('#name').val() == "" ){
					    $('#msg').html('Debe completar los datos');
					    return;
					  }else{
					  	$('#loading').removeClass('hidden');
					  	$('#msg').html('Enviando email.');
					  	var mail= $('#email').val();
					  	alert(mail);
					  	var email = {'email': mail}
					  	var result = getGlobalData("mailing.php",'POST', email );  
					  	result = getGlobalData("mailing1.php",'POST', email );  
					  	result = getGlobalData("mailing2.php",'POST', email );  
					  	alert(result);
					  }
					  
				}

				function getGlobalData(url,method, datos){
					return $.ajax({
						data: datos,
						type: method,
						url: url,
						async:false,
						success: function(data){
				            //alert(data);
				            // $("#guardando").css('color','#fff');
							return data;
						}
					}).responseText;
				}
			});
		</script>
	</body>
</html>