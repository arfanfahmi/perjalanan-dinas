@extends('main')
@section('content')

    <div class='row header-row mb-3' >
        <div class='col-md-9  py-4 rounded-col bg-white'>
            <h3 class="">Data Master User</h3>
        </div>
        <div class='col-md-3 py-4'>
            <a href="/user/add">
            <button type="button" class="btn btn-primary bg-tv border-0" data-toggle="modal" data-target="#modalTambahData"            
            style='float:right;background-color:rgb(6 148 241);'>
            <i class="bi bi-journal-plus mr-2"></i>
            Tambah User               
            </button>
            </a>
        </div>
    </div>    

    @if(session()->has('success-delete'))
    <div class="alert alert-danger alert-dismissible-lg fade show" role="alert">
        <strong>Data telah dihapus</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" style='font-size:1.5rem'>&times;</span>
        </button>
    </div>
    @endif

    <table class="table table-borderless">
    <thead>
        <tr>
        
        <th scope="col">Pegawai</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col" ></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>            
            <td>
                <span class="" style='font-size:15px'>{{ strtoupper($user->nama_pegawai) }}</span><br>
                <span class="badge bg-abu font-90">NRP : {{ $user->nrp }}</span>
            </td>
            <td>
                <span class="">{{ $user->username }}</span>
            </td>
           
            <td>
                <span class="badge-lg bg-abu">{{ $user->email }}</span>
            </td>
            <td>
                <span class="badge {{ $user->role=='sdm'?'bg-outline-orange':($user->role=='admin'?'bg-outline-tv':'bg-outline-green') }}">{{ strtoupper($user->role)}}</span>
            </td>
            
            <td align='right'>
                <a class="btn btn-outline-tv btn-sm btn-round" href="{!! url("/user/edit/".$user->username) !!}">
                    <i class="bi bi-pencil-square"></i>
                </a>
                @if (Auth::user()->username!=$user->username)
                <a class="btn btn-outline-orange btn-sm btn-round button-hapus" href="{!! url("/user/destroy/".$user->username) !!}">
                    <i class="bi bi-trash"></i>
                </a>
                @else
                <button class="btn bg-orange btn-sm btn-round" href="">
                    <i class="">NA</i>
                </button>
                @endif
            </td>
        </tr>
        @endforeach
       
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
    {!! $users->links('pagination::bootstrap-4') !!}
  </div>

  
  <form action="/user/destroy/" id="form-hapus-data" method="post" accept-charset="utf-8">
    @method('DELETE')
    @csrf
  </form>

  <script>
    $(".button-hapus").on("click", function(e){
        e.preventDefault();
        
        swal({
        title: "Hapus Data?",
        text: "Aksi ini tidak dapat dibatalkan",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {             
                var action = $(this).attr('href');
                $("form[id='form-hapus-data']").attr("action", action);
                $("#form-hapus-data").submit();
            }
        });
        
    });
    
  </script>
    
@endsection

