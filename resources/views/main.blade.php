<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css">
    
    <link rel="icon" href="/images/icon.png" type="image/x-icon">
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script src="/js/select2.min.js"></script>
    
    <title>Perdin Aira Tech</title>
  </head>
  <body style="background-color:#f2f3f4">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top sticky-top" style="background-color:rgb(6 148 241)">

        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="/images/logo.png" alt="logo" width="65" height="30">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              @if(Auth::user()->role=="admin")
              <li class="nav-item">
                <a class="nav-link" href="/user">Master User<span class="sr-only">(current)</span></a>
              </li>
              @endif
              @if(Auth::user()->role=='sdm')
              <li class="nav-item">
                <a class="nav-link" href="/kota">Master Kota<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/approval">Approval Perdin<span class="sr-only">(current)</span></a>
              </li>
              @endif
              @if(Auth::user()->role=='pegawai')
              <li class="nav-item active">
                <a class="nav-link" href="/perdin">Perjalanan Dinas <span class="sr-only">(current)</span></a>
              </li>
              @endif
            </ul>
            
            <ul class='navbar-nav mr-0'>
                <li class="nav-item">                  
                  <form action={{ url("/login/logout/". Auth::user()->username) }} method="POST">
                    @csrf
                    <button type='submit' class ='btn bg-transparent nav-link'>
                      <i class="bi bi-box-arrow-right mr-1 mt-1" style='color:rgba(255,255,255,.5);font-size:1rem'></i>
                      Logout
                      <span class="sr-only">(current)</span>
                    </button>  
                  </form>
                </li>
            </ul>

          </div>
        </div>  
      </nav>

      <section id="main" class="my-5">
        <div class="container">

          <div class="row">
            <div class="col-md-3">
              <div class="card pt-4 pb-3 px-2 mb-3" style="border:0px;border-top:5px solid rgb(6 148 241)">
                <!--
                <img src="/images/foto.jpg" class="rounded mx-auto" width="120" alt="Pas Foto">
                -->
                <div class="card-body text-center">
                  <p class="car-text mb-1" style='font-size:11px'> Do great job,</p>
                  <h4 class="card-title text-center mb-4">{{ strtoupper(Auth::user()->nama_pegawai) }}</h4>
                  <p class="car-text mb-1" style='font-size:11px'> Employee Registration Number:</p>
                  <h5 class="card-text">{{ Auth::user()->nrp }}</h5>
                  <!--
                  <a href="#" class="btn bg-orange btn-sm mt-4" data-toggle="modal" data-target="#modal-password">Ganti Password</a>
                  -->
                  <hr/>
                  <p class="text-center mb-2 font-12" style='font-size:13px'>Your role is:</p>
                  <h5 class="color-blue text-center ">{{ Auth::user()->role=='pegawai'?'PEGAWAI':(Auth::user()->role=='sdm'?'DIVISI SDM':'ADMIN') }}</h5>
                </div>
              </div>
            </div>

            <div class="col-md-9">
              <div class="card px-3 card-transparent" style="border:0px">
                @yield('content')
              </div>
            </div>
          </div> 
        </div>   
      </section>

      <div id="modal-password" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header" style="border-bottom:0px">
                <h4>Ubah Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                
                <form action={{ url('user/update-pass/'.Auth::user()->username) }} method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="pass_lama" class="form-label">Password Lama</label>
                      <input type="password" class="form-control @error('pass_lama') is-invalid @enderror"  
                          name="pass_lama" aria-describedby="" required value="{{ old('pass_lama') }}">
                      @error('pass_lama')<div class="invalid-feedback">{{ $message }}</div>@enderror  
                  </div>
                  <div class="mb-3">
                    <label for="pass_baru" class="form-label">Password Baru</label>
                    <input type="password" class="form-control @error('pass_baru') is-invalid @enderror"  
                        name="pass_baru" aria-describedby="" required value="{{ old('pass_baru') }}">
                    @error('pass_baru')<div class="invalid-feedback">{{ $message }}</div>@enderror  
                </div>
                <div class="mb-3">
                  <label for="konfirm_pass" class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" class="form-control @error('konfirm_pass') is-invalid @enderror"  
                      name="konfirm_pass" aria-describedby="" required value="{{ old('konfirm_pass') }}">
                  @error('konfirm_pass')<div class="invalid-feedback">{{ $message }}</div>@enderror  
              </div>
                    <button type="submit" class="btn bg-orange  mt-3" style="width:100%">Ubah Password</button>
                </form> 
              </div>
            </div>
        
          </div>
        </div>
        <!-- End Modal -->

      <script src="/js/script.js"></script>
      </body>
</html>