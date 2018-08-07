@extends('layouts.app')

@section('link')
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="css/animate.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- toast CSS -->
<link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
<!-- morris CSS -->
<link href="plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
<!-- chartist CSS -->
<link href="plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
<link href="plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<!-- Calendar CSS -->
<link href="plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="css/colors/default.css" id="theme" rel="stylesheet">
<!-- CSS tambahan -->
<link href="css/mystyle.css" rel="stylesheet">
<!-- Toggle CSS -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
{{-- Datatable --}}
<link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap4.min.css"/>



@endsection

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Different data widgets -->
        <!-- ============================================================== -->
        <!-- .row -->
        <br>
        <br>
        <div class="row">

            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            {{-- {{Auth::user()->id_jabatan}} --}}
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table color-table warning-table" id="example">
                            <thead>
                                <tr>
                                    <th colspan=6>ON PROGRESS</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="background-color: white; color: black;">No.</th>
                                    <th class="text-center" style="background-color: white; color: black;">Nama Kegiatan</th>
                                    <th class="text-center" style="background-color: white; color: black;">Nilai Kontrak</th>
                                    <th class="text-center" style="background-color: white; color: black;">Profit</th>
                                    <th class="text-center" style="background-color: white; color: black;">Ready For Service</th>
                                    <th class="text-center" style="background-color: white; color: black;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php $x=1; ?>
                                @foreach($proyek->where('status_pengajuan','=',NULL)->sortBy('id_proyek') as $listproyek)
                                <tr class="fuckOffPadding">
                                    <td style="vertical-align: middle;"><?php echo $x; $x=$x+1; ?></td>
                                    <td style="vertical-align: middle;">{{$listproyek->judul}}</td>
                                    <td style="vertical-align: middle;">{{number_format($listproyek->nilai_kontrak)}}</td>
                                    <td style="vertical-align: middle;">{{$listproyek->margin_tg}} %</td>
                                    <td style="vertical-align: middle;">{{date('d F Y', strtotime($listproyek->ready_for_service))}}</td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ route('pelanggan_single', ['id_pelanggan' => $listproyek->id_pelanggan, 'id_proyek' => $listproyek->id_proyek, 'id_aspek' => $listproyek->id_aspek]) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#view-{{$listproyek->id_proyek}}"><i class="fa fa-folder-open"></i></button>
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#upload-{{$listproyek->id_proyek}}"><i class="fa fa-upload"></i></button>
                                        <a href="{{ route('print', ['id' => $listproyek->id_proyek]) }}" class="btn btn-default"><i class="fa fa-download"></i></a>
                                        {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#delete-{{$listproyek->id_proyek}}"><i class="fa fa-trash"></i></button> --}}
                                        <div class="modal fade" id="view-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myLargeModalLabel" style="font-weight: 450;">{{$listproyek->judul}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <ul class="nav nav-pills m-b-30 ">
                                                                    <li class="active"> <a href="#profilpelanggan-onprogress-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="false">Profil Pelanggan</a> </li>
                                                                    <li class=""> <a href="#proyekkegiatan-onprogress-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="false">Proyek/Kegiatan</a> </li>
                                                                    <li> <a href="#aspekbisnis-onprogress-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="true">Aspek Bisnis</a> </li>
                                                                </ul>
                                                                <div class="tab-content br-n pn">
                                                                            <div id="profilpelanggan-onprogress-{{$listproyek->id_proyek}}" class="tab-pane active">
                                                                                    <table class="table table-borderless">
                                                                                            <tbody class="detail-text text-left">
                                                                                                <tr>
                                                                                                    <td style="width: 17%"><span class="text-muted" style="font-weight: 500">Nama Pelanggan</span></td>
                                                                                                    <td style="width: 1%"><span class="text-muted" style="font-weight: 500">:</td>
                                                                                                    <td><span>{{$listproyek->nama_pelanggan}}</span></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">Alamat Pelanggan</span></td>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                    <td>{{$listproyek->alamat_pelanggan}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">No Telepon</span></td>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                    <td>{{$listproyek->nomor_telepon}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">Jenis Pelanggan</span></td>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                    <td class="text-success">{{$listproyek->jenis_pelanggan}}</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                            </div>
                                                                            <div id="proyekkegiatan-onprogress-{{$listproyek->id_proyek}}" class="tab-pane">
                                                                                    <div class="row">
                                                                                            <div class="col-sm-12 col-lg-6">
                                                                                                <table class="table table-borderless">
                                                                                                    <tbody class="detail-text text-left">
                                                                                                        <tr>
                                                                                                            <td style="width: 32%"><span class="text-muted" style="font-weight: 500;">Judul Kegiatan</span></td>
                                                                                                            <td style="width: 0%"><span class="text-muted" style="font-weight: 500;">:</span></td>
                                                                                                            <td><span>{{$listproyek->judul}}</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Latar Belakang 1</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->latar_belakang_1}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Latar Belakang 2</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->latar_belakang_2}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Alamat Delivery</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->alamat_delivery}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Mekanisme Pembayaran</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->mekanisme_pembayaran}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Rincian Pola Pembayaran</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->rincian_pembayaran}} pembayaran oleh pelanggan</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">File</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><img src="{{asset('images/'. $listproyek->file)}}" style="width: 200px"></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div class="col-sm-12 col-lg-6">
                                                                                                <table class="table table-borderless">
                                                                                                    <tbody class="detail-text text-left">
                                                                                                        <tr>
                                                                                                            <td style="width: 39%"><span class="text-muted" style="font-weight: 500">Unit Kerja</span></td>
                                                                                                            <td style="width: 0%"><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td><span>{{$listproyek->nama_unit_kerja}}</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Nama Mitra</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->nama_mitra}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Skema Bisnis</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->saat_penggunaan}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Deadline</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->ready_for_service}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Tanggal Pemasukan dokumen</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->pemasukan_dokumen}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Ready for Service</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->ready_for_service}}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">Masa Kontrak</span></td>
                                                                                                            <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                            <td>{{$listproyek->masa_kontrak}}</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                            </div>
                                                                            <div id="aspekbisnis-onprogress-{{$listproyek->id_proyek}}" class="tab-pane">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12 col-lg-6">
                                                                                        <table class="table table-borderless">
                                                                                            <tbody class="detail-text text-left">
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Layanan Revenue</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td><span>{{$listproyek->layanan_revenue}}</span></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Beban Mitra</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->beban_mitra)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Nilai Kontrak</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->nilai_kontrak)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Margin (Rp)</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->rp_margin)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Margin (%)</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{$listproyek->margin_tg}}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-lg-6">
                                                                                        <table class="table table-borderless">
                                                                                            <tbody class="detail-text text-left">
                                                                                                <tr>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">Colocation</span></td>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                    <td><span>{{number_format($listproyek->colocation)}}</span></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">Revenue Connectivity</span></td>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                     <td>{{number_format($listproyek->revenue_connectivity)}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">Revenue CPE Proyek</span></td>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                    <td>{{number_format($listproyek->revenue_cpe_proyek)}}</td>
                                                                                                    </tr>
                                                                                                <tr>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">Revenue CPE Mitra</span></td>
                                                                                                    <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                    <td>{{number_format($listproyek->revenue_cpe_mitra)}}</td>
                                                                                                </tr>    
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>    
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="form-group m-b-0">
                                                            <table class="table table-borderless">
                                                                <form class="form-horizontal form-material" action="{{ route('status_update', ['id'=>$listproyek->id_proyek]) }}" method = "get">
                                                                    <tbody class="detail-text text-left">
                                                                        <tr id="footer-padding">
                                                                            <td style="font-weight: 450; color: black">Status Pengajuan
                                                                                @if($listproyek->status_pengajuan == NULL)
                                                                                <div class="btn-group btn-toggle" data-toggle="buttons">
                                                                                    <label class="btn btn-default">
                                                                                      <input type="radio" name="status_pengajuan" value="1">APPROVED
                                                                                    </label>
                                                                                    <label class="btn btn-success active">
                                                                                      <input type="radio" name="status_pengajuan" value="" checked="">NOT APPROVED
                                                                                    </label>
                                                                                  </div>
                                                                                @endif
                                                                            </td>   
                                                                        </tr>
                                                                        <tr id="footer-padding">
                                                                            <td style="font-weight: 450; color: black">Keterangan</td>
                                                                        </tr>
                                                                        <tr id="footer-padding">
                                                                            <td>
                                                                                    <textarea class="form-control" rows="5" name="keterangan_proyek" placeholder="Tulis keterangan tentang proyek di sini....">{{$listproyek->keterangan_proyek}}</textarea>
                                                                                    <button type="submit" style="float: left;" class="btn btn-danger waves-effect waves-light m-l-10">Save</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                 </form>   
                                                            </table>                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="upload-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myLargeModalLabel" style="font-weight: 450;">{{$listproyek->judul}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                @if($listproyek->bukti_scan == NULL)
                                                                    <form enctype="multipart/form-data" action="{{ route('bukti_insert', ['id_proyek' => $listproyek->id_proyek]) }}" method="post">
                                                                        {{ csrf_field() }}
                                                                        <label class="control-label">Upload File</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="file" class="form-control" name="bukti_scan">
                                                                        </div>
                                                                        <hr>
                                                                        <button type="submit" style="float: right;" class="btn btn-danger waves-effect waves-light m-t-10">Simpan</button>
                                                                    </form>
                                                                @else
                                                                    <div class="row">
                                                                        <img src="{{asset('bukti_scan/'. $listproyek->bukti_scan)}}" style="width: 500px">
                                                                    </div>
                                                                    <div class="row">
                                                                    <form action="{{ route('bukti_update', ['id_proyek' => $listproyek->id_proyek]) }}" method="post">
                                                                        {{ csrf_field() }}
                                                                        <hr>
                                                                        {{-- <input type="text" name="bukti_scan" value="NULL"> --}}
                                                                        <button type="submit" style="float: center;" class="btn btn-danger waves-effect waves-light m-t-10"><i class="fa fa-edit"></i> Edit</button>
                                                                        {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#view-{{$listproyek->id_proyek}}"><i class="fa fa-folder-open"></i></button> --}}
                                                                    </form>
                                                                        
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="delete-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myLargeModalLabel" style="font-weight: 450;">Hapus "{{$listproyek->judul}}"</h4> 
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal form-material" action = "{{ route('proyek_delete', ['id_proyek' => $listproyek->id_proyek]) }}" method = "get">
                                                            <h5> Apakah Anda yakin untuk menghapus proyek "{{$listproyek->judul}}"? </h5>
                                                            <div class="form-group m-b-0">
                                                                <a href="#" class="fcbtn btn btn-default btn-1f m-r-10 m-t-10" data-dismiss="modal" style="padding-top: 5.5px; padding-bottom: 5.5px; float: right;">Keluar</a>
                                                                <button type="submit" style="float: right;" class="btn btn-danger waves-effect waves-light m-t-10">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                            
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/.row -->
        <div class="row">
            <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table color-table success-table" id="example">
                            <thead>
                                <tr>
                                    <th colspan=3>APPROVED</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="background-color: white; color: black;">No.</th>
                                    <th class="text-center" style="background-color: white; color: black;">Nama Kegiatan</th>
                                    <th class="text-center" style="background-color: white; color: black;">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php $y=1; ?>
                                @foreach($proyek->where('status_pengajuan','=',1)->sortBy('id_proyek') as $listproyek)
                                {{-- {{ $listproyek->id_proyek }} --}}
                                <tr class="fuckOffPadding">
                                    <td style="vertical-align: middle;"><?php echo $y; $y=$y+1; ?></td>
                                    <td style="vertical-align: middle;">{{$listproyek->judul}}</td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ route('pelanggan_single', ['id_pelanggan' => $listproyek->id_pelanggan, 'id_proyek' => $listproyek->id_proyek, 'id_aspek' => $listproyek->id_aspek]) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#approve-{{$listproyek->id_proyek}}"><i class="fa fa-folder-open"></i></button>
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#upload-{{$listproyek->id_proyek}}"><i class="fa fa-upload"></i></button>
                                        <div class="modal fade" id="approve-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myLargeModalLabel">{{$listproyek->judul}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <ul class="nav nav-pills m-b-30 ">
                                                                        <li class="active"> <a href="#profilpelanggan-approved-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="false">Profil Pelanggan</a> </li>
                                                                        <li class=""> <a href="#proyekkegiatan-approved-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="false">Proyek/Kegiatan</a> </li>
                                                                        <li> <a href="#aspekbisnis-approved-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="true">Aspek Bisnis</a> </li>
                                                                    </ul>
                                                                    <div class="tab-content br-n pn">
                                                                                <div id="profilpelanggan-approved-{{$listproyek->id_proyek}}" class="tab-pane active">
                                                                                        <table class="table table-borderless">
                                                                                                <tbody class="detail-text text-left">
                                                                                                    <tr>
                                                                                                        <td style="width: 17%"><span class="text-muted" style="font-weight: 500">Nama Pelanggan</span></td>
                                                                                                        <td style="width: 1%"><span class="text-muted" style="font-weight: 500">:</td>
                                                                                                        <td><span>{{$listproyek->nama_pelanggan}}</span></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Alamat Pelanggan</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{$listproyek->alamat_pelanggan}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">No Telepon</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{$listproyek->nomor_telepon}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Jenis Pelanggan</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td class="text-success">{{$listproyek->jenis_pelanggan}}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                </div>
                                                                                <div id="proyekkegiatan-approved-{{$listproyek->id_proyek}}" class="tab-pane">
                                                                                        <div class="row">
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <table class="table table-borderless">
                                                                                                        <tbody class="detail-text text-left">
                                                                                                            <tr>
                                                                                                                <td style="width: 32%"><span class="text-muted" style="font-weight: 500;">Judul Kegiatan</span></td>
                                                                                                                <td style="width: 0%"><span class="text-muted" style="font-weight: 500;">:</span></td>
                                                                                                                <td><span>{{$listproyek->judul}}</span></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Alamat Delivery</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->alamat_delivery}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Rincian Pola Pembayaran</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->rincian_pembayaran}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">File</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><img src="{{asset('images/'. $listproyek->file)}}" style="width: 200px"></td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <table class="table table-borderless">
                                                                                                        <tbody class="detail-text text-left">
                                                                                                            <tr>
                                                                                                                <td style="width: 39%"><span class="text-muted" style="font-weight: 500">Unit Kerja</span></td>
                                                                                                                <td style="width: 0%"><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td><span>{{$listproyek->nama_unit_kerja}}</span></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Nama Mitra</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->nama_mitra}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Skema Bisnis</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>17 Juli 2018</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Deadline</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->ready_for_service}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Tanggal Pemasukan dokumen</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->pemasukan_dokumen}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Ready for Service</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->ready_for_service}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Masa Kontrak</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->masa_kontrak}}</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                </div>
                                                                                <div id="aspekbisnis-approved-{{$listproyek->id_proyek}}" class="tab-pane">
                                                                                        <table class="table table-borderless">
                                                                                                <tbody class="detail-text text-left">
                                                                                                    <tr >
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Layanan Revenue</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td><span>{{$listproyek->layanan_revenue}}</span></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Beban Mitra</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->beban_mitra)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Nilai Kontrak</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->nilai_kontrak)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Margin (Rp)</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->rp_margin)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Margin (%)</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{$listproyek->margin_tg}}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                    </div>
                                                     <div class="modal-footer">
                                                        <div class="form-group m-b-0">
                                                            <table class="table table-borderless">
                                                                <form class="form-horizontal form-material" action="{{ route('status_update', ['id'=>$listproyek->id_proyek]) }}" method = "get">
                                                                    <tbody class="detail-text text-left">
                                                                        <tr id="footer-padding">
                                                                            <td style="font-weight: 450; color: black">Status Pengajuan
                                                                                @if($listproyek->status_pengajuan == 1)
                                                                                <div class="btn-group btn-toggle" data-toggle="buttons">
                                                                                    <label class="btn btn-success active">
                                                                                      <input type="radio" name="status_pengajuan" value="1"> APPROVED
                                                                                    </label>
                                                                                    <label class="btn btn-default">
                                                                                      <input type="radio" name="status_pengajuan" value="" checked="">NOT APPROVED
                                                                                    </label>
                                                                                  </div>
                                                                                @endif
                                                                            </td>   
                                                                        </tr>
                                                                        <tr id="footer-padding">
                                                                            <td style="font-weight: 450; color: black">Keterangan</td>
                                                                        </tr>
                                                                        <tr id="footer-padding">
                                                                            <td>
                                                                                    <textarea class="form-control" rows="5" name="keterangan_proyek" placeholder="Tulis keterangan tentang proyek di sini....">{{$listproyek->keterangan_proyek}}</textarea>
                                                                                    <button type="submit" style="float: left;" class="btn btn-danger waves-effect waves-light m-l-10">Save</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                 </form>   
                                                            </table>                
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <div class="modal fade" id="upload-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myLargeModalLabel" style="font-weight: 450;">{{$listproyek->judul}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                @if($listproyek->bukti_scan == NULL)
                                                                    <form enctype="multipart/form-data" action="{{ route('bukti_insert', ['id_proyek' => $listproyek->id_proyek]) }}" method="post">
                                                                        {{ csrf_field() }}
                                                                        <label class="control-label">Upload File</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="file" class="form-control" name="bukti_scan">
                                                                        </div>
                                                                        <hr>
                                                                        <button type="submit" style="float: right;" class="btn btn-danger waves-effect waves-light m-t-10">Simpan</button>
                                                                    </form>
                                                                @else
                                                                    <div class="row">
                                                                        <img src="{{asset('bukti_scan/'. $listproyek->bukti_scan)}}" style="width: 500px">
                                                                    </div>
                                                                    <div class="row">
                                                                    <form action="{{ route('bukti_update', ['id_proyek' => $listproyek->id_proyek]) }}" method="post">
                                                                        {{ csrf_field() }}
                                                                        <hr>
                                                                        {{-- <input type="text" name="bukti_scan" value="NULL"> --}}
                                                                        <button type="submit" style="float: center;" class="btn btn-danger waves-effect waves-light m-t-10"><i class="fa fa-edit"></i> Edit</button>
                                                                        {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#view-{{$listproyek->id_proyek}}"><i class="fa fa-folder-open"></i></button> --}}
                                                                    </form>
                                                                        
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('print', ['id' => $listproyek->id_proyek]) }}" class="btn btn-default"><i class="fa fa-download"></i></a>
                                        {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#delete-{{$listproyek->id_proyek}}"><i class="fa fa-trash"></i></button> --}}
                                        <div class="modal fade" id="delete-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myLargeModalLabel" style="font-weight: 450;">Hapus "{{$listproyek->judul}}"</h4> 
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal form-material" action = "{{ route('proyek_delete', ['id_proyek' => $listproyek->id_proyek]) }}" method = "get">
                                                            <h5> Apakah Anda yakin untuk menghapus proyek "{{$listproyek->judul}}"? </h5>
                                                            <div class="form-group m-b-0">
                                                                <a href="#" class="fcbtn btn btn-default btn-1f m-r-10 m-t-10" data-dismiss="modal" style="padding-top: 5.5px; padding-bottom: 5.5px; float: right;">Keluar</a>
                                                                <button type="submit" style="float: right;" class="btn btn-danger waves-effect waves-light m-t-10">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table color-table danger-table" id="example">
                            <thead>
                                <tr>
                                    <th colspan=3>FAILED</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="background-color: white; color: black;">No.</th>
                                    <th class="text-center" style="background-color: white; color: black;">Nama Kegiatan</th>
                                    <th class="text-center" style="background-color: white; color: black;">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php $z=1; ?>
                                @foreach($proyek->where('status_pengajuan','=','2')->sortBy('id_proyek') as $listproyek)
                                <tr class="fuckOffPadding">
                                    <td style="vertical-align: middle;"><?php echo $z; $z=$z+1; ?></td>
                                    <td style="vertical-align: middle;">{{$listproyek->judul}}</td>
                                    <td style="vertical-align: middle;">
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#failed-{{$listproyek->id_proyek}}"><i class="fa fa-folder-open"></i></button>
                                        <div class="modal fade" id="failed-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myLargeModalLabel">{{$listproyek->judul}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <ul class="nav nav-pills m-b-30 ">
                                                                        <li class="active"> <a href="#profilpelanggan-failed-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="false">Profil Pelanggan</a> </li>
                                                                        <li class=""> <a href="#proyekkegiatan-failed-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="false">Proyek/Kegiatan</a> </li>
                                                                        <li> <a href="#aspekbisnis-failed-{{$listproyek->id_proyek}}" data-toggle="tab" aria-expanded="true">Aspek Bisnis</a> </li>
                                                                    </ul>
                                                                    <div class="tab-content br-n pn">
                                                                                <div id="profilpelanggan-failed-{{$listproyek->id_proyek}}" class="tab-pane active">
                                                                                        <table class="table table-borderless">
                                                                                                <tbody class="detail-text text-left">
                                                                                                    <tr>
                                                                                                        <td style="width: 17%"><span class="text-muted" style="font-weight: 500">Nama Pelanggan</span></td>
                                                                                                        <td style="width: 1%"><span class="text-muted" style="font-weight: 500">:</td>
                                                                                                        <td><span>{{$listproyek->nama_pelanggan}}</span></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Alamat Pelanggan</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{$listproyek->alamat_pelanggan}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">No Telepon</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{$listproyek->nomor_telepon}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Jenis Pelanggan</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td class="text-success">{{$listproyek->jenis_pelanggan}}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                </div>
                                                                                <div id="proyekkegiatan-failed-{{$listproyek->id_proyek}}" class="tab-pane">
                                                                                        <div class="row">
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <table class="table table-borderless">
                                                                                                        <tbody class="detail-text text-left">
                                                                                                            <tr>
                                                                                                                <td style="width: 32%"><span class="text-muted" style="font-weight: 500;">Judul Kegiatan</span></td>
                                                                                                                <td style="width: 0%"><span class="text-muted" style="font-weight: 500;">:</span></td>
                                                                                                                <td><span>{{$listproyek->judul}}</span></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Alamat Delivery</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->alamat_delivery}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Rincian Pola Pembayaran</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->rincian_pembayaran}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">File</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><img src="{{asset('images/'. $listproyek->file)}}" style="width: 200px"></td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <table class="table table-borderless">
                                                                                                        <tbody class="detail-text text-left">
                                                                                                            <tr>
                                                                                                                <td style="width: 39%"><span class="text-muted" style="font-weight: 500">Unit Kerja</span></td>
                                                                                                                <td style="width: 0%"><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td><span>{{$listproyek->nama_unit_kerja}}</span></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Nama Mitra</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->nama_mitra}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Skema Bisnis</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>17 Juli 2018</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Deadline</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->ready_for_service}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Tanggal Pemasukan dokumen</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->pemasukan_dokumen}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Ready for Service</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->ready_for_service}}</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">Masa Kontrak</span></td>
                                                                                                                <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                                <td>{{$listproyek->masa_kontrak}}</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                </div>
                                                                                <div id="aspekbisnis-failed-{{$listproyek->id_proyek}}" class="tab-pane">
                                                                                        <table class="table table-borderless">
                                                                                                <tbody class="detail-text text-left">
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Layanan Revenue</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td><span>{{$listproyek->layanan_revenue}}</span></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Beban Mitra</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->beban_mitra)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Nilai Kontrak</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->nilai_kontrak)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Margin (Rp)</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{number_format($listproyek->rp_margin)}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">Margin (%)</span></td>
                                                                                                        <td><span class="text-muted" style="font-weight: 500">:</span></td>
                                                                                                        <td>{{$listproyek->margin_tg}}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <a href="{{ route('print', ['id' => $listproyek->id_proyek]) }}" class="btn btn-default"><i class="fa fa-download"></i></a>
                                        {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#delete-{{$listproyek->id_proyek}}"><i class="fa fa-trash"></i></button> --}}
                                        <div class="modal fade" id="delete-{{$listproyek->id_proyek}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myLargeModalLabel" style="font-weight: 450;">Hapus "{{$listproyek->judul}}"</h4> 
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal form-material" action = "{{ route('proyek_delete', ['id_proyek' => $listproyek->id_proyek]) }}" method = "get">
                                                            <h5> Apakah Anda yakin untuk menghapus proyek "{{$listproyek->judul}}"? </h5>
                                                            <div class="form-group m-b-0">
                                                                <a href="#" class="fcbtn btn btn-default btn-1f m-r-10 m-t-10" data-dismiss="modal" style="padding-top: 5.5px; padding-bottom: 5.5px; float: right;">Keluar</a>
                                                                <button type="submit" style="float: right;" class="btn btn-danger waves-effect waves-light m-t-10">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <footer class="footer text-center"> 2018 &copy; PT Telekomunikasi Indonesia Tbk </footer>
</div>
@endsection

@section ('script')
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!--Counter js -->
<script src="plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="plugins/bower_components/counterup/jquery.counterup.min.js"></script>
<!-- chartist chart -->
<script src="plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
<script src="plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<!-- Sparkline chart JavaScript -->
<script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/cbpFWTabs.js"></script>
<script type="text/javascript">
(function() {
    [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
        new CBPFWTabs(el);
    });
});

$('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    if ($(this).find('.btn-primary').size()>0) {
        $(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
        $(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
        $(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
        $(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');
       
});
</script>
<script src="js/custom.min.js"></script>
<script src="js/dashboard1.js"></script>
<script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
{
    $('#example').DataTable(
    {
        "pagingType": "full_numbers"
    } );
    $('#example2').DataTable(
    {
        "pagingType": "full_numbers"
    } );
} );
</script>
<!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
@endsection