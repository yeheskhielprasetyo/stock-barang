<?php
session_start();

// koneksi 
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

// tambah barang baru
if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) 
    VALUES ('$namabarang','$deskripsi','$stock')");
    if ($addtotable) {
        header('location: index.php');
    } else {
        echo 'gagal';
        header('location: index.php');
    }
}


// menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];


    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES ('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock set stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if ($addtomasuk && $updatestockmasuk) {
        header('location: masuk.php');
    } else {
        echo 'gagal';
        header('location: masuk.php');
    }
}


// menambah barang keluar
if (isset($_POST['barangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];


    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES ('$barangnya', '$penerima', '$qty')");
    $updatestockkeluar = mysqli_query($conn, "UPDATE stock set stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if ($addtokeluar && $updatestockkeluar) {
        header('location: keluar.php');
    } else {
        echo 'gagal';
        header('location: keluar.php');
    }
}

// update info barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idb'");
    if ($update) {
        header('location: index.php');
    } else {
        echo 'gagal';
        header('location: index.php');
    }
}


// hapus id barang
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang = '$idb' ");
    if ($hapus) {
        header('location: index.php');
    } else {
        echo 'gagal';
        header('location: index.php');
    }
}


// ubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idm = $_POST['idm'];
    $idb = $_POST['idb'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock = '$kurangin'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty = '$qty', keterangan = '$deskripsi' WHERE idmasuk = '$idm'");
        if ($kurangistocknya && $updatenya) {
            header('location: masuk.php');
        } else {
            echo 'gagal';
            header('location: masuk.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
        if ($kurangistocknya && $updatenya) {
            header('location: masuk.php');
        } else {
            echo 'gagal';
            header('location: masuk.php');
        }
    }
}


// menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];


    $selisih =  $stok - $qty;

    $update =   mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk = '$idm'");

    if ($update && $hapusdata) {
        header('location: masuk.php');
    } else {
        header('location: masuk.php');
    }
}


// mengubah barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idk = $_POST['idk'];
    $idb = $_POST['idb'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock = '$kurangin'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty = '$qty', penerima = '$penerima' WHERE idkeluar = '$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location: keluar.php');
        } else {
            echo 'gagal';
            header('location: keluar.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location: keluar.php');
        } else {
            echo 'gagal';
            header('location: keluar.php');
        }
    }
}


// menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];


    $selisih =  $stok + $qty;

    $update =   mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar = '$idk'");

    if ($update && $hapusdata) {
        header('location: keluar.php');
    } else {
        header('location: keluar.php');
    }
}