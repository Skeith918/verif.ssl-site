<?php
exec('/var/www/verif.ssl-site/.deploy.sh');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<link rel="shortcut icon" href="http:/\/verif-site.ssl/.sign-check.ico" width="16" height="16">
	<title>Verif.SSL</title>
	<link rel="stylesheet" href="https:/\/cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css" />
	<link rel="stylesheet" href="https:/\/cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.css" />
	<link rel="stylesheet" href="https:/\/cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css" />
	<script src="https:/\/cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https:/\/cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
	<script src="https:/\/cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.js"></script>
	<script src="https:/\/cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/components/search.js"></script>
	<script src="https:/\/cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https:/\/cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
</head>
<body>
	<div class="ui fixed inverted menu">
	<div class="ui container">
	<a href="/" class="header item"><img class="logo" src="http:/\/verif-site.ssl/.sign-check.ico" width="32" height="32">Verif.SSL</a>
	<div class="fixed right item">
		<div id="date_heure">
			<script type="text/javascript">
				function compZero(nombre) {
					return nombre < 10 ? '0' + nombre : nombre;
				}
				function date_heure() {
					const infos = new Date();
					const mois = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
					const jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
					document.getElementById('date_heure').innerHTML = jours[infos.getDay()] + ' ' + infos.getDate() + ' ' + mois[infos.getMonth()] + ' ' + infos.getFullYear() + ' | ';
					document.getElementById('date_heure').innerHTML += compZero(infos.getHours()) + ' : ' + compZero(infos.getMinutes()) + ' : ' + compZero(infos.getSeconds());
				}
				window.onload = function() {
					setInterval("date_heure()", 1000); //Actualisation de l'heure
				};
			</script>
		</div>
		<!--<a><?php echo date("d M Y | H:i");?></a>-->
	</div>
	</div>
	</div>

	<div class="ui one column stackable center aligned page grid">
		<div class="column twenty wide">
			</br></br>
				<h1 class="ui header" align="center"><strong>LE VÉRIFICATEUR DE VALIDITÉ DE CERTIFICAT SSL</strong></h1>
				<div class="ui message info">
					<p>Cette page statique est générée automatiquement à partir des domaines renseignés dans le fichier dédié et ceux chaques requêtes sur celle-ci.</p>
					<p>Elle renseigne la validité des certificats SSL mais aussi leurs date d'expiration ainsi que le nombre de jours restants avant celle-ci.</p>
				</div>
	<?php
		echo '<form method="post" action="index.php">
		<button class="ui blue active button">Rafraîchir la page</button>
		</form>';
	?>
        <table id="mainTable" class="ui celled table">
	<thead>
		<tr>
			<th class="center aligned">Nom de Domaine</th>
			<th class="center aligned">Addresse IP / CNAME</th>
			<th class="center aligned">Statut du certificat</th>
			<th class="center aligned">Date d'expiration</th>
			<th class="center aligned">Jours Restants</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$listcert = "./.certinfo";
			$cert = file($listcert, FILE_IGNORE_NEW_LINES);
			foreach($cert as $item){
				$class;
				$icn='';
				$domain=exec("echo $item | awk '{print $1}'");
				$valid=exec("echo $item | awk '{print $3}'");
				$dayleft=exec("echo $item | awk '{print $7}'");
				if ( ($valid != "Valid") && ($dayleft < 0) ){
					$class='<tr class="negative">';
					$icn='<i class="attention icon"></i>';
					$tdvalid='Expiré';
				} elseif ($dayleft < 20 ) {
					$class='<tr class="warning">';
					$icn='<i class="attention icon"></i>';
					$tdvalid='Expiration imminente';
				} else {
					$class='<tr class="active">';
					$tdvalid='Valide';
				}
					echo $class;
					echo '<td><a href="https://' .$domain. '">' .$domain. '<a/></td>';
					echo '<td>' .exec("echo $item | awk '{print $2}'"). '</td>';
					echo '<td class="center aligned">' .$icn. '' .$tdvalid. '</td>';
					echo '<td class="center aligned">' .exec("echo $item | awk '{print $4,$5,$6}'"). '</td>';
					echo '<td class="center aligned">' .$icn. '' .$dayleft. '</td>';
					echo '</tr>';
			}
		?>
	</tbody>
	</table>
	</br>
	<div class="ui one column stackable center aligned page grid">
		<script>
		$(document).ready(function() {
    			$('#mainTable').DataTable({
				"order": [[ 4, "asc" ]],
				"pageLength": 50,
				"language": {
			            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
				}
			});
		});
		</script>
		<button class="ui blue active button" onclick="topFunction()" id="topBtn" title="Go to top">Retour en haut de la page</button>
	</div>
	</div>
	</div>
</body>
</br>
</br>
<div class="ui inverted vertical footer segment">
  <div class="ui container">
		<footer>
			<p align="center"> Fait par <a href="https://github.com/Skeith918">Skeith918.</a></p>
			<p align="center"> Le code source est disponible <a href="https://github.com/Skeith918/verif.ssl-site">Github</a></p>
			<p align="center"> L'API <a href="https://github.com/Skeith918/verif.ssl-site">Qualys SSL Labs</a> est utilisée pour calculer les notes SSL.</p>
			<p align="center"> Design généré avec <a href="https://semantic-ui.com/">Semantic UI</a></p>
		</footer>
	</div>
</div>
</html>
<script>

// When the user scrolls down 20px from the top of the document, show the button

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("topBtn").style.display = "block";
  } else {
    document.getElementById("topBtn").style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
