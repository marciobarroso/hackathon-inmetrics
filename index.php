<?php include "resources/data/config.php"; ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

	    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<title>Ranktoon</title>

		<link rel="shortcut icon" type="img/ico" href="resources/images/favicon/favicon.ico" />
		<link rel="apple-touch-icon" sizes="57x57" href="resources/images/favicon/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="resources/images/favicon/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="resources/images/favicon/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="resources/images/favicon/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="resources/images/favicon/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="resources/images/favicon/apple-touch-icon-120x120.png">
		<link rel="icon" type="image/png" href="resources/images/favicon/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="resources/images/favicon/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="resources/images/favicon/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="resources/images/favicon/manifest.json">
		<link rel="mask-icon" href="resources/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">

		<link rel="stylesheet" type="text/css" href="vendors/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="vendors/plugins/slick/css/slick.css">
		<link rel="stylesheet" type="text/css" href="vendors/plugins/slick/css/slick-theme.css">

		<link rel="stylesheet" type="text/css" href="resources/css/index.css">

		<!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>

		<div id="overlay">
			<form>
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-5">
						<input type="text" id="input-search" placeholder="O que você procura?" class="form-control">
					</div>
					<div class="col-md-1 form-group">
						<input id="button-search" type="button" value="Buscar" class="btn btn-primary">
					</div>
					<div class="col-md-3"></div>
				</div>
			</form>
		</div>

		<div id="map"></div>

		<div id="modal" class="modal fade" role="dialog">
		  	<div class="modal-dialog modal-lg">

				<div class="row modal-content result">
					<div class="modal-header text-center">
						<b class="title">Villa Country Club</b>
					</div>
					<div class="modal-body container-fluid">
						<div class="row">
							<div class="col-md-4 thumbnail">
								<img src="resources/images/no-image.jpg" border="0" class="img-responsive" />		
							</div>
							<div class="col-md-8 info">
								<p class="address">Rua Augusta, 123 - Consolação - SP</p>
								<p class="phone">(11) 6666 9999</p>
								<p class="website">http://www.villacountryclub.com.br</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-left">
								<h3>O que estão falando a sobre <b class="title">Villa Country Club</b> nas redes sociais</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#face">Facebook</a></li>
									<li><a data-toggle="tab" href="#twitter">Twitter</a></li>
									<li><a data-toggle="tab" href="#graphics">An&aacute;lise Gr&aacute;fica</a></li>
								</ul>
								<div class="tab-content">
									<div id="face" class="tab-pane fade in active row">
										<div class="col-md-12">
											<br />
											<p>Numero de likes: 5.000</p>
											<p>Numero de checkins: 2.000</p>
											<p>Website: www.sdassdas.com.br</p>

										</div>
									</div>

									<div id="twitter" class="tab-pane fade row">
										<div class="col-md-12">
											<br />
											<p>Usuario X</p>
											<p>msg : Muito bom</p>
											<p>Usuario X</p>
											<p>msg : Muito bom</p>
											<p>Usuario X</p>
											<p>msg : Muito bom</p>
										</div>
									</div>

									<div id="graphics" class="tab-pane fade row">
										<div class="col-md-12">
											<br />
											

										</div>
									</div>
								</div>

							</div>

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">close</button>
					</div>
				</div>

			</div>
		</div>

		<script type="text/javascript" src="vendors/jquery/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="vendors/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="vendors/plugins/slick/js/slick.min.js"></script>

		<script type="text/javascript" src="vendors/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&signed_in=true&key=<?php echo CONFIG_GOOGLE_API_KEY; ?>"></script>
		<script src="https://apis.google.com/js/client:plusone.js?key=<?php echo CONFIG_GOOGLE_API_KEY; ?>"></script>
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<script type="text/javascript" src="resources/js/main.js"></script>
		<script type="text/javascript" src="resources/js/google-api.js"></script>

	</body>
</html>