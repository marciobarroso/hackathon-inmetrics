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
					<div class="col-md-3 col-sm-3 col-lg-4 col-xs-3"></div>
					<div class="col-md-5 col-sm-5 col-lg-3 col-xs-5">
						<input type="text" id="input-search" placeholder="O que você procura?" class="form-control">
					</div>
					<div class="col-md-1 col-sm-1 col-lg-1 col-xs-1 form-group">
						<input id="button-search" type="button" value="Buscar" class="btn btn-primary">
					</div>
					<div class="col-md-3 col-sm-3 col-lg-4 col-xs-3"></div>
				</div>
			</form>
		</div>

		<div id="map"></div>

		<div id="modal" class="modal fade" role="dialog">
		  	<div class="modal-dialog modal-lg">

				<div class="row modal-content result">
					<div class="modal-header text-center bg-primary">
						<b class="title"></b>
					</div>
					<div class="modal-body container-fluid">
						
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
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<script type="text/javascript" src="resources/js/main.js"></script>
		<script type="text/javascript" src="resources/js/google-api.js"></script>
		<script type="text/javascript" src="resources/js/facebook-api.js"></script>
		<script type="text/javascript" src="resources/js/twitter-api.js"></script>

	</body>
</html>