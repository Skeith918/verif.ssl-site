<?php
$listdomain = "./domainlist";
$domain = file($listdomain, FILE_IGNORE_NEW_LINES);
foreach($domain as $item){
	$ip=gethostbyname($item);
	shell_exec("sudo ./.getcertinfo.sh $item $ip");
};
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Verif.SSL</title>
	<link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.min.css">
	<link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.css">

</head>

<body>

  <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
					<a class="navbar-brand" href="/">Verif.SSL</a>
        </div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a><?php echo '<td>' .date("d M Y | H:i"). '</td>';?></a></li>
					</ul>
				</div>
      </div>
    </nav>

<div class="container">

  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>Domaine</th>
      <th>IP</th>
			<th>Validité du certificat</th>
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
				$domain=exec("echo $item | awk '{print $1}'");
				$valid=exec("echo $item | awk '{print $3}'");
				$dayleft=exec("echo $item | awk '{print $7}'");
				if ($valid != "Valid"){
					$class='<tr class="danger">';
				} elseif ($dayleft < 20 ) {
					$class='<tr class="warning">';
				} else {
					$class='<tr class="active">';
				}
					echo $class;
					echo '<td><a href="https://' .$domain. '">' .$domain. '<a/></td>';
					echo '<td>' .exec("echo $item | awk '{print $2}'"). '</td>';
					echo '<td>' .$valid. '</td>';
					echo '<td>' .exec("echo $item | awk '{print $4,$5,$6}'"). '</td>';
					echo '<td>' .$dayleft. '</td>';
					echo '</tr>';
			}
      ?>
    </tbody>
  </table>

</div>
</body>
<footer>
	<p align="center"> P.O.C Made by <a href="https://github.com/Skeith918">Skeith918.</a></p>
	<p align="center"> Source Code released on <a href="https://github.com/Skeith918/verif.ssl-site">Github</a></p>
	<p align="center"> Design Powered by <a href="https://bootswatch.com/">Bootswatch</a></p>
</footer>
</html>
