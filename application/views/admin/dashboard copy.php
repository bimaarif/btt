 <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"></h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
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

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1"></div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-briefcase fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

       <div class="row">
        <div class="form-group">
          <form class="form-inline" id="dynamic_field" action='<?php base_url(); ?>'>
                <label class="sr-only" for="inlineFormInputName2"></label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="scan barcode" name="barcode[]" id="barcode">
        
                <label class="sr-only" for="inlineFormInputName2"></label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="no. faktur" name="no_faktur[]" id="no_faktur">

                <label class="sr-only" for="inlineFormInputName2"></label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="no. receving suz" name="no_receving[]" id="no_receving">

                <label class="sr-only" for="inlineFormInputName2"></label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="jumlah tagihan" name="jumlah_tagihan[]" id="jumlah_tagihan">

                <button type="button" class="btn btn-primary mb-2 mr-2 tambah-form">
                  <i class="fa fa-plus"></i>
                </button>
                <button type="submit" class="btn btn-danger mb-2 btn_remove">
                  <i class="fa fa-trash"></i>
                </button>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                    lanjut
                </button>
            </form>
       </div>
    </div>

    <!-- Content Row -->
    


</div>
<!-- /.container-fluid -->
   

</div>
<!-- End of Main Conten