<?php 
	
	
	require("functions.php");
	
	require("Pillid.class.php");
	$Pillid = new Pillid($mysqli);
	
	
	if (isset($_GET["q"]) && $_GET["q"]!=""){
		
		if(isset($_GET["sort"])){
			
			$sort = $_GET["sort"];
		}else{
			$sort = "ASC";
			
		}
			if(isset($_GET["order"])){
			
			$order = $_GET["order"];
		}else{
			$order = "age";
			
		}$instrumentData = $Pillid->get($_GET["q"],$sort,$order);
		
		
		
		
	}else{$instrumentData = getAllInstruments();
		
		
	};
	
	 	

	
	
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		
	}
	
	//kui on ?logout aadressireal siis login v�lja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		
	}
	
	$msg = "";
	if(isset($_SESSION["message"])) {
		
		$msg = $_SESSION["message"];
		
		//kustutan �ra, et p�rast ei n�itaks
		unset($_SESSION["message"]);
	}
	
		
 	//kas otsib
 	if(isset($_GET["q"])){
 		
 		// kui otsib, v�tame otsis�na aadressirealt
 		$q = $_GET["q"];
 		
 	}else{
 		
 		// otsis�na t�hi
 		$q = "";
 	}
 	
	
 	

	
 	//otsis�na fn sisse
 	$PillidData = $Pillid->get($q, $sort, $order);
	
?>


<h1>Leia endale parim b�ndikaaslane!</h1>
</p>

		Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?>!</a>
		<a href="?logout=1">Logi v�lja</a>
		<br><br>
		Leht t�ieneb jooksvalt, vabandame ebamugavuste p�rast!
		<br><br>
<form>
	
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">

</form>
<?php


$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>age</th>";
		$html .= "<th>gender</th>";
		$html .= "<th>instrument</th>";
	$html .= "</tr>";

	//iga liikme kohta massiivis
	foreach($instrumentData as $c){
		// iga kasutaja on $c
		//echo $c->age."<br>";
		
		$html .= "<tr>";
			//$html .= "<td>".$c->age."</td>";
			//$html .= "<td>".$c->gender."</td>";
					$html .= "<td>".$c->instrument."</td>";
			
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	
 		$ageOrder = "ASC";
 		$arrow = "&darr;";
 		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
 			$ageOrder = "DESC";
 			$arrow = "&uarr;";
 		}
 	
 	$html .= "<th>
 					<a href='?q=".$q."&sort=age&order=".$ageOrder."'>
 						age ".$arrow."
 					</a>
 				 </th>";
 				 
 				 
 		$instrumentOrder = "ASC";
 		$arrow = "&darr;";
 		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
 			$instrumentOrder = "DESC";
 			$arrow = "&uarr;";
 		}
 		$html .= "<th>
 					<a href='?q=".$q."&sort=instrument&order=".$instrumentOrder."'>
 						instrument
 					</a>
 				 </th>";
  	$html .= "</tr>";
	
	
	
?>
</body>
</html>



