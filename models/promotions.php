<?php
require('../inc/functions.php');

if(isset($_GET['acc']) && $_GET['acc']=='l'){

	$mySql = "SELECT p.idPromotion, p.image, date_format(p.dataExpireVals,'%d/%m/%y') as dataExpireVals, p.oferVals, s.name FROM promotions p, shops s WHERE s.idShop = p.idShop";

	$connexio = connect();
	$resultPromotions = mysqli_query($connexio, $mySql);
	disconnect($connexio);
	$dades = "[";
	$i = 0;

	while ($row=mysqli_fetch_array($resultPromotions) )
	{
		if($i!=0) $dades .= ",";
		$dades .= '{"image":"'.$row['image'].'", "idPromo":"'.$row['idPromotion'].'", "offer":"'.$row['oferVals'].'", "dataExpire":"'.$row['dataExpireVals'].'", "nameShop":"'.$row['name'].'"}';
		$i++;
	}
	$dades .= "]";
	echo $dades;
}

?>