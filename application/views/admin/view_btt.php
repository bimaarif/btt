<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta  name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title></title>
  <style>
    button:focus {
      outline: none;
    }

    header ul li a {
      color: #636e72;
      padding: 6px;
      border-radius: 8px;
    }

    header ul li:hover,
    header ul li a:hover {
      /* text-decoration: underline; */
      color: #2d3436;
      background-color: #81ecec;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="float-left">
        <form action="<?php echo base_url('admin/btt/inputKode'); ?>" method="POST">
          <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="" name="no_btt" id="no_btt" value="<?php echo $kode_btt; ?>" hidden>
          <button type="submit" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#exampleModal" id="tambah_btt"><i class="fa-thin fa-plus"></i>Tambah BTTT</button>
        </form>
      </div>
      <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
            <div id="cetak"></div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No. BTTT</th>
                    <th>Tanggal</th>
                    <th>status</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($tampil_btt as $btt) : ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $btt->no_btt; ?></td>
                      <td><?php echo $btt->create_at; ?></td>
                      <td>
                        <?php
                        if ($btt->status == "Create") {
                          echo "<p class='badge badge-warning'>Create</p";
                        } else if ($btt->status == "Unconfirm") {
                          echo "<p class='badge badge-danger'>Unconfirm</p";
                        } else {
                          echo "<p class='badge badge-success'>Confirm</p";
                        } ?>
                      </td>
                      <td>
                        <!-- <a href="tambah_receiving" type="button" class="btn btn-primary" id="" onclick="getData">input receiving</a> -->
                        <?php
                        if ($btt->status == "Confirm") {
                        ?>
                          <button class='btn btn-success' onclick="gotoPrint('<?php echo $btt->no_btt; ?>','Confirm', this)">Print</button>
                        <?php
                        } else if ($btt->status == "Unconfirm") {
                        ?>
                          <a href='<?php echo base_url() . 'admin/receiving/index/' . $btt->no_btt ?>' class='btn btn-primary'>Input Receiving</a>
                          <button  class='btn btn-success' onclick="gotoPrint('<?php echo $btt->no_btt; ?>','Unconfirm', this)">Ajukan</button>
                          <!-- <button class='btn btn-success' data-toggle="modal" data-target="#print">Print</button> -->
                          <!-- <button class="btn btn-success" data-toggle="modal" onclick='sampleButton();'>Print</button> -->
                        <?php
                        } else if ($btt->status == "Create") {
                        ?>
                          <a href='<?php echo base_url() . 'admin/receiving/index/' . $btt->no_btt ?>' class='btn btn-primary'>Input Receiving</a>
                        <?php } ?>
                        <!-- <a type="button" href="<?php echo base_url() . 'admin/receiving/index/' . $btt->no_btt ?>" class="btn btn-primary">input receiving</a> -->
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="print" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
      <div class="modal-content">

        <div class="modal-body ">
          <iframe id="view_print" src="" frameborder="no"  width="100%" height="550"></iframe>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onclick="javascript:window.location.reload()"   data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script>

    $('#tambah_btt').on('click', function(){

    })

    function getData(values) {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() ?>admin/receiving/index",
        data: {
          data: values
        },
        // dataType: "dataType",
        success: function(response) {
          $('body').empty().append(response)
        }
      });
    }


    function gotoPrint(values, status, me) {
 

      Swal.fire({
        title: 'Yakin ingin melakukan print?',
        text: status == 'Unconfirm' ? "Jika anda melakukan print, maka anda tidak bisa melakukan input receiving dan faktur": '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Swal.fire(
          //   'Deleted!',
          //   'Your file has been deleted.',
          //   'success'
          // )
          $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/btt/updateConfirm/" + values + "/<?php echo "Confirm"; ?>",
            success: function(response) {
              var convert = JSON.parse(response);
              if (convert.status == 200) {
                
                let url = "<?php echo base_url('admin/btt/getDataPrint/'); ?>" + values;
                // let refresh = $(me).parent().find('a').addClass('d-none');
                $('#view_print').attr('src', url)
                $('#print').modal('show')
                $(me).parent().find('a').addClass('d-none');

                $('#print').modal({
                    backdrop: 'static',
                    keyboard: false
                })

                // $('').modal({
                //     remote: url,
                //     refresh: true
                // });
                // window.location.reload();
                // print();
                // location.reload();
              } else {
                // location.reload();
              }
            }
          });
        }
      })
    }
  </script>




  <!-- form tambah faktur -->
  <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Btt</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="form-group">
              <label for="exampleInputEmail1">No. Btt</label>
              <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="" name="no_rcv" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> -->
  <!-- end -->
</body>

</html>