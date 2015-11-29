<?php

	include "config.php";

	// all responses must be an JSON
	header('Content-Type: text/json');

	$action = getParameter($_GET, "action");
	if( $action !== null ) {
		switch( $action ) {
			case "info":
				info();
				break;
		}
	}

	function info() {
		$info = array();
		$info["ranktoon"] = array();
		$info["ranktoon"]["status"] = "OK";
		$info["ranktoon"]["name"] = "Ranktoon";
		$info["ranktoon"]["description"] = "bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla ";

		$info["ranktoon"]["image"] = "resources/images/ranktoon.png";
		$info["ranktoon"]["phone"] = array();
		$info["ranktoon"]["phone"][] = "+55 (11) 6666-9999";
		$info["ranktoon"]["phone"][] = "+56 (09) 6666-9999";
		$info["ranktoon"]["phone"][] = "+55 (12) 6666-9999";
		$info["ranktoon"]["phone"][] = "+55 (15) 6666-9999";

		$info["ranktoon"]["address"] = "Av. Augusta, 195 - Bela Vista - SP";
		$info["ranktoon"]["mail"] = "contato@ranktoon.com.br";
		$info["ranktoon"]["institutional"] = "bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla ";

		$info["ranktoon"]["facebook"] = array();
		$info["ranktoon"]["facebook"]["likes"] = rand(88994, 1000000);
		$info["ranktoon"]["facebook"]["checkins"] = rand(88994, 1000000);

		$info["ranktoon"]["twitter"] = array();
		$info["ranktoon"]["twitter"]["twetts"] = array();
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);
		$info["ranktoon"]["twitter"]["twetts"][] = array(
			"user" => "@rodox_do_LOL",
			"name" => "Rodolfo Arantes do Nascimento",
			"message" => "Do caraio esse LoLzinho",
			"picture" => "resources/images/twitter_profile.png"
		);

		print(json_encode($info));
	}	