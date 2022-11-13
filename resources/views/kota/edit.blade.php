@extends('main')
@section('content')

<div class='row header-row mb-2' >
    <div class='col-md-9  py-4 rounded-col' style="background-color:white;color:#3c3b3b">
        <h3 class="">Update Data {{ $kota->nama_kota }}</h3>
        <div class="mb-0">
            <a href="/kota" style="color: rgb(6 148 241); text-decoration:none">
                <i style="font-size:90%;" class="bi bi-arrow-return-left mr-1"></i>
                <span style="font-size:90%;">Kembali ke daftar kota</span>
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
            <form action={!! "/kota/update/".$kota->id !!} method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama-kota" class="form-label">Nama Kota</label>
                    <input type="text" class="form-control" id="nama-kota" name="nama_kota" aria-describedby="" value="{{ $kota->nama_kota }}"required>
                </div>
                <div class="mb-1">
                    <div class="form-group">
                        <div class="radio inlineblock mr-3">
                            <input type="radio" name="ln" id="radio-aktif" class="with-gap" value="N" {{ $kota->ln=='N'?"checked":"" }}>
                            <label for="radio-aktif">Dalam Negeri</label>
                        </div>                                
                        <div class="radio inlineblock">
                            <input type="radio" name="ln" id="radio-tidak-aktif" class="with-gap" value="Y" {{ $kota->ln=='Y'?"checked":"" }}>
                            <label for="radio-tidak-aktif">Luar Negeri</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="provinsi">Provinsi</label>
                    <select class="form-control js-example-basic-single high-select" id="provinsi" name="provinsi" required>
                        <option value="">Pilih Provinsi ... </option>
                        @foreach($provinsis ?? '' as $provinsi)
                        <option value="{{ $provinsi->id }}" {{ $provinsi->id==$kota->id_provinsi? "selected":"" }} > {{ $provinsi->nama_provinsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="pulau">Pulau</label>
                    <select class="form-control js-example-basic-single high-select" id="pulau" name="pulau">
                        <option value="">Pilih Pulau ... </option>
                        @foreach($pulaus as $pulau)
                            <option value="{{ $pulau->id }}" {{ $pulau->id==$kota->id_pulau? "selected":"" }} >{{ $pulau->nama_pulau }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" aria-describedby="" value="{{ $kota->latitude }}" required>
                </div>
                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" aria-describedby="" value ="{{ $kota->longitude }}" required>
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
    </script>
    

@endsection

