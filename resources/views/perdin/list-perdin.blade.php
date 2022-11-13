@extends('main')
@section('content')
    <div class='row header-row mb-3' >
        <div class='col-md-9  py-4 rounded-col bg-white'>
            <h3 class="">Perjalanan Dinas Anda</h3>
        </div>
        <div class='col-md-3 py-4'>
            
            <button type="button" class="btn btn-primary bg-tv border-0" data-toggle="modal" data-target="#modalTambah"            
            style='float:right;background-color:rgb(6 148 241);'>
            <i class="bi bi-calendar-plus mr-2"></i>
                Ajukan Perdin   
            </button>
            
        </div>
    </div>    

    <table class="table table-borderless" id="tabel-perdin">
    <thead>
        <tr>
        
        <th scope="col">Kota</th>
        <th scope="col" width='40%'>Keterangan</th>
        <th scope="col" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
      
        @foreach($perdins as $perdin)
        <?php
            $origin = new DateTimeImmutable($perdin->tgl_berangkat);
            $target = new DateTimeImmutable($perdin->tgl_kembali);
            $interval = $origin->diff($target);
            //echo $interval->format('%R%a days');
            //echo date('M', strtotime($perdin->tgl_berangkat));
        ?>
        <tr>            
            <td>
                <span class="">{{ $perdin->kota_asal }}</span>
                <i class="bi bi-arrow-right-square mx-2"></i>
                <span class="mb-3">{{ $perdin->kota_tujuan }}</span><br>
                <div class='mt-3'>
                    <span class="">{{ date_format($origin,"d M") }}</span> - 
                    <span class="">{{ date_format($target,"d M Y") }}</span>
                    <span class="ml-2 color-blue"><i class="bi bi-clock color-blue mr-1 font-90"></i>{{ $interval->days+1}} hari</span>
                </div>

            </td>
            <td>
                <span class="">{{ $perdin->keterangan}}</span>
            </td>
            
            <td align='center'>
                <span class="badge badge-lg 
                    {{ $perdin->status=='diajukan'?'bg-outline-orange':
                        ($perdin->status!='disetujui'? 'bg-outline-red' : 'bg-outline-green') 
                    }}"
                    >
                    {{ ucwords($perdin->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
    
  </div>

  <!-- Modal -->
<div id="modalTambah" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4>Detail Perjalanan Dinas</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <form action="/perdin/store" method="POST" id="form-tambah-perdin">
            <input type="hidden" value="{{ Auth::user()->username }}" name="username">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="id_kota_asal" class="form-label" >Pilih Kota</label>
                    <select class="form-control js-example-basic-single select-on-modal" 
                        name="id_kota_asal" style="position:block !important; width:100%" required>
                        <option value="">Kota Asal </option>
                        @foreach($kotas as $kota)
                            <option value="{{ $kota->id }}">{{ strtoupper($kota->nama_kota) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="id_kota_tujuan">&nbsp</label>
                    <select class="form-control js-example-basic-single select-on-modal" 
                        name="id_kota_tujuan"  style="position:block !important; width:100%" required>
                        <option value="">Kota Tujuan </option>
                        @foreach($kotas as $kota)
                            <option value="{{ $kota->id }}">{{ strtoupper($kota->nama_kota) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mt-3">
                        <label for="tgl_berangkat" class="form-label">Tanggal Berangkat</label>
                        <input type="date" id="tgl_berangkat" class="form-control" name="tgl_berangkat" aria-describedby="" required min="{{ date('Y-m-d') }}" max={{ date('Y-m-d', strtotime('+1 year')) }}>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tgl_kembali" aria-describedby="" required min="{{ date('Y-m-d') }}" max={{ date('Y-m-d', strtotime('+1 year')) }}>
                    </div>
                </div>
                
            </div>
            <div id="message" class="error-message my-2"></div> 
            <div class="mb-3 mt-3">
                <label for="keterangan" class="form-label">Keterangan (max. 160 karakter)</label>
                <textarea rows='4' maxlength="160" class="form-control" name="keterangan" aria-describedby="" required></textarea>
            </div>

            <div class="bg-abu" id="info-total-perdin">
                <h5>Total Perjalanan Dinas</h5>
                <h4 id='jumlah-hari' class="color-blue"></h4>
            </div>
            <button type="submit" class="btn bg-orange  mt-3 btn-block">Simpan</button>
        </form> 
      </div>
    </div>

  </div>
</div>
<!-- End Modal -->

<script>
    
    var tglBerangkat = $(`input[name='tgl_berangkat']`).val();
    var tglKembali = $(`input[name='tgl_kembali']`).val();
    var cekTglBerangkat = isValidDate(tglBerangkat);
    var cekTglKembali = isValidDate(tglKembali);
    $(document).ready(function(){
        $(`input`).change(function(){
            $("#message, #jumlah-hari").html("");

            var tglBerangkat = $(`input[name='tgl_berangkat']`).val();
            var tglKembali = $(`input[name='tgl_kembali']`).val();
            var cekTglBerangkat = isValidDate(tglBerangkat);
            var cekTglKembali = isValidDate(tglKembali);

            if (cekTglBerangkat && cekTglKembali) {
                if (tglKembali < tglBerangkat) {
                    $("#message").html("Tanggal Kembali harus >= Tanggal Berangkat!");
                } else {
                    var selisih = Math.floor((new Date(tglKembali).getTime() - new Date(tglBerangkat).getTime())/(24*3600*1000)+1);
                    $("#jumlah-hari").html(selisih+" hari");
                }
            } 
        });
    });

    $(document).ready(function(){
        $("#form-tambah-perdin").unbind('submit').bind('submit',function(e) { 
            e.preventDefault();

            var tglBerangkat = $(`input[name='tgl_berangkat']`).val();
            var tglKembali = $(`input[name='tgl_kembali']`).val();
            var cekTglBerangkat = isValidDate(tglBerangkat);
            var cekTglKembali = isValidDate(tglKembali);

            var link = `{{ url("/perdin/cek-perdin-by/".Auth::user()->username."/") }}`;
            if (cekTglBerangkat && cekTglKembali && tglBerangkat<=tglKembali) {
                $.ajax({
                    type: "GET",
                    url: link + `/`+tglBerangkat+'/'+tglKembali,
                    success: function (data) {    
                        data = JSON.parse(data);
                        
                        //Jika tidak ada pengajuan pada rentang tgl berangkat dan tgl kembali 
                        //(data kosong) maka submit form
                        if (jQuery.isEmptyObject(data)){
                            $("#form-tambah-perdin")[0].submit();
                        } else {
                            $("#message").html("Sudah ada pengajuan pada rentang tanggal tersebut");
                        }
                    },
                    error: function (data) {    
                        console.log("error");                    
                    }
                });
            }    
        });     
    });
    

    function isValidDate(dateString) {
        var regEx = /^\d{4}-\d{2}-\d{2}$/;
        if(!dateString.match(regEx)) return false;  // Invalid format
        var d = new Date(dateString);
        var dNum = d.getTime();
        if(!dNum && dNum !== 0) 
            return false; // NaN value, Invalid date
        
        return d.toISOString().slice(0,10) === dateString;;
    }
  </script>
    
@endsection

