<?php
$listdomain = "./domainlist";
$domain = file($listdomain, FILE_IGNORE_NEW_LINES);
foreach($domain as $item){
	$domain=exec("echo $item | awk '{print $1}'");
	$ip=gethostbyname($domain);
	shell_exec("sudo ./.getcertinfo.sh $domain $ip");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<link rel="shortcut icon" href="http://www.iconarchive.com/download/i103471/paomedia/small-n-flat/sign-check.ico" width="16" height="16">
	<title>Verif.SSL</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.js"></script>

</head>

<body>
	<div class="ui fixed inverted menu">
    <div class="ui container">
      <a href="/" class="header item">
        <img class="logo" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/128/sign-check-icon.png" width="32" height="32">
        Verif.SSL
      </a>
			<div class="right item">
				<a><?php echo date("d M Y | H:i");?></a>
			</div>
		</div>
  </div>

<div class="ui one column stackable center aligned page grid">
	<div class="column twenty wide">
	</br></br>

	<h1 class="ui header" align="center"><strong>LE VÉRIFICATEUR DE VALIDITÉ DE CERTIFICAT SSL</strong></h1>

<div class="ui info message">Cette page statique est générée automatiquement à partir des domaines renseignés dans le fichier dédié et ceux chaques requêtes sur celle-ci.Elle renseigne la validité des certificats SSL mais aussi leurs date d'expiration ainsi que le nombre de jours restants avant celle-ci.
  </div>

  <table class="ui celled table segment">
  <thead>
    <tr>
      <th>Domaine</th>
      <th>IP</th>
			<th>Validité du certificat</th>
			<th>Note SSL</th>
      <th>Date d'expiration du certificat</th>
			<th>Jours Restants</th>
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
				$grade=exec("echo $item | awk '{print $8}'");
				if ($valid != "Valid"){
					$class='<tr class="negative">';
					$icn='<i class="attention icon"></i>';
				} elseif ($dayleft < 20 ) {
					$class='<tr class="warning">';
					$icn='<i class="attention icon"></i>';
				} else {
					$class='<tr class="active">';
				}
					echo $class;
					echo '<td><a href="https://' .$domain. '">' .$domain. '<a/></td>';
					echo '<td>' .exec("echo $item | awk '{print $2}'"). '</td>';
					echo '<td>' .$icn. '' .$valid. '</td>';
					echo '<td><a href="https://www.ssllabs.com/ssltest/analyze.html?d=' .$domain. '&latest">' .$grade. '<a/></td>';
					echo '<td>' .exec("echo $item | awk '{print $4,$5,$6}'"). '</td>';
					echo '<td>' .$icn. '' .$dayleft. '</td>';
					echo '</tr>';
			}
      ?>
    </tbody>
  </table>
 </div>
</div>
</body>
</br></br>
<div class="ui inverted vertical footer segment">
  <div class="ui container">
		<footer>
			<p align="center"> P.O.C Made by <a href="https://github.com/Skeith918">Skeith918.</a></p>
			<p align="center"> Source Code released on <a href="https://github.com/Skeith918/verif.ssl-site">Github</a></p>
			<p align="center"> Design Powered by <a href="https://semantic-ui.com/">Semantic UI</a> CDN</p>
		</footer>
	</div>
</div>
</html>
