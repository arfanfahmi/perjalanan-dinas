@extends('main')
@section('content')

    <div class='row header-row mb-3' >
        <div class='col-md-9  py-4 rounded-col' style="background-color:white;color:#3c3b3b">
            <h3 class="">Data Master Kota</h3>
        </div>
        <div class='col-md-3 py-4'>
            <a href="kota/add">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahData"            
            style='float:right;background-color:rgb(6 148 241);color:#fff;border:0px'>
            <i class="bi bi-journal-plus mr-2" style="color:#fff"></i>
            Tambah Kota                  
            </button>
            </a>
        </div>
    </div>    
    
    <table class="table table-borderless">
    <thead>
        <tr>
        
        <th scope="col">Nama Kota</th>
        <th scope="col">Provinsi</th>
        <th scope="col">Luar Negeri</th>
        <th scope="col">Koordinat</th>
        <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kotas as $kota)
        <tr>
            
            <td>
                <span class="">{{ strtoupper($kota->nama_kota) }}</span><br>
                <span class="mt-2 badge bg-outline-orange">{{ $kota->nama_pulau }}</span>
            </td>
            <td><span>{{ $kota->nama_provinsi }}</span></td>
            <td align='center'> {{ $kota->ln=='Y'? 'YA' : 'Tidak' }}</td>
            <td><a target="_blank" href="{!! url("https://www.google.com/maps/search/".$kota->latitude."+".$kota->longitude) !!}">
                <span><i class="bi bi-geo-fill btn-outline-tv mb-2 mr-1"></i>{{ $kota->latitude }}, </span>
                <span>{{ $kota->longitude }}</span>
            </td>
            
            <td align='right'>
                <a class="btn btn-outline-tv btn-sm btn-round" href="{!! url("/kota/edit/".$kota->id) !!}">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a class="btn btn-outline-orange btn-sm btn-round" href="{!! url("/kota/destroy/".$kota->id) !!}" id='btn_delete'>
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
       
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
    {!! $kotas->links('pagination::bootstrap-4') !!}
  </div>

  
  <form action="/kota/destroy/" id="form-hapus-data" method="post" accept-charset="utf-8">
    @method('DELETE')
    @csrf
  </form>

  <script>
    $("#btn_delete").on("click", function(e){
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

