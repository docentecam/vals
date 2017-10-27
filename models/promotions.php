<?php
require('../inc/functions.php');

if(isset($_GET['acc']) && ($_GET['acc']=='l')){

	$mySql = "SELECT p.idPromotion, p.image, date_format(p.dataExpireVals,'%d/%m/%y') as dataExpireVals, p.oferVals, s.name FROM promotions p, shops s WHERE s.idShop = p.idShop ORDER BY p.dataExpireVals";

	$connexio = connect();
	$resultPromotions = mysqli_query($connexio, $mySql);
	disconnect($connexio);
	$i = 0;
	$dades = "[";

	while ($row=mySqli_fetch_array($resultPromotions))
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

if(isset($_GET['acc']) && ($_GET['acc']=='s')){
	$mySql = "SELECT p.idPromotion, p.image, date_format(p.dataExpireVals,'%d/%m/%y') as dataExpireVals, p.oferVals, p.conditionsVals, s.name, s.telephone, s.email, s.url, s.address, s.descriptionLong, s.logo FROM promotions p, shops s WHERE s.idShop = p.idShop AND p.idPromotion=".$_GET['idPromo']." ORDER BY p.dataExpireVals";
	$connexio = connect();
	$resultPromotion = mysqli_query($connexio, $mySql);
	disconnect($connexio);

	$dadesPromo = mySqli_fetch_row($resultPromotion);
	$dades='[{"image":"'.$dadesPromo[1].'", "idPromo":"'.$dadesPromo[0].'", "offer":"'.$dadesPromo[3].'", "dataExpire":"'.$dadesPromo[2].'", "conditions":"'.$dadesPromo[4].'", "nameShop":"'.$dadesPromo[5].'", "phone":"'.$dadesPromo[6].'", "mail":"'.$dadesPromo[7].'", "url":"'.$dadesPromo[8].'", "address":"'.$dadesPromo[9].'", "descriptionLong":"'.$dadesPromo[10].'", "logo":"'.$dadesPromo[11].'"}]';
	echo $dades;
}
?>