<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AspekBisnis;
use App\Jabatan;
use App\LatarBelakang;
use App\Mitra;
use App\Pelanggan;
use App\Proyek;
use App\User;
use App\UnitKerja;
use DB;
use Auth;
use Session;
use Telegram\Bot\Api;

class AMController extends Controller
{
	public function _construct()
	{
		$this->middleware('auth');
	}


	///////////////////// PELANGGAN ////////////////////////////
	public function indexPelanggan()
	{
        $auth = Auth::user()->id;
        
		$pelanggan = DB::table('pelanggan')->get();
		$proyek = DB::table('proyek')->get();
		return view('AM.form-pelanggan', ['pelanggan'=>$pelanggan, 'auth'=>$auth, 'proyek'=>$proyek]);
	}

    public function insertPelanggan(Request $request)
    {
		$pelanggan = New Pelanggan;
		$pelanggan->id_pelanggan = $request->input('id_pelanggan');
		$pelanggan->nama_pelanggan = $request->input('nama_pelanggan');
		$pelanggan->nomor_telepon = $request->input('nomor_telepon');
		$pelanggan->alamat_pelanggan = $request->input('alamat_pelanggan');
		$pelanggan->jenis_pelanggan = $request->input('jenis_pelanggan');
		$pelanggan->save();

		$getID = $pelanggan->id_pelanggan;

		$proyek = New Proyek;
		$proyek->id_proyek = $request->input('id_proyek');
		$proyek->id_pelanggan = $request->input('id_pelanggan',$getID);
		$proyek->id_users = Auth::user()->id;
		$proyek->save();

		// dd($pelanggan,$proyek);
		return redirect()->route('proyek', ['id_proyek' => $proyek->id_proyek, 'id_pelanggan'=>$pelanggan->id_pelanggan]);
	
	}

	public function singlePelanggan($id_pelanggan,$id_proyek)
    {
    	$data['proyek'] = Proyek::find($id_proyek)->where('id_proyek',$id_proyek)->get();
		$data['pelanggan'] =Pelanggan::find($id_pelanggan)->where('id_pelanggan',$id_pelanggan)->get();
    	return view('AM.form-pelanggan-update',$data);
    }

	public function updatePelanggan(Request $request,$id_pelanggan,$id_proyek)
    {
    	$pelanggan = Pelanggan::find($id_pelanggan);
		$pelanggan->id_pelanggan = $request->input('id_pelanggan',$id_pelanggan);
		$pelanggan->nama_pelanggan = $request->input('nama_pelanggan');
		$pelanggan->nomor_telepon = $request->input('nomor_telepon');
		$pelanggan->alamat_pelanggan = $request->input('alamat_pelanggan');
		$pelanggan->jenis_pelanggan = $request->input('jenis_pelanggan');
		$pelanggan->save();
    	
    	$proyek = Proyek::find($id_proyek);
		$proyek->id_proyek = $request->input('id_proyek',$id_proyek);
		$proyek->id_pelanggan = $request->input('id_pelanggan',$id_pelanggan);
		$proyek->id_users = Auth::user()->id;
		$proyek->save();

    	return redirect()->route('proyek', ['id_proyek' => $proyek->id_proyek, 'id_pelanggan'=>$pelanggan->id_pelanggan]);
    }

	public function deletePelanggan($id)
	{
    	DB::table('pelanggan')->where('id_pelanggan',$id)->delete();
    	return redirect()->route('pelanggan');
    }


    //////////////////////// PROYEK /////////////////////////////
	public function indexProyek($id_proyek,$id_pelanggan)
    {
    	$data['proyek'] = Proyek::find($id_proyek)->where('id_proyek',$id_proyek)->get();
		$data['pelanggan'] =Pelanggan::find($id_pelanggan)->select('id_pelanggan')->where('id_pelanggan',$id_pelanggan)->get();
		$data['unit'] = DB::table('unit_kerja')->select('id_unit_kerja','nama_unit_kerja')->orderBy('nama_unit_kerja')->get();
		$data['mitra'] = DB::table('mitra')->select('id_mitra','nama_mitra')->orderBy('nama_mitra')->get();
    	return view('AM.form-proyek',$data);
    }

	public function insertProyek(Request $request,$id_proyek,$id_pelanggan)
    {
		$proyek = Proyek::find($id_proyek);
		// dd($proyek);
		$proyek->id_proyek = $request->input('id_proyek',$id_proyek);
		$proyek->id_mitra = $request->input('id_mitra');
		$proyek->id_pelanggan = $request->input('id_pelanggan',$id_pelanggan);
		$proyek->judul = $request->input('judul');
		$proyek->id_unit_kerja = $request->input('id_unit_kerja');
		$proyek->saat_penggunaan = $request->input('saat_penggunaan');
		$proyek->pemasukan_dokumen = $request->input('pemasukan_dokumen');
		$proyek->ready_for_service = $request->input('ready_for_service');
		$proyek->skema_bisnis = $request->input('skema_bisnis');
		$proyek->masa_kontrak = $request->input('masa_kontrak');
		// $proyek->jenis_pelanggan = $request->input('jenis_pelanggan');
		$proyek->alamat_delivery = $request->input('alamat_delivery');
		$proyek->masa_kontrak = $request->input('masa_kontrak');
		$proyek->save();

		$getID = $proyek->id_proyek;

		$aspek = New AspekBisnis;
		$aspek->id_aspek = $request->input('id_aspek');
		$aspek->id_proyek = $request->input('id_proyek',$getID);
		$aspek->save();

		// dd($proyek,$aspek);
		return redirect()->route('aspek', ['id_aspek' => $aspek->id_aspek, 'id_proyek' => $proyek->id_proyek]);
	}

	public function singleProyek($id_proyek)
    {
    	$data['proyek'] = Proyek::find($id_proyek)->where('id_proyek',$id_proyek)->get();
		$data['pelanggan'] = DB::table('pelanggan')->select('id_pelanggan')->get();
		$data['unit'] = DB::table('unit_kerja')->select('id_unit_kerja','nama_unit_kerja')->orderBy('nama_unit_kerja')->get();
		$data['mitra'] = DB::table('mitra')->select('id_mitra','nama_mitra')->orderBy('nama_mitra')->get();
    	return view('AM.form-proyek',$data);
    }

	public function updateProyek(Request $request, $id)
    {
    	DB::table('proyek')->where('id_proyek',$id)->update($request->all());
    	return redirect('/AM-form-proyek');
    }


    /////////////////////////////// ASPEK ///////////////////////////
	public function indexAspek($id_aspek,$id_proyek)
	{
		$data['aspek'] = AspekBisnis::find($id_aspek)->select('id_aspek')->where('id_aspek',$id_aspek)->get();
		$data['proyek'] = Proyek::find($id_proyek)->select('id_proyek')->where('id_proyek',$id_proyek)->get();
		return view('AM.form-aspek',$data);
	}

    public function insertAspek(Request $request,$id_aspek,$id_proyek)
    {
		$aspek = AspekBisnis::find($id_aspek);
		$aspek->id_aspek = $request->input('id_aspek',$id_aspek);
		$aspek->id_proyek = $request->input('id_proyek',$id_proyek);
		$aspek->layanan_revenue = $request->input('layanan_revenue');
		$aspek->beban_mitra = $request->input('beban_mitra');
		$aspek->nilai_kontrak = $request->input('nilai_kontrak');
		$aspek->margin_tg = $request->input('margin_tg');
		$aspek->rp_margin = $request->input('rp_margin');
		$aspek->save();

		$proyek = DB::table('proyek')
            ->leftJoin('mitra', 'proyek.id_mitra', '=', 'mitra.id_mitra')
            ->where('proyek.id_proyek','=',$id_proyek)
			->first();
		// $proyek = DB::table('proyek')->select('judul')->where('id_proyek', $id_proyek)->get();
		$telegram = new Api('577845467:AAGE3dmgDDvE9MIDAY3Cyd9wYQQG07xF5Nk');
		
		$text = 
		"<b>ALERT!</b>
		terdapat proyek baru yakni <b>".$proyek->judul."</b>
		";

        $response = $telegram->sendMessage([
            'chat_id' => '502299226', 
            'text' => $text,
            'parse_mode' => 'HTML'
        ]);
        
        $messageId = $response->getMessageId();

		return redirect()->route('index');
	}

	public function indexUnitKerja()
	{
		$unit_kerja = DB::table('unit_kerja')->get();
		return view('AM.unit-kerja', ['unit_kerja'=>$unit_kerja]);
	}

	public function insertUnitKerja(Request $request)
	{
		$unit_kerja = new UnitKerja;
		$unit_kerja->id_unit_kerja = $request->input('id_unit_kerja');
		$unit_kerja->nama_unit_kerja = $request->input('nama_unit_kerja');
		$unit_kerja->deskripsi_unit_kerja = $request->input('deskripsi_unit_kerja');
		$unit_kerja->save();
		return redirect()->route('unit');
	}

	public function updateUnitKerja(Request $request, $id)
	{
		DB::table('unit_kerja')->where('id_unit_kerja',$id)->update($request->all());
		return redirect()->route('unit');
	}

	public function deleteUnitKerja($id)
	{
		DB::table('unit_kerja')->where('id_unit_kerja',$id)->delete();
		return redirect()->route('unit');
	}

	public function indexMitra()
	{
		$mitra = DB::table('mitra')->get();
		return view('AM.mitra', ['mitra'=>$mitra]);
	}

	public function insertMitra(Request $request)
	{
		$mitra = New Mitra;
		$mitra->id_mitra = $request->input('id_mitra');
		$mitra->nama_mitra = $request->input('nama_mitra');
		$mitra->deskripsi_mitra = $request->input('deskripsi_mitra');
		$mitra->save();
		return redirect()->route('mitra');
	}

	public function updateMitra(Request $request, $id)
    {
    	DB::table('mitra')->where('id_mitra',$id)->update($request->all());
    	return redirect()->route('mitra');
    }

    public function deleteMitra(Request $request, $id)
    {
    	DB::table('mitra')->where('id_mitra',$id)->delete();
    	return redirect()->route('mitra');
    }
}