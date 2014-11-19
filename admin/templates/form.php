<form action="" method="post">
    <label for="gallery_name">Név: </label>
    <input id="gallery_name" type="text" name="name" value="<?= $name ?>" /><br />
    <label for="gallery_data">Név: </label>
    <textarea id="gallery_data" name="data" cols="200" rows="30">
<?= $data ?>
    </textarea><br />
    <input type="submit" value="Mehet">
</form>
