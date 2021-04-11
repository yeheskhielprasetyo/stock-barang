<?php
require "function.php";
require "cek.php";
?>
<html>

<head>
    <title>Stock Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js">
    </script>
</head>

<body>
    <div class="container">
        <h2>Stock Bahan</h2>
        <h4>(Inventory)</h4>
        <div class="data-tables datatable-dark">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Stock</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
                    $i = 1;
                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                        $namabarang = $data['namabarang'];
                        $deskripsi = $data['deskripsi'];
                        $stock = $data['stock'];
                        $idb = $data['idbarang'];
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $namabarang; ?></td>
                        <td><?php echo $deskripsi; ?></td>
                        <td><?php echo $stock; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#edit<?php echo $idb; ?>">Edit</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#delete<?php echo $idb; ?>">Delete</button>
                            <!-- <a href="edit.php?idbarang=<?php echo $data['idbarang']; ?>"><button type="button" class="btn btn-warning" data-toggle="modal">
                                                            Edit
                                                        </button></a>
                                                    <a href="delete.php?idbarang?idbarang==<?php echo $data['idbarang']; ?>"><button type="button" class="btn btn-primary" data-toggle="modal">
                                                            Delete
                                                        </button></a> -->
                        </td>
                    </tr>
                    <!-- Edit  Modal -->
                    <div class="modal fade" id="edit<?php echo $idb; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Ubah Barang</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <form action="" method="POST">
                                    <div class="modal-body">

                                        <input type="hidden" name="idb" value="<?php echo $idb; ?>">
                                        <input type="text" name="namabarang" value="<?php echo $namabarang; ?>"
                                            class="form-control" required><br>
                                        <input type="text" name="deskripsi" value="<?php echo $deskripsi; ?>"
                                            class="form-control" required><br>

                                        <button type="submit" class="btn btn-primary"
                                            name="updatebarang">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete  Modal -->
                    <div class="modal fade" id="delete<?php echo $idb; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Hapus Barang</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="idb" value="<?php echo $idb; ?>">
                                        Apakah anda ingin menghapus
                                        <?php echo $namabarang; ?>?<br><br>
                                        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#mauexport').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>