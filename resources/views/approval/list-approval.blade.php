@extends('main')
@section('content')



    <div class='row header-row mb-3' >
        <div class='col-md-9  py-4 rounded-col' style="background-color:white;color:#3c3b3b">
            <h3 class=""><i class="bi bi-list-check mr-2" style="font-size:1.5rem"></i> Pengajuan Perdin Baru</h3>
        </div>
        <div class='col-md-3 py-4'>
            <a href="/approval/history">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahData"            
            style='float:right;background-color:rgb(6 148 241);color:#fff;border:0px'>
            <i class="bi bi-book mr-2" style="color:#fff"></i>
                Histori Pengajuan     
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
        <th scope="col" width='2%'>#</th>
        <th scope="col" width='18%'>Nama Pegawai</th>
        <th scope="col" width='40%'>Tujuan dan Waktu</th>
        <th scope="col" width='30%'>Keterangan</th>
        <th scope="col" style='text-align:center'>Aksi</th>
        </tr>
    </thead>
    @if(!empty($perdins))
        <tbody>
            <?php $no=0?>

            @foreach($perdins as $perdin)
            <?php
                $origin = new DateTimeImmutable($perdin->tgl_berangkat);
                $target = new DateTimeImmutable($perdin->tgl_kembali);
                $interval = $origin->diff($target);
                
                $no++;
            ?>
            <tr>    
                <td>{{ $no }}</td>
                <td>{{ $perdin->nama_pegawai }}</td>        
                <td>
                    <span class="">{{ $perdin->kota_asal }}</span>
                    <i class="bi bi-arrow-right-square mx-2"></i>
                    <span class="mb-3">{{ $perdin->kota_tujuan }}</span><br>
                    <div class='mt-3'>
                    <span class="">{{ date_format($origin,"d M") }}</span> - 
                    <span class="">{{ date_format($target,"d M Y") }}</span>
                    <span class="ml-2 color-blue"><i class="bi bi-clock color-blue mr-1" style='font-size:90%'></i>{{ $interval->days+1}} hari</span>
                </div>

                </td>
                <td>
                    <span class="">{{ strlen($perdin->keterangan)>=80? substr($perdin->keterangan,0,80):$perdin->keterangan }}</span>
                </td>
                
                <td align='center'>
                    <button class="btn btn-sm btn-outline-orangen bg-orange button-detail" id={{ $perdin->id }} data-toggle="modal" data-target="#modalTambah">Detail</button>
                </td>
            </tr>
            @endforeach
        
        </tbody>
    @else
        <tbody>
            <tr>    
                <td colspan="5" align="center" class="py-3"><h5><i class="bi bi-check2-square mr-2" style="font-size:20px"></i>Belum ada pengajuan baru</h5></td>
            </tr>
        </tbody>
    @endif
  </table>

  <!--pagination-->
  <div class="d-flex justify-content-center">
    
  </div>

  
    <!-- Modal -->
  <div id="modalTambah" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:0px">
          <h4 id='nama-pegawai'></h4>
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
           
             
              <div class="row">
                  <div class="col-md-6">
                      <label for="id_kota_asal" class="form-label" >Kota</label>
                      <select class="form-control js-example-basic-single select-on-modal" 
                          name="id_kota_asal" style="position:block !important; width:100%" required disabled>
                          <option value="">Kota Asal </option>
                          @foreach($kotas as $kota)
                              <option value="{{ $kota->id }}">{{ strtoupper($kota->nama_kota) }}</option>
                          @endforeach
                      </select>
                  </div>
  
                  <div class="col-md-6">
                      <label class="form-label" for="id_kota_tujuan">&nbsp</label>
                      <select class="form-control js-example-basic-single select-on-modal" 
                          name="id_kota_tujuan"  style="position:block !important; width:100%" required disabled>
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
                          <input type="date" id="tgl_berangkat" class="form-control" name="tgl_berangkat" aria-describedby="" required min="{{ date('Y-m-d') }}" max={{ date('Y-m-d', strtotime('+1 year')) }} disabled>
                          
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="mt-3">
                          <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                          <input type="date" class="form-control" name="tgl_kembali" aria-describedby="" required min="{{ date('Y-m-d') }}" max={{ date('Y-m-d', strtotime('+1 year')) }} disabled>
                      </div>
                  </div>
                  
              </div>
              <div id="message" class="error-message my-2"></div> 
              <div class="mb-3 mt-3">
                  <label for="keterangan" class="form-label">Keterangan</label>
                  <textarea rows='4' maxlength="160" class="form-control" name="keterangan" aria-describedby="" required style='resize:none' disabled></textarea>
              </div>
  
                <table class='table table-borderless table-info-perdin'>
                    <thead>
                        <th width='25%'>Total hari</th>
                        <th width='45%'>Jarak Tempuh</th>
                        <th width='30%'>Total Uang Perdin</th>
                    </thead>
                    <tbody>
                        <td><h5 id="jumlah-hari"></h5></td>
                        <td>
                            <h5 id="jarak"></h5>
                            <p class='mb-0' style="color:#3e3e3e" id="ongkos-per-hari">Rp 350.000/hari</p>
                            <p style='font-size:75%;color:#3e3e3e' id = "kategori-perdin">Jarak > 60 km</p>
                        </td>
                        <td><h5 id="ongkos-total"></h5></td>
                    </tbody>
                </table>
                <div style="text-align:center">
            
              <form class="form-approval" method="POST" style='display:inline'>
                @csrf
                <input name="status" value="ditolak" type="hidden" class="id">
                <button type="submit" style="text-align:center" class="btn bg-red mr-3">Reject</button>  
              </form>

              <form action="" class="form-approval" method="POST" style='display:inline'>
                @csrf
                 <input name="status" value="disetujui" type="hidden" class="id">
                 <button type="submit" class="btn bg-tv">Approve</button>
              </form>   
             </div>
          
        </div>
      </div>
  
    </div>
  </div>
  <!-- End Modal -->

  <script>
    $(".button-detail").on("click", function(e){
        $id = this.id;
        
        $link = `{{ url("/approval/show/") }}`;
        $.ajax({
            type:"get",
            url:`{{ url("/approval/show/") }}`+"/"+$id,
            success: function(data) {
                data = JSON.parse(data);
                $(`select[name='id_kota_asal']`).val(data.id_kota_asal).change();
                $(`select[name='id_kota_tujuan']`).val(data.id_kota_tujuan).change();
                $(`input[name='tgl_berangkat']`).val(data.tgl_berangkat);
                $(`input[name='tgl_kembali']`).val(data.tgl_kembali);
                $(`textarea[name='keterangan']`).val(data.keterangan);
                $(`#jarak`).html(Math.floor(data.jarak)+" km");
                $(`#kategori-perdin`).html(data.kategori_perdin);
                $(`#nama-pegawai`).html("Detail Perdin - "+data.nama_pegawai);

                var jumlah_hari = data.jumlah_hari;
                $(`#jumlah-hari`).html(jumlah_hari+" hari");

                var mata_uang= (data.luar_negeri=="Y") ? "USD ": "Rp. ";
                $(`#ongkos-per-hari`).html(mata_uang + data.ongkos_per_hari.toLocaleString() + "/hari");
                $(`#ongkos-total`).html(mata_uang + (data.ongkos_per_hari*jumlah_hari).toLocaleString());

                //form approval
                $(".form-approval").attr("action", `{{ url("/approval/update/") }}` + "/" + data.id_perdin);

            },
            error:function(error) {
                console.log(error);
            }
        });
    });
  </script>
    
@endsection

