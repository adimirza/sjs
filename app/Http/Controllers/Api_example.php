<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Api_example extends Controller
{
    public function index()
    {
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "http://localhost/ponggol_3/public/restapi/public/pajak_daerah/pajak_daerah/index/jenis_pajak/");
		// curl_setopt($curl, CURLOPT_HEADER, 0);
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'accesskey: 636b54be6f68c',
			'Content-Type: application/json'
		));
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
			// 'signature' => '$2y$10$QOaX50RHSoQdM7i/JtTg3.eLWV/7.WcHaaX03mNswZznR.tN8ykA2',
			'token' => '7ef9a1404381e1c6664bc2b551c8e1af',
			// 'tahun' => '2020',
			// 'perubahan' => '4'
		]);
		// curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		$response = curl_exec($curl);
		// print_r($response);
		// die;
		curl_close($curl);
        $data['title'] = 'API Example';
        $data['data'] = json_decode($response, true);
		print_r($data['data']);
		die;
        return view('api_example.index', $data);
    }

	public function index_()
	{
		$url="http://localhost/ponggol_3/public/restapi/public/simpeg/kepegawaian/index/daftar_agama/";
		$accesskey="..."; //Kunci akses diperoleh dari permohonan akses requester
		$options=array('http'=>
				array(
					'method'=>"GET",
					// 'header'=>"AccessKey:$accesskey"
				),
				"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
		);
		$context=stream_context_create($options);
		$content=file_get_contents($url,true,$context);
		$obj = json_decode($content);
		print_r($obj);
	}

	public function index1()
	{
		$data = Http::get("http://localhost/ponggol_3/public/restapi/public/emonev/emonev_tegalkab/index/laporan_belanja_langsung_rank_terendah");
		return $data;
	}
}
