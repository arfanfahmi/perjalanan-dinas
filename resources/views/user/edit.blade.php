@extends('main')
@section('content')

<div class='row header-row mb-2' >
    <div class='col-md-9  py-4 rounded-col' style="background-color:white;color:#3c3b3b">
        <h3 class="">Update Data User</h3>
        <div class="mb-0">
            <a href="/user" style="color: rgb(6 148 241); text-decoration:none">
                <i style="font-size:90%;" class="bi bi-arrow-return-left mr-1"></i>
                <span style="font-size:90%;">Kembali ke daftar user</span>
            </a>
        </div>
    </div>
    <div class='col-md-3 py-4'>
       
    </div>
</div>    
<div class='card input-section mt-3'>
  <div class='card-body'>
    <div class='row'>
        <div class='col-md-6'>
            <form action="{{ url('/user/update/'.$user->username) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror"  
                        name="username" aria-describedby="" required value="{{ $user->username }}" disabled>
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror  
                </div>
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror"  
                        name="nama_pegawai" aria-describedby="" required value="{{ $user->nama_pegawai }}">
                    @error('nama_pegawai')<div class="invalid-feedback">{{ $message }}</div>@enderror 
                </div>
                <div class="mb-3">
                    <label for="nrp" class="form-label">NRP</label>
                    <input type="text" class="form-control @error('nrp') is-invalid @enderror"  
                        name="nrp" aria-describedby="" required value="{{ $user->nrp }}">
                    @error('nrp')<div class="invalid-feedback">{{ $message }}</div>@enderror 
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                        name="email" aria-describedby="" required value="{{ $user->email }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror 
                </div>
                
                <div class="mb-3">
                    <label class="form-label" for="role">Pilih Role dalam Aplikasi</label>
                    <select class="form-control js-example-basic-single high-select @error('role') is-invalid @enderror" 
                        name="role" required {{Auth::user()->username==$user->username?'disabled="disabled"':''  }}>
                        <option value="">Pilih role ... </option>
                        @foreach($roles as $i=>$role)
                        <option value="{{ $roles[$i] }}" {{ $roles[$i]==$user->role?'selected':'' }}>{{ strtoupper($roles[$i]) }}</option>
                        @endforeach
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror 
                </div>

                <button type="submit" class="btn bg-orange" style="width:100%">Simpan</button>
            </form> 
        </div>    
    </div> 
  </div>   
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $('input').change(function() {
        $(this).removeClass('is-invalid');
    });
    
    $('select').change(function() {
        $(this).removeClass('error-input');
    });
</script>
    

@endsection

