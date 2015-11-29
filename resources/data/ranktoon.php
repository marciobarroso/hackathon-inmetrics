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
		$info["ranktoon"]["description"] = "O Ranktoon é o mais novo guia de cidade para quem está a procura de uma busca rápida pelos melhores locais e serviços sendo oferecidos próximos a ele. Além deste, a aplicação servirá para publicidade de empreendimentos existentes que estão à procura de aumentar sua visibilidade no mercado e atender uma massa maior de clientes. Nossa equipe está empenhada na busca de melhorias e inovações para atender estes públicos da melhor forma possível, sempre apresentando melhores condições e uma nova perspectiva de melhorias destes serviços que possam ser implantadas em futuras atualizações.
A ideia principal, é proporcionar comodidade e confiabilidade aos usuários, que dependem de uma boa ferramenta para auxiliá-los como guia a qualquer momento de seu dia, indicando os 5 melhores locais classificados para suprir suas necessidades. As classificações serão feitas a partir de menções às publicações nas redes sociais, que manterão total integridade e veracidade dos dados trabalhados referente a cada local ou serviço pesquisado. Em mesmo plano, proporcionar aos parceiros uma nova oportunidade de investimento com excelentes planos de receita, onde, futuramente, poderão obter uma maior visibilidade de seu empreendimento na página da aplicação (independente de sua classificação dentro do ranking avaliado), uma nova cartilha de clientes e uma publicidade direta com seu público alvo.
O RankToon está disponível na plataforma web desktop e web mobile (ainda não há um app mobile, porém, será desenvolvido de forma a ser compatível com todos os sistemas operacionais existentes atualmente).";

		$info["ranktoon"]["image"] = "resources/images/ranktoon.png";
		$info["ranktoon"]["phone"] = array();
		$info["ranktoon"]["phone"][] = "+55 (11) 6666-9999";
		$info["ranktoon"]["phone"][] = "+56 (09) 6666-9999";
		$info["ranktoon"]["phone"][] = "+55 (12) 6666-9999";
		$info["ranktoon"]["phone"][] = "+55 (15) 6666-9999";

		$info["ranktoon"]["address"] = "Av. Augusta, 195 - Bela Vista - SP";
		$info["ranktoon"]["mail"] = "contato@ranktoon.com.br";
		$info["ranktoon"]["institutional"] = "O nome RANKTOON veio de uma referencia a maratona de desenvolvimento HACKATHON ­– realizado em parceria da INMETRICS S/A com a Faculdade de Informática e Administração Paulista (FIAP), realizado em 28 e 29 de Novembro de 2015 –  agregados a ideia da estruturação de um ranking classificatório dos locais, serviços e instituições existentes nas diversas cidades.
Surgimos com a primeira versão do RANKTOON no ano de 2015, visando melhorar de forma considerável a de busca por lugares, estabelecimentos e serviços existentes na cidade onde as pessoas frequentam ou visitam. Estes, são os mais mencionados nas redes sociais e nos sites de busca, tornando a pesquisa mais limpa, objetiva, com as melhores indicações e tendo uma maior relevância perante os utilizadores.
Além destes, os empreendimentos parceiros também ganham um novo meio de investimento para alcançar seus objetivos e metas de receita, tendo em mãos um novo veículo de publicidade que alavancará o conhecimento público do estabelecimento e despertará um maior interesse da população, não apenas de seu publico alvo. ";

		$info["ranktoon"]["facebook"] = array();
		$info["ranktoon"]["facebook"]["likes"] = rand(88994, 1000000);
		$info["ranktoon"]["facebook"]["checkins"] = rand(88994, 1000000);

		$info["ranktoon"]["twitter"] = array();
		$info["ranktoon"]["twitter"]["twetts"] = array();
		/*$info["ranktoon"]["twitter"]["twetts"][] = array(
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
		*/
		print(json_encode($info));
	}	