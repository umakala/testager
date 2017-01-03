<!DOCTYPE html>

<html lang="en">
<head>
	<title>Newstand Portal</title>
	<meta http-equiv="pragma" content="no-cache">
	<!-- style sheets -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/base.css')}}">	
</head>

<body>
	<div class="col-sm-12">		
			<div class="row">
				<div class="col-lg-9 col-sm-12">
					<div class="dynTemplate" >
						<div id="loginTemplate">
							<div class="loginContainer">
								<h2 style="text-align: center"></h2>
								<?php echo $msg; ?>
							</div>
						</div>
					</div>
				</div>                
			</div>
		</div>
	</body>
	</html>