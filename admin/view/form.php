<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Galeria Admin</title>
</head>

    <body id="index" class="home" style="padding-right: 8px;">
        <form action="?op=save" method="post">
            <label for="gallery_name">Név: </label>
            <input id="gallery_name" type="text" name="name" value="<?= isset($name) ? $name : '' ?>" /><br />
            <label for="gallery_data">Adat: </label>
            <textarea id="gallery_data" name="data" rows="30" style="width: 100%;">
<?= isset($data) ? $data : '' ?>
            </textarea><br />
            <input type="submit" value="Mehet">
        </form>

<?php if (isset($current)) { ?>
        Publikus: <a href="<?= $this->config->appUrl ?><?= $current ?>/" target="_blank"><?= $current ?></a><br/>
<?php } ?>

        Galériák:<br />
<?php
    if (isset($galleries)) {
        foreach($galleries as $gallery) {
?>
        <a href="<?= $this->config->appUrl ?><?= $gallery ?>" target="_blank"><?= $gallery ?></a>&nbsp;
        <a href="<?= $this->config->adminUrl ?>?op=edit&name=<?= $gallery ?>">Edit</a><br/>
<?php
        }
    }
?>

        <form action="?op=genall" method="POST">
            <input type="submit" value="Mindet újra" />
        </form>

    </body>

</html>
