<?php
$list = "./domainlist";
$domain = file($list, FILE_IGNORE_NEW_LINES);
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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/#">Verif.SSL</a>
        </div>
      </div>
    </nav>

<div class="container">

  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>Domaine</th>
      <th>IP</th>
      <th>Expiration du certificat</th>
    </tr>
  </thead>

    <tbody>
      <?php
			foreach($domain as $item){
        echo '<tr>';
				echo '<td>' .$item. '</td>';
				echo '<td>' .gethostbyname($item). '</td>';
				echo '<td>' .exec('echo | openssl s_client -connect '.$item.':443 2>/dev/null | openssl x509 -noout -dates | grep "After" | cut -d "=" -f2'). '</td>';
				echo '</tr>';
			}
      ?>
    </tbody>
  </table>

</div>
</body>
</html>
