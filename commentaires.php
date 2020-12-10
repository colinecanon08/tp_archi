<!doctype html> 
<html>
	<head> 
		<meta charset="utf-8">
	</head> 
	<body>
		<form method="POST">
			<input type="text" name="nom" placeholder="Nom"><br>
			<textarea name="commentaire" placeholder="Commentaire"></textarea><br>
			<input type="submit" value="Envoyer" name="envoyer">
		</form>
		<?php
			$lien=mysqli_connect("localhost","root","root","tp");
			if(isset($_REQUEST['envoyer']))
			{
				$nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
				$commentaire=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['commentaire'])));
				$page=$_REQUEST['page'];
				$req="INSERT INTO commentaire VALUES (NULL,'$nom','$commentaire','$page')";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL:$req<br>".mysqli_error($lien);
				}
			}
			
			if(!isset($_GET['page']))
			{
				$page=1;
			}
			else
			{
				$page=$_GET['page'];
			}
			$commparpage=5;
			$premiercomm=$commparpage*($page);
			//LIMIT $premiercomm,$commparpage
			$req="SELECT * FROM commentaire WHERE page=$page ORDER BY id_commentaire ";/* LIMIT dit ou je commence et combien j'en prends*/
			print($req);
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				while($tableau=mysqli_fetch_array($res))
				{
					echo "<h2>".$tableau['nom']."</h2>";
					echo "<p>".$tableau['commentaire']."</p>";
					echo "<p>".$tableau['page']."</p>";
				}
			}
			
			$req="SELECT id_commentaire FROM commentaire";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				$nbcomm=mysqli_num_rows($res); // Retourne le nombre de lignes dans un r�sultat. 
				$nbpages=ceil($nbcomm/$commparpage); /*Ceil arrondit a l'entier sup�rieur*/
				echo "<br> Pages : ";
				echo "<a href='commentaires.php?page=0'> Début </a>";
				if($page != 0){
					echo "<a href='commentaires.php?page=".($page-1)."'> Précédente </a>";
				}

				for($i=($page);$i<=($page+3);$i++)
				{
					echo "<a href='commentaires.php?page=$i'> $i </a>";
				}
			}
			echo "<a href='commentaires.php?page=".($page +1)."'> Suivante </a>";
			echo "<a href='commentaires.php?page=".($nbpages)."'> Fin </a>";

			mysqli_close($lien);
		?>	
	</body>
</html>