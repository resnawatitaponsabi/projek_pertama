<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $nim = isset($_POST['nim']) ? $_POST['nim'] : '';
        $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';
        $fakultas = isset($_POST['fakultas']) ? $_POST['fakultas'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE mahasiswa SET id = ?, nama = ?, nim = ?, jurusan = ?, fakultas = ? WHERE id = ?');
        $stmt->execute([$id, $nama, $nim, $jurusan, $fakultas, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Perbarui Identitas #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="<?=$contact['id']?>" id="id">
        <input type="text" name="nama" value="<?=$contact['nama']?>" id="nama">
        <label for="nim">nim</label>
        <label for="jurusan">jurusan</label>
        <input type="text" name="nim" value="<?=$contact['nim']?>" id="nim">
        <input type="text" name="jurusan" value="<?=$contact['jurusan']?>" id="jurusan">
        <label for="fakultas">fakultas</label>
        <input type="text" name="fakultas" value="<?=$contact['fakultas']?>" id="title">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>