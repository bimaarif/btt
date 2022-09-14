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

      <div class="float-left">
        <button type="button" onclick="handleUpdateOrAddFaktur(false, 'add')" class="btn btn-primary btn-sm mb-3"><i class="fa-thin fa-plus"></i>tambah faktur</button>
        <!-- <a href="javascript:window.history.go(-1)" type="button" class="btn btn-primary btn-sm mb-3">kembali</a> -->

        <a href="<?php echo base_url() . 'admin/receiving/index/' . $no_bttt . '/' . $no_rcv; ?>" type="button" class="btn btn-primary btn-sm mb-3">kembali</a>
      </div>

      <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>

            <div class="row">
              <div class="col">
                <h5>No. Receiving : <?php echo $no_rcv; ?> </h5>
              </div>
              <div class="col">
                <!-- <input type="text" name="status" value="" hidden> -->
                <a href="<?php echo base_url() ?>admin/faktur/updateStatus/<?php echo $no_bttt ?>/<?php echo $no_rcv ?>" class="btn btn-danger" style="position:absolute; right:10px;" id="selesai">selesai</a>
              </div>
            </div>
            <br>
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
                    <!-- <th>No. Faktur Pajak</th> -->
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
                        <a onclick="return confirm('yakin mau dihapus')" href="<?= base_url(); ?>admin/faktur/hapus_faktur/<?= $f->id_faktur . '/' . $no_rcv ?>" class="btn btn-danger">hapus</a>
                        <a href="#" onclick="handleUpdateOrAddFaktur(this,'update')" data-id_faktur="<?php echo $f->id_faktur ?>" data-no_faktur="<?php echo $f->no_faktur ?>" data-fak_pjk="<?php echo $f->fak_pjk ?>" data-no_fak_pjk="<?php echo $f->no_fak_pjk ?>" data-tagihan="<?php echo $f->tagihan ?>" data-csv="<?php echo $f->csv ?>" class="btn btn-success ubahFak">Ubah</a>
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
  <div class="modal fade" id="tambahFaktur" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?php echo base_url('admin/faktur/simpan_faktur'); ?>" method="POST" enctype="multipart/form-data">
          <input type="text" name="id_faktur" id="id_faktur" hidden>
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="text" value="<?php echo $no_rcv ?>" class="form-control" name="no_rcv" hidden>

            <div class="form-group">
              <label for="no_faktur">No. Faktur Supplier</label>
              <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Input Nomor Faktur Supplier" name="no_faktur" id="no_faktur" onChange='checkNoFakturSupplier(value)' autofocus required>
              <span id="no_fak_supp-availability-status" class="text-danger"></span>
            </div>

            <div class="form-group">
              <label>Qrcode Faktur Pajak</label>
              <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Scan Qrcode Faktur Pajak" name="fak_pjk" id="qrcode1" onChange='barcodePajak(this)' autofocus required>
              <span id="scan-Qrcode-availability-status" class="text-danger"></span>
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
              </div>

              <div class="form-group">
                <label>No. Faktur Pajak</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="" name="no_fak_pjk" id="no_fak_pjk" onChange="checkNoFakturPajak(value)" readonly required>
                <span id="no_faktur-availability-status" class="text-danger"></span>
              </div>

              <div class="form-group">
                <label>Total Harga Faktur Pajak</label>
                <input type="text" onKeyup="formatRupiah(this)" class="form-control" placeholder="" name="tagihan" id="tagihan" readonly required>

              </div>

              <div class="form-group">
                <label>Upload CSV</label>


                  <label class="sr-only" for="inlineFormInputGroup">Input file</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">Chose file</div>
                    </div>
                    <input onclick="document.getElementById('fUpload').click()" type="text" class="form-control" id="vUpload" name="csv" readonly>
                  </div>
                


                <input hidden id="fUpload" type="file" onchange="checkfile(this);" class="form-control csv" placeholder="csv" name="csv" id="csv" accept=".csv" required>
                <span class="text-danger">(hanya bisa upload file csv)</span>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" id="simpanFaktur">simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end -->


  <!-- form ubah faktur -->

  <!-- end -->

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>


  <script>
    $('#fUpload').change(function() {
      $('#vUpload').val($('#fUpload')[0].files[0].name);
    })

    function handleUpdateOrAddFaktur(me, action) {
      if (action == 'add') {
        $('#id_faktur').val('');
        $('#no_faktur').val('');
        $('#fak_pjk').val('');
        $('#no_fak_pjk').val('');
        $('#tagihan').val('');
        $('#csv').val('');

        $('#tambahFaktur .modal-title').text('Tambah Faktur')
        $('#tambahFaktur form').attr('action', "<?php echo base_url('admin/faktur/simpan_faktur'); ?>")
        $('#tambahFaktur').modal('show');
        return
      }

      if (action == 'update') {

        const id_faktur = $(me).data('id_faktur');
        const no_faktur = $(me).data('no_faktur');
        const fak_pjk = $(me).data('fak_pjk');
        const no_fak_pjk = $(me).data('no_fak_pjk');
        const tagihan = $(me).data('tagihan');
        const csv = $(me).data('csv');

        console.log(csv);

        var number_string = tagihan.toString(),
          sisa = number_string.length % 3,
          rupiah = number_string.substr(0, sisa),
          ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        $('#id_faktur').val(id_faktur);
        $('#no_faktur').val(no_faktur);
        $('#qrcode1').val(fak_pjk);
        $('#no_fak_pjk').val(no_fak_pjk);
        $('#tagihan').val('Rp. ' + rupiah);
        $('#vUpload').val(csv);

        // console.log(data);

        $('#tambahFaktur .modal-title').text('Ubah Faktur')
        $('#tambahFaktur form').attr('action', "<?php echo base_url('admin/faktur/edit_Faktur'); ?>")
        // $('#tambahfaktur .csv').attr('required','FALSE');
        $('#tambahFaktur').modal('show');
        return
      }

    }



    // $(document).ready(function() {
    if (($.trim($("tbody").html()) == "")) {
      $("#selesai").hide();
    } else {
      $("#selesai").show();
    }

    $('#qrcode1').keyup(function() {
      let faktur_pajak = $('#qrcode1').val();
      if (faktur_pajak == 0) {
        $('#scan-Qrcode-availability-status').text('');
      } else {
        $.ajax({
          url: '<?php echo base_url('admin/faktur/validateScanQrcode'); ?>',
          type: 'POST',
          data: {
            fak_pjk: faktur_pajak
          },
          success: function(hasil) {
            const obj = JSON.parse(hasil);
            if (obj.status == 200 && obj.message == 'success get data') {
              $('#scan-Qrcode-availability-status').html(obj.results);
            }
          }
        });
      }
    });


    // });


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


    $(document).on('keyup', '#no_faktur', function() {
      $('#no_fak_supp-availability-status').html('');
    });

    function checkNoFakturSupplier(value) {

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/faktur/validateFakturSupplier'); ?>",
        data: {
          no_faktur: value
        },
        success: function(res) {
          // console.log(res);
          const obj = JSON.parse(res);
          if (obj.status == 200 && obj.message == 'success get data') {
            $("#no_fak_supp-availability-status").html(obj.results);
            $("#no_faktur").val('');
          }

        }
      });
    }

    $(document).on('keyup', '#no_fak_pjk', function() {
      $('#no_faktur-availability-status').html('');
    });

    function checkNoFakturPajak(value) {

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/faktur/validateNofakturPajak'); ?>",
        data: {
          no_fak_pjk: value
        },
        success: function(res) {
          // console.log(res);
          const obj = JSON.parse(res);
          if (obj.status == 200 && obj.message == 'success get data') {
            $("#no_faktur-availability-status").html(obj.results);
            $("#no_fak_pjk").val('');
          }

        }
      });
    }

    let no = 1;
    let limit = 11;
    let temp = '';

    // $(document).ready(function() {
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

    // });


    $(document).on('keyup', '.no_faktur', function() {
      $('#scan-Qrcode-availability-status').html('');
    });


    function barcodePajak(me) {
      let link = me.value;

      $.ajax({
        method: 'POST',
        url: "<?php echo base_url('admin/faktur/checkqrcode') ?>",
        data: {
          // me.value
          link: link
        },
        success: function(res) {
          let data = JSON.parse(res);

          // console.log(data);

          // if(data == "berhasil"){
          //   let number_string = data.total.toString(),
          //       sisa = number_string.length % 3,
          //       rupiah = number_string.substr(0, sisa),
          //       ribuan = number_string.substr(sisa).match(/\d{3}/g);

          //     if (ribuan) {
          //       separator = sisa ? '.' : '';
          //       rupiah += separator + ribuan.join('.');
          //     }
          //     // console.log(data.no_faktur);
          //     // $('#no_fak_pjk').val(`010` + `${'.'}` + data.no_faktur);
          //     $('#no_fak_pjk').val(`010` + `${'.'}` + data.no_faktur);
          //     $('#tagihan').val(`Rp. ` + rupiah);
          // }else if(data == "gagal"){
          //     alert("URL tidak benar");
          //     $('#qrcode1').val('');
          //     $('#no_fak_pjk').val('');
          //     $('#tagihan').val('');
          // }else if(data == "ada"){
          //     alert("faktur pajak sudah digunakan");
          //     $('#qrcode1').val('');
          //     $('#no_fak_pjk').val('');
          //     $('#tagihan').val('');
          // }else{
          //     Swal.fire({
          //        position: 'top-end',
          //        icon: 'error',
          //        title: 'maaf koneksi ke server terputus, coba scan ulang lagi',
          //        showConfirmButton: false,
          //        timer: 3000
          //     });
          //     $('#qrcode1').val('');
          //     $('#no_fak_pjk').val('');
          //     $('#tagihan').val('');
          // }

          if (data == true) {
            Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: 'maaf koneksi ke server terputus, coba scan ulang lagi',
              showConfirmButton: false,
              timer: 3000
            });
            $('#qrcode1').val('').focus();
          } else if (data.total == "ada") {
            // show modal alert
            // console.log(res);
            alert('total harga sudah ada');
          } else {
            //  send to id no faktur and total faktur
            // let data = JSON.parse(res);
            if (data == true) {

            } else {
              console.log(data);

              var number_string = data.total.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

              if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
              }
              // console.log(data.no_faktur);
              // $('#no_fak_pjk').val(`010` + `${'.'}` + data.no_faktur);
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