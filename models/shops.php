<?php
require('../inc/functions.php');

		// if(isset($_GET['acc']) && $_GET['acc'] == 'l')
		// {
		// 	$idUser = $_GET['idUser'];
		// 	if($idUser>4)
		// 	{
		// 		$idUser = 1;
		// 	}
		// 	$mySql= "SELECT idShop, name
		// 			FROM shops
		// 			WHERE idUser=".$_GET['idUser'];
					

		// 	$connexio = connect();

		// 	$resultShops = mysqli_query($connexio, $mySql);

		// 	disconnect($connexio);

		// 	$dataShops = "[";
		// 	$i = 0;
		// 	while($row = mysqli_fetch_array($resultShops))
		// 	{
		// 		if($i != 0)
		// 		{
		// 			$dataShops .= ",";
		// 		}
		// 		$dataShops .= '{"idShop":"'.$row['idShop'].'", "name":"'.$row['name'].'", "pictograms":';
				
		// 		$urlPicto = "c.urlPicto".$idUser;
		// 		$mySql=	"SELECT distinct(".$urlPicto.") AS picto
		// 				FROM categories c, categoriessub cs, shopcategoriessub scs
		// 				WHERE cs.idSubCategory = scs.idSubCategory
		// 				AND c.idCategory = cs.idCategory
		// 				AND scs.preferred = 'Y'
		// 				AND scs.idShop = ".$row['idShop'];
						
		// 		$connexio = connect();
		// 		$resultPictos = mysqli_query($connexio, $mySql);
		// 		disconnect($connexio);
		// 		$dataShops .= "[";
		// 		$j = 0;
		// 		while($row = mysqli_fetch_array($resultPictos))
		// 		{
		// 			if($j != 0)
		// 			{
		// 				$dataShops .= ",";
		// 			}
		// 			$dataShops .= '{"urlPicto":"'.$row['picto'].'"}';
					
					
		// 			$j++;
		// 		}
			
		// 		$dataShops .=']}'; 
		// 		$i++;
		// 	}
		// 	$dataShops .= "]";

		// 	echo $dataShops;
		// }
	
		if(isset($_GET['acc']) && $_GET['acc'] == 'shop')
		{


			function parseToXML($htmlStr)
			  {
			    $xmlStr=str_replace('<','&lt;',$htmlStr);
			    $xmlStr=str_replace('>','&gt;',$xmlStr);
			    $xmlStr=str_replace('"','&quot;',$xmlStr);
			    $xmlStr=str_replace("'",'&#39;',$xmlStr);
			    $xmlStr=str_replace("&",'&amp;',$xmlStr);
			    return $xmlStr;
			  }

			$mySql = "SELECT s.idShop, s.name, s.lat, s.lng, s.telephone, s.email, s.schedule, s.address, s.logo, cs.idSubCategory, cs.name AS NameSubCategoria, c.idCategory, c.name AS NameCategoria, u.name AS NameAssociacio, scs.preferred FROM shops s, shopcategoriessub scs, categoriessub cs, categories c, users u WHERE s.idUser = u.idUser AND s.idShop = scs.idShop AND scs.idSubCategory = cs.idSubCategory AND cs.idCategory = c.idCategory AND scs.preferred = 'Y'";

			if(isset($_GET['idShop']))
			{
				$mySql .= "AND s.idShop=".$_GET['idShop'];
			}

			$connexio = connect();
			$result = mysqli_query($connexio, $mySql);
			mysqli_close($connexio);

			header("Content-type: text/xml");
			$fp=fopen("../files/shop.xml",'w');
			fputs($fp,'<markers>');
			while($row = mysqli_fetch_array($result)){
				fputs($fp,'<marker ');
			    fputs($fp,'idShop="' . parseToXML($row['idShop']) . '" ');
			    fputs($fp,'idCategory="' . parseToXML($row['idCategory']) . '" ');
			    fputs($fp,'idSubCategory="' . parseToXML($row['idSubCategory']) . '" ');
			    fputs($fp,'name="' . parseToXML($row['name']) . '" ');
			    fputs($fp,'address="' . parseToXML($row['address']) . '" ');
			    fputs($fp,'lat="' . $row['lat'] . '" ');
			    fputs($fp,'lng="' . $row['lng'] . '" ');
			    fputs($fp,'nameCategoria="' . parseToXML($row['NameCategoria']) . '" ');
			    fputs($fp,'nameSubCategoria="' . parseToXML($row['NameSubCategoria']) . '" ');
			    fputs($fp,'nameAssociacio="' . parseToXML($row['NameAssociacio']) . '" ');
			    fputs($fp,'telephone="' . parseToXML($row['telephone']) . '" ');
			    fputs($fp,'email="' . parseToXML($row['email']) . '" ');
			    fputs($fp,'schedule="' . parseToXML($row['schedule']) . '" ');
			    fputs($fp,'logo="' . parseToXML($row['logo']) . '" ');
			    fputs($fp,'preferred="' . parseToXML($row['preferred']) . '" ');
			    fputs($fp,'/>');
			  }
			fputs($fp,'</markers>');
			fclose($fp);

			$idShop=$_GET['idShop'];
			$mySql= "SELECT s.idShop, s.name AS NameShop, s.address, s.cp, s.ciutat, s.telephone, s.descriptionLong, s.schedule, s.logo, s.email, s.userWhatsapp, s.userFacebook, s.userTwitter, s.userInstagram,
					u.name AS NameAssociacio, u.footer AS LogoAssociacio, c.name AS NameCategory, cs.name AS NameSubCategory, si.url AS ImagePreferred
					FROM shops s, users u, categories c, categoriessub cs, shopcategoriessub scs, shopsimages si
					WHERE u.idUser = s.idUser
					AND scs.idShop = s.idShop
					AND cs.idSubCategory = scs.idSubCategory
					AND c.idCategory = cs.idCategory
					AND scs.preferred = 'Y'
					AND si.preferred = 'Y'
					AND si.idShop = s.idShop
					AND s.idShop = $idShop";
					
			$connexio = connect();
			$resultShops = mysqli_query($connexio, $mySql);
			disconnect($connexio);

			$i = 0;
			$dataShops = "[";
			while($row = mysqli_fetch_array($resultShops))
			{
				if($i != 0) $dataShops .= ",";
				$dataShops .= '{"nameShop":"'.replaceFromBBDD($row['NameShop']).'", "idShop":"'.$row['idShop'].'", "telephone":"'.$row['telephone'].'", "cp":"'.$row['cp'].'", "schedule":"'.replaceFromBBDD($row['schedule']).'", "address":"'.replaceFromBBDD($row['address']).'", "ciutat":"'.replaceFromBBDD($row['ciutat']).'", "descriptionLong":"'.replaceFromBBDD($row['descriptionLong']).'", "logo":"'.$row['logo'].'", "email":"'.replaceFromBBDD($row['email']).'", "userWa":"'.$row['userWhatsapp'].'", "userFb":"'.replaceFromBBDD($row['userFacebook']).'", "userTt":"'.replaceFromBBDD($row['userTwitter']).'", "userIg":"'.replaceFromBBDD($row['userInstagram']).'", "nameCategory":"'.$row['NameCategory'].'", "nameAssociacio":"'.$row['NameAssociacio'].'", "logoAssociacio":"'.$row['LogoAssociacio'].'", "nameSubCategory":"'.$row['NameSubCategory'].'", "imagePref":"'.$row['ImagePreferred'].'", "imgUrl":';
				$j = 0;
				$dataShops .= '[';
				$mySql = "SELECT si.url FROM shopsimages si WHERE si.preferred = 'N' AND si.idShop =".$idShop;
				$connexio = connect();
				$resultImgShops = mysqli_query($connexio, $mySql);
				disconnect($connexio);
				while($row=mysqli_fetch_array($resultImgShops))
				{
					if($j != 0) $dataShops .= ",";
					$dataShops .= '{"url":"'.$row['url'].'"}';
					$j++;
				}
				$dataShops .= ']}';
				$i++;
			}
			$dataShops .= "]";
			echo $dataShops;
		}

?>