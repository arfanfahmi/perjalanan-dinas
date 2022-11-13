<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <link rel="icon" href="/images/icon.png" type="image/x-icon">
    <title>Login Perdin Aira Tech</title>
  </head>
  <body>
    <div class="container">
        <div class='row '>
          <div class="col-md-4">
            <div class="card card-login px-3 pt-3 pb-5 center-screen">
              <div class="text-center mb-4">
                <img src="/images/icon.png" width="200px" height="auto" class="mb-4">
                <em><h3>Manage Your Official Trip</h3></em>
              </div>
              
              <form action="/login" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                        id="username" name="username" aria-describedby="" placeholder="Your username..." required>
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror  
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control  @error('password') is-invalid @enderror" 
                      name="password" aria-describedby="" 
                    placeholder="Your password..." required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror  
                </div>
                 
                <button class="btn btn-block btn-sm btn-round my-0 btn-login" name="btn-submit" id="btn-submit" type="submit">LOGIN</button> 
                    @if(session()->has('error'))
                    <div class="my-1 text-center mt-3" id="login-message">{{ session('error') }}</div>
                    @endif

                    <div class="mt-3 text-center">
                      <p>Belum punya akun? Silahkan hubungi administrator</p>
                    </div>
              </form> 
            </div>  
          </div>
          <div class="col-md-8 my-auto text-right">
                <img src="/images/login.png" alt="Register" class = "login-image">
                 <div class="copyright text-center">
                    ©<script>document.write(new Date().getFullYear())</script> Developed by Arfan Fahmi<br>
                      <a target="_blank" href="https://www.freepik.com/free-photos-vectors/computer">Computer vector created by fullvector - www.freepik.com</a>
                </div>
          </div>
        </div>
    </div>
  </body>
</html>