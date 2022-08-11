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
  <header class="d-flex px-2 justify-content-between align-items-center w-100">
    <!-- <div class="border-bottom">
      <ul class="d-flex align-items-center list-unstyled text-decoration-none">
        <li class="position-relative">
          <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#bttModal"><i class="fa-solid fa-plus"></i> Buat Form BTTT</a>
        </li>
        <li style="margin-left:20px;"><a class="text-decoration-none" href="{{url('/')}}"><i class="fa-solid fa-eye"></i> Lihat BTTT</a></li>
      </ul>
    </div> -->

    <!-- <div class="py-3">
      <a href="#" class=" fw-bold text-uppercase " style="outline-width: 0px; text-decoration: none; color: #636e72;" data-bs-toggle="modal" data-bs-target="#exampleModal"> &nbsp; <i class="fa-solid fa-caret-down"></i></a>

    </div> -->

  </header>
  <div class="container-fluid">

    <div class="row">
      <!-- Earnings (Monthly) Card Example -->
      <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="<?php echo base_url() ?>admin/Form_btt">Form BTT</a></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <!-- Earnings (Monthly) Card Example -->
      <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1"></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-cog fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->

      <h5 class="my-3"></h5>
      <div class="float-left">
        <button type="button" onclick="addFormBtt()" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#tambahFaktur"><i class="fa-thin fa-plus"></i>tambah faktur</button>
        <a href="javascript:window.history.go(-1)" type="button" class="btn btn-primary btn-sm mb-3">kembali</a>
      </div>

      <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
            <h5>No. Receiving : <?php echo $no_rcv; ?> </h5>
            <?php echo $this->session->flashdata('message') ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No. Faktur</th>
                    <th>Faktur Pajak</th>
                    <th>Tagihan</th>
                    <th>CSV</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($faktur as $f) : ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $f->no_faktur; ?></td>
                      <td><?php echo $f->fak_pjk; ?></td>
                      <td>Rp. <?php echo number_format($f->tagihan); ?></td>
                      <td><?php echo $f->csv; ?></td>
                      <td>
                        <a onclick="return confirm('yakin mau dihapus')" href="<?= base_url(); ?>admin/tambah_faktur/hapus_faktur/<?= $f->id_faktur . '/' . $no_rcv ?>" class="btn btn-danger">hapus</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
      <br>
      <hr>
      <div>


        <!-- <div class="float-right" style="margin-top: 50px !important;">
          <button onclick="simpan()" class="btn px-5 ml-3 text-white mb-3 add-row" style="background-color: indianred;">Lanjut</button>
        </div> -->

      </div>
    </div>

    <!-- Modal -->

    <!-- <div class="modal fade" id="bttModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bttModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered ">
      <div class="modal-content">

        <div class="modal-body text-center">
          <h4 class="">Apakah ada Faktur Pajak?</h4>
          <a href="" class="btn btn-secondary" style="width: 100px;" >PKP</a>
          <a href="" class="btn btn-primary ml-3" style="width: 100px;">NON PKP</a>
        </div>

      </div>
    </div>
  </div> -->

    <!-- <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered ">
      <div class="modal-content">

        <div class="modal-body text-center">
          <h4 class="">Anda ingin keluar?</h4>
          <form method="POST" action="">
            <button type="button" class="btn btn-secondary" style="width: 100px;" data-bs-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-primary ml-3" style="width: 100px;">Ya</button>

          </form>

        </div>

      </div>
    </div>
  </div> -->

    <!-- form tambah faktur -->
    <div class="modal fade" id="tambahFaktur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah faktur</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="<?php echo base_url('admin/tambah_faktur/simpan_faktur'); ?>" method="POST" enctype="multipart/form-data">
              <input type="text" value="<?php echo $no_rcv ?>" class="form-control" name="no_rcv" hidden>
              <div class="form-group">
                <label>No. Faktur Supplier</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Input Nomor Faktur Supplier" name="no_faktur" id="no_faktur" onChange='checkNoFaktur(value)' required>
                <span id="no_faktur-availability-status" class="text-danger"></span>
              </div>

              <div class="form-group">
                <label>Faktur Pajak</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Scan Qrcode Faktur Pajak" name="qrcode_pajak" id="qrcode1" onChange='barcodePajak(this)' required>
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                </div>

                <div class="form-group">
                  <label>No. Faktur Pajak</label>
                  <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="" name="no_faktur" id="no_fak_pjk" readonly required>
                  <span id="no_faktur-availability-status" class="text-danger"></span>
                </div>

                <div class="form-group">
                  <label>Total Faktur Pajak</label>
                  <input type="text" onKeyup="formatRupiah(this)" class="form-control" placeholder="" name="tagihan" id="tagihan" readonly required>

                </div>

                <div class="form-group">
                  <label>Upload CSV</label>
                  <input type="file" id="file" onchange="checkfile(this);" class="form-control" placeholder="csv" name="csv" id="csv" accept=".csv" required>
                  <span class="text-danger">(hanya bisa upload file csv)</span>
                </div>

                <button type="submit" class="btn btn-primary">simpan</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end -->

    <div class="modal fade" id="alertModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered ">
        <div class="modal-content">

          <div class="modal-body text-center">
            <h4 class="">Hapus tagihan ini?</h4>
            <button type="button" class="btn btn-secondary" style="width: 100px;" data-bs-dismiss="modal">Tidak</button>
            <button onclick="setAccept()" type="button" class="btn btn-primary ml-3" style="width: 100px;">Ya</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>

    <script>
      const email = document.querySelector('#email');
      const submit = document.querySelector('#submit');

      //  submit.addEventListener('click',()=>{
      //     if(){

      //     }else
      //  }); 

      function checkfile(sender) {
        var validExts = new Array(".csv");
        var fileExt = sender.value;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        if (validExts.indexOf(fileExt) < 0) {
          alert("maaf hanya boleh upload file" +
            validExts.toString());
          return false;
        } else return true;
      }

      function checkNoFaktur(value) {

        $.ajax({
          type: "POST",
          url: "<?php echo base_url('admin/validateFaktur/validateFaktur'); ?>",
          data: {
            nofaktur: value
          },
          success: function(res) {
            // console.log(res);
            const obj = JSON.parse(res);
            if (obj.status == 200 && obj.message == 'success get data') {
              $("#no_faktur-availability-status").html(obj.results);
              $("#check_no_rcv").hide();
            } else {
              $("#no_faktur-availability-status").html(obj.results);
              $("#check_no_rcv").hide();
            }

          }
        });
      }
    </script>

    <script>
      let no = 1;
      let limit = 11;
      let temp = '';

      $(document).ready(function() {
        addRow();

        $('#form_faktur').submit(function() {
          let no_faktur = $('#no_faktur').val();
          let fak_pjk = $('#fak_pjk').val();
          let tagihan = $('#tagihan').val();
          let csv = $('#csv').val();

          if (no_faktur == "") {
            swal("no faktur harus di isi", "warning");
            return false;
          } else if (fak_pjk == "") {
            swal("faktur pajak harus di isi", "warning");
            return false;
          } else if (tagihan == "") {
            swal("tagihan harus di isi", "warning");
            return false;
          } else if (csv == "") {
            swal("csv harus di upload", "warning");
            return false;
          } else {
            return true;
          }

        });

      });





      function barcodePajak(me) {
        let link = me.value;

        $.ajax({
          method: 'POST',
          url: "<?php echo base_url('admin/tambah_faktur/checkqrcode') ?>",
          data: {
            // me.value
            link: link
          },
          success: function(res) {
            let data = JSON.parse(res);

            if (data == true) {
              Swal.fire({
                icon: 'koneksi ke server sedang terganggu',
                title: 'Oops...',
                text: 'koneksi ke server sedang terganggu, silahkan ulangi lagi!',
              })
            } else if (data == "No service was found.0"){
              // show modal alert
              console.log(res);
              alert('');
            } else {
              //  send to id no faktur and total faktur
              // let data = JSON.parse(res);
              if (data == true) {
                 
              }else{
                  console.log(data);

                  var number_string = data.total.toString(),
                  sisa = number_string.length % 3,
                  rupiah = number_string.substr(0, sisa),
                  ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan){
                  separator = sisa ? '.' : '';
                  rupiah += separator + ribuan.join('.');
                }
                // console.log(data.no_faktur);
                $('#no_fak_pjk').val(`010` + `${'.'}` + data.no_faktur);
                $('#tagihan').val(`Rp. ` + rupiah);
              }

            }
          }
        });
      }

      // function barcodePajak(me) {

      //   $.ajax({
      //     method: 'post',
      //     url: "{{url('chekqrcode')}}",
      //     data: {
      //       _token: "{{ csrf_token() }}",
      //       url: me.value
      //     },
      //     success: function(res) {
      //       let tagihan = $(me).parent().parent().find('input[name=jumlah_tagihan]').val(res)

      //       formatRupiah(tagihan[0])
      //     }
      //   })

      // }


      function addRow(me = false) {

        // if(no >= limit){
        //   return true;
        // }
        // let forms = $('#allform').children().last().find('input[name=no_rcv_suzuya]').val();

        if ($('#allform').children().length == 10) {
          return;
        }

        $(me).addClass('d-none');

        let row = `<div id="row${no}">
    <form>
        <div class="row w-100">
          <div class="col-2 mb-3">
            <label hidden for="fpajak" class="form-label">Barcode Pajak</label>
            <input onChange="barcodePajak(this)" id="qrcode1" type="text" class="form-control qrcode" name="no_faktur">
            <div id="validationServerUsernameFeedback" class="invalid-feedback" id="qrcode" required>
        Please choose a username.
          </div>
        </div>

          <div class="col-3 mb-3">
            <label hidden for="faktur" class="form-label">No Faktur </label>
            <input type="text" class="form-control" name="faktur_pajak" id="faktur_pajak" required>
          </div>
    
          <div class="col-3 mb-3">
            <label hidden for="receiving" class="form-label">No Receiving</label>
            <input type="text" class="form-control" name="tagihan" required>
          </div>
  
          <div class="col-1 mb-3 d-flex gap-1">
            <button id="btnRemove" onclick="removeRow(this)" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
            <button id="btnAdd" onclick="addRow(this)" type="button" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i></button>
          </div>
        </div>
    </form>
      </div>
`;


        $('#allform').append(row);
        no++;


      }


      function removeRow(me) {
        temp = $(me).parent().parent().parent().parent()[0].id
        $('#alertModal').modal('show');

      }

      function setAccept() {
        $(`#${temp}`).remove();
        console.log($('#allform').children().last().find('#btnAdd').removeClass('d-none'))
        $('#alertModal').modal('hide');
      }

      // function simpan() {

      //   let form = $('#allform').children().toArray()
      //   let dataForm = []
      //   let error = ''



      //   form.map(e => {
      //     $(e).find('input').toArray().map(i => {
      //       if (!i.value) {
      //         error += i.name + ', '
      //       }
      //     })
      //     dataForm.push($(e).children().serializeArray())
      //   })

      //   // if(error){
      //   //   alert('error  :'+error +'. input tidak benar!')
      //   // }else{


      //   $.ajax({
      //     type: 'POST',
      //     url: "<?php echo base_url() ?>admin/Dashboard/insert_data",
      //     data: {
      //       dataForm
      //     },
      //     success: function(res) {
      //       console.log(res = "success");
      //       // res = JSON.parse(res)

      //       if ("success") {
      //         // $('#allform').html(respond);
      //         // alert('data berhasil di inputkan');
      //         window.location.reload();

      //       }
      //     },
      //     error: function(error) {
      //       alert('Terjadi kesalahan: periksa inputan anda!');
      //     }
      //   })


      // }
    </script>
</body>

</html>