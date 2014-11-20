<?php
    header('Content-Type: text/html; charset=utf-8');
    if (!empty($_POST["data"])) {
	file_put_contents("/www/pozsi.com/gallery/admin/galleries/".$_POST["name"].".txt", $_POST["data"]);
	$items = explode("\n", $_POST["data"]);
	$i = 0;
	foreach($items as $item) {
	    $i++;
	    $item = explode(" ", $item, 3);
	    ob_start();
	    include("template.html");
	    $content = ob_get_clean();
	    mkdir("/www/pozsi.com/gallery/".$_POST["name"]."/");
	    if ($i==1) { $name = "index"; } else { $name = $i; }
	    file_put_contents("/www/pozsi.com/gallery/".$_POST["name"]."/".$name.".html", $content);
	}
	$show_result = true;
    } else {
	$show_result = false;
    }
    if (empty($_POST["data"]) && !empty($_GET["gal"])) {
	$_POST["name"] = $_GET["gal"];
	$_POST["data"] = file_get_contents("/www/pozsi.com/gallery/admin/galleries/".$_GET["gal"].".txt");
    }
    include("/www/pozsi.com/gallery/admin/form.php");
    if ($show_result) {
?>
Elkeszult: <a href="http://pozsi.com/gallery/<?= $_POST["name"] ?>" target="_blank"><?= $_POST["name"] ?></a><br />
<a href="http://pozsi.com/gallery/admin/">Regiek</a>
<?php } else {
	if ($handle = opendir('/www/pozsi.com/gallery/admin/galleries/')) {
	    while (false !== ($entry = readdir($handle))) {
    		if ($entry != "." && $entry != "..") {
		    $parts = explode(".", $entry, 2);
		    $name = $parts[0];
?>
    <a href="?gal=<?= $name ?>"><?= $name ?></a><br />
<?php
		}
	    }
	    closedir($handle);
	}
    }
?>