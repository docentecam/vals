<?php
require('../inc/functions.php');

if(isset($_GET['acc']) && ($_GET['acc']=='l')){

	$mySqlPromotions = "SELECT p.idPromotion, p.image, date_format(p.dataExpireVals,'%d/%m/%y') as dataExpireValsE, p.oferVals, s.name FROM promotions p, shops s WHERE s.idShop = p.idShop AND p.oferVals IS NOT NULL
	AND p.dataExpireVals IS NOT NULL ORDER BY dataExpireValsE";

	$mySqlFilters= "SELECT idCategory, name, urlPicto1 FROM categories";

	$mySqlWeb = "SELECT value FROM settings WHERE literal = 'urlEix'";

	$connexio = connect();
	$resultPromotions = mysqli_query($connexio, $mySqlPromotions);
	$resultFilters = mysqli_query($connexio, $mySqlFilters);
	$resultWeb = mysqli_query($connexio, $mySqlWeb);
	disconnect($connexio);
	$dades = "[{";
	$dades.='"promotions":[';
	$i = 0;
	while ($row=mySqli_fetch_array($resultPromotions))
	{
		if($i!=0) 
		{
			$dades .= ",";
		}	
		$dades .= '{"image":"'.$row['image'].'", "idPromo":"'.$row['idPromotion'].'", "offer":"'.$row['oferVals'].'", "dataExpire":"'.$row['dataExpireValsE'].'", "nameShop":"'.$row['name'].'"}';
		$i++;
	}
	$dades .= "],";

	$dades .= '"filters":[';
	$i = 0;
	while ($row=mySqli_fetch_array($resultFilters))
	{
		if($i!=0) 
		{
			$dades .= ",";
		}	
		$dades .= '{"idCategory":"'.$row['idCategory'].'", "name":"'.$row['name'].'", "urlPicto1":"'.$row['urlPicto1'].'"}';
		$i++;
	}
	$dades .= "],";

	$dades .= '"web":[';
	$i = 0;
	while ($row=mySqli_fetch_array($resultWeb))
	{
		if($i!=0) 
		{
			$dades .= ",";
		}	
		$dades .= '{"urlWeb":"'.$row['value'].'"}';
		$i++;
	}
	$dades .= "]";

	$dades .= "}]";
	echo $dades;
}

if(isset($_GET['acc']) && ($_GET['acc']=='s')){
	$mySql = "SELECT p.idPromotion, p.image, date_format(p.dataExpireVals,'%d/%m/%y') as dataExpireVals, p.oferVals, p.conditionsVals, s.name, s.telephone, s.email, s.url, s.address, s.descriptionLong, s.logo FROM promotions p, shops s WHERE s.idShop = p.idShop AND p.idPromotion=".$_GET['idPromo']." ORDER BY p.dataExpireVals";
	$connexio = connect();
	$resultPromotion = mysqli_query($connexio, $mySql);
	disconnect($connexio);

	$dadesPromo = mySqli_fetch_row($resultPromotion);
	$dades='[{"image":"'.$dadesPromo[1].'", "idPromo":"'.$dadesPromo[0].'", "offer":"'.$dadesPromo[3].'", "dataExpire":"'.$dadesPromo[2].'", "conditions":"'.$dadesPromo[4].'", "nameShop":"'.$dadesPromo[5].'", "phone":"'.$dadesPromo[6].'", "mail":"'.$dadesPromo[7].'", "url":"'.$dadesPromo[8].'", "address":"'.$dadesPromo[9].'", "descriptionLong":"'.$dadesPromo[10].'", "logo":"'.$dadesPromo[11].'"}]';
	echo $dades;
}

if(isset($_GET['acc']) && ($_GET['acc']=='f')){
	$idCategory=$_GET['idCategory'];
	$mySql = "SELECT promotions.idPromotion, promotions.image, date_format(promotions.dataExpireVals,'%d/%m/%y') as dataExpireVals, promotions.oferVals, shops.name
	FROM categories
	LEFT JOIN categoriessub ON categoriessub.idCategory = categories.idCategory
	LEFT JOIN shopcategoriessub ON shopcategoriessub.idSubCategory = categoriessub.idSubCategory
	LEFT JOIN shops ON shopcategoriessub.idShop = shops.idShop
	LEFT JOIN promotions ON promotions.idShop = shops.idShop
	WHERE categories.idCategory =".$idCategory;

	$connexio = connect();
	$resultFilterCat = mysqli_query($connexio, $mySql);
	disconnect($connexio);

	//$dadesFilter = mySqli_fetch_row($resultFilterCat);
	$dades = "[";
	$i = 0;
	while ($row=mySqli_fetch_array($resultFilterCat))
	{
		if($i!=0) 
		{
			$dades .= ",";
		}	
		$dades .= '{"image":"'.$row['image'].'", "idPromo":"'.$row['idPromotion'].'", "offer":"'.$row['oferVals'].'", "dataExpire":"'.$row['dataExpireVals'].'", "nameShop":"'.$row['name'].'"}';
		$i++;
	}
	$dades .= "]";
	echo $dades;
}
?>