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
  <title>Hello, world!</title>
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
    </div>

    <div class="py-3">
      <a href="#" class=" fw-bold text-uppercase " style="outline-width: 0px; text-decoration: none; color: #636e72;" data-bs-toggle="modal" data-bs-target="#exampleModal">&nbsp; <i class="fa-solid fa-caret-down"></i></a>

    </div> -->

  </header>
  <div class="container">
    
    <?php echo $this->session->flashdata('message') ?>
    <h5 class="my-3">Tambah faktur</h5>
    <a href="<?php echo base_url(); ?>admin/tambah_receiving" type="button" class="btn btn-primary">kembali</a>
    <hr>
    <div">
      <div class="row w-100 mb-3 fw-bold">
        <div class="col-2">No Faktur</div>
        <div class="col-3">faktur pajak</div>
        <div class="col-3">Tagihan</div>
        <div class="col-3">Upload csv</div>
      </div>
      <form method="POST" action="<?php echo base_url(); ?>admin/Form_faktur/insert_faktur" enctype="multipart/form-data">
        <div id="allform"></div>
        <div class="float-right" style="margin-top: 50px !important;">
          <button type="submit" class="btn px-5 ml-3 text-white" style="background-color: indianred;" name='submit'>submit</button>
        </div>
      </form>
  </div>
  </div>

  <!-- Modal -->

  <!-- <div class="modal fade" id="bttModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bttModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered ">
      <div class="modal-content">

        <div class="modal-body text-center">
          <h4 class="">Apakah ada Faktur Pajak?</h4>
          <a href="{{url('form/create/pkp')}}" class="btn btn-secondary" style="width: 100px;" >PKP</a>
          <a href="{{url('form/create/nonpkp')}}" class="btn btn-primary ml-3" style="width: 100px;">NON PKP</a>
        </div>

      </div>
    </div>
  </div> -->

  <!-- <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered ">
      <div class="modal-content">

        <div class="modal-body text-center">
          <h4 class="">Anda ingin keluar?</h4>
          <form method="POST" action="{{url('/logout')}}">
            <button type="button" class="btn btn-secondary" style="width: 100px;" data-bs-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-primary ml-3" style="width: 100px;">Ya</button>
          </form>
        </div>
      </div>
    </div>
  </div> -->

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
    let no = 1;
    let temp = '';
    $(document).ready(function() {
      addRow();
    })


    /* Fungsi formatRupiah */
    function formatRupiah(me, prefix = 'Rp. ') {
      // console.log(me[0].value)
      let angka = me.value
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      me.value = prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
      return
    }




    function barcodePajak(me) {

      $.ajax({
        method: 'post',
        url: "{{url('chekqrcode')}}",
        data: {
          _token: "{{ csrf_token() }}",
          url: me.value
        },
        success: function(res) {
          let tagihan = $(me).parent().parent().find('input[name=jumlah_tagihan]').val(res)

          formatRupiah(tagihan[0])
        }
      })

    }


    function addRow(me = false) {

      if ($('#allform').children().length == 10) {
        return;
      }

      $(me).addClass('d-none')

      let row = ` 
        <div class="row w-100">
           <div class="col-2 mb-3">
              <label hidden for="fpajak" class="form-label"></label>
              <input onChange="barcodePajak(this)"type="text" class="form-control qrcode" name="no_faktur[]">
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
        Please choose a username.
           </div>
        </div>
    
          <div class="col-3 mb-3">
            <label hidden for="receiving" class="form-label"></label>
            <input type="text" class="form-control" name="fak_pjk[]" required>
          </div>
          <div class="col-3 mb-3">
            <label hidden for="tagihan" class="form-label">Tagihan</label>
            <input onKeyup="formatRupiah(this)" value="" type="text" class="form-control" name="tagihan[]" required>
          </div>

          <div class="col-3 mb-3">
            <label hidden for="receiving" class="form-label">No Receiving</label>
            <input type="file" class="form-control" name="csv[]" required>
          </div>
  
          <div class="col-1 mb-3 d-flex gap-1">
            <button id="btnRemove" onclick="removeRow(this)" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
            <button id="btnAdd" onclick="addRow(this)" type="button" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i></button>
          </div>
        </div>
        
 
      </div>
`

      $('#allform').append(row)
      no++;
    }

    function removeRow(me) {
      if ($('#allform').children().length == 10) {
        return;
      }
      temp = $(me).parent().parent().parent().parent()[0].id
      $('#alertModal').modal('show');

    }

    function setAccept() {
      $(`#${temp}`).remove();
      console.log($('#allform').children().last().find('#btnAdd').removeClass('d-none'));
      $('#alertModal').modal('hide');
    }

    function simpan() {

      let form = $('#allform').children().toArray()
      let dataForm = []
      let error = ''
      form.map(e => {
        $(e).find('input').toArray().map(i => {
          if (!i.value) {
            error += i.name + ', '
          }
        })
        dataForm.push($(e).children().serializeArray())
      })

      if (error) {
        alert('error  :' + error + '. input tidak benar!')
      } else {

        $.ajax({
          type: 'POST',
          url: "<?php echo base_url() ?>admin/Form_faktur/insert_data",
          data: {
            dataForm,
          },
          success: function(res) {
            console.log(res = "success");
            // res = JSON.parse(res)

            if ("success") {
              // $('#allform').html(respond);
              // alert('data berhasil di inputkan');
              window.location.reload();

            }
          },
          error: function(error) {
            alert('Terjadi kesalahan: periksa inputan anda!');
          }
        })
      }

    }
  </script>
</body>

</html>