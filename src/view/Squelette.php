<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?php echo $this->title; ?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" href=<?php echo "\"".Router::DEB_URL."/src/view/css/screen.css\"" ?> />
		<?php echo $this->scriptJS ?> 
	</head>

<?php
	require_once("view/PrivateView.php");
?>

	<body>
		<nav >
			<a href=<?php echo "\"".Router::DEB_URL."/index.php\"" ?> >
				<img src=<?php echo "\"".Router::DEB_URL."/src/view/images/Logo.jpg\"" ?> class="left" alt="Logo Décrivez-moi" title="Décrivez-moi"/>
			</a>
			<ul id="menu">
			<?php
				foreach ($this->menu as $key => $value) {
					echo "<li><a href=".$key.">".$value."</a></li>";
				}
			?>
			</ul>
		</nav>
		<br/>
		<div class="feedback"><?php echo $this->feedback ; ?></div>

		<br/>
		<?php echo $this->content  ; ?>
	</body>
</html>
