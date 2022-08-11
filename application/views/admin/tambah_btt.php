<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{asset('css/jquery.datetimepicker.min.css')}}" />
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
      <h5 class="my-3"></h5>
      <div class="float-left">
        <form action="<?php base_url(); ?>tambah_btt/inputKode" method="POST">
          <input type="hidden" class="form-control" aria-describedby="emailHelp" placeholder="" name="no_btt" id="no_btt" value="<?php echo $kode_btt; ?>">
          <button type="submit" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#exampleModal" id="tambah_btt"><i class="fa-thin fa-plus"></i>Tambah BTT</button>
        </form>
      </div>
      <hr>
      <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No. BTT</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($tampil_btt as $btt) : ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $btt->no_btt; ?></td>
                      <td>
                        <!-- <a href="tambah_receiving" type="button" class="btn btn-primary" id="" onclick="getData">input receiving</a> -->

                        <a type="button" href="<?php echo base_url().'admin/tambah_receiving/index/'.$btt->no_btt ?>" class="btn btn-primary">input receiving</a>
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

  <script>
    function getData(values){
        $.ajax({
          type: "POST",
          url: "<?php echo base_url() ?>admin/tambah_receiving/index",
          data: {
             data : values
          },
          // dataType: "dataType",
          success: function (response) {
            $('body').empty().append(response)
          }
        });
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