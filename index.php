<?php 
require __DIR__ . '/vendor/autoload.php';
require 'libs/NotORM.php'; 

use \Slim\App;

$app = new App();
require_once('libs/koneksi.php');
$app-> get('/', function(){
    echo "Hello Mbloo  ^_^ ";
});

$app ->get('/pojok', function() use($app, $db){
    // $ac["error"] = false;
    // $ac["status"]= true ;
	// $ac["message"] = "Berhasil mendapatkan data akte cerai";
    foreach($db->pojok() as $data){
        $ac[] = array(
            'id' => $data['id'],
            'foto' => $data['foto'],
            'judul_berita' => $data['judul_berita'],
            'tanggal_posting' => $data['tanggal_posting'],
            'isi_berita' => $data['isi_berita'],
            'penulis' => $data['penulis']
            );
    }
    echo json_encode($ac);
});

$app ->get('/berita', function() use($app, $db){
    // $ac["error"] = false;
    // $ac["status"]= true ;
	// $ac["message"] = "Berhasil mendapatkan data akte cerai";
    foreach($db->berita() as $data){
        $ac[] = array(
            'id' => $data['id'],
            'foto' => $data['foto'],
            'judul_berita' => $data['judul_berita'],
            'tanggal_posting' => $data['tanggal_posting'],
            'isi_berita' => $data['isi_berita'],
            'penulis' => $data['penulis']
            );
    }
    echo json_encode($ac);
});

$app ->get('/ac', function() use($app, $db){
    // $ac["error"] = false;
    // $ac["status"]= true ;
	// $ac["message"] = "Berhasil mendapatkan data akte cerai";
    foreach($db->view_ac() as $data){
        $ac[] = array(
            'id' => $data['perkara_id'],
            'tahun_ac' => $data['tahun_akta_cerai'],
            'nomor_ac' => $data['nomor_akta_cerai']
            );
    }
    echo json_encode($ac);
});

$app ->get('/ac/{id}', function($request, $response, $args) use($app, $db){
    $ac = $db->view_ac()->where('perkara_id',$args['id']);
    $acdetail = $ac->fetch();

    if ($ac->count() == 0) {
        $responseJson["error"]          = true;
        $responseJson["message"]        = "Akte Cerai Tidak Ditemukan";
    } else {
        $responseJson["error"]          = false;
        $responseJson["message"]        = "Berhasil mengambil data";
        $responseJson["tahun_ac"]       = $acdetail['tahun_akta_cerai'];
        $responseJson["nomor_ac"]       = $acdetail['nomor_akta_cerai'];
        $responseJson["tanggal_ac"]     = $acdetail['tanggal_ac'];
        $responseJson["tanggal_serah1"] = $acdetail['serah1'];
        $responseJson["tanggal_serah2"] = $acdetail['serah2'];
    }

    echo json_encode($responseJson); 
});

// dataumum web
$app ->get('/dataumum/{id}', function($request, $response, $args) use($app, $db){
    $du = $db->view_dataumum()->where('IDPerkara',$args['id']);
    $dudetail = $du->fetch();

    if ($du->count() == 0) {
        $responseJson["error"]          = true;
        $responseJson["message"]        = "Akte Cerai Tidak Ditemukan";
    } else {
        $responseJson["error"]          = false;
        $responseJson["message"]        = "Berhasil mengambil data";
        $responseJson["IDPerkara"]      = $dudetail['IDPerkara'];
        $responseJson["tanggal_daftar"] = $dudetail['tanggal_pendaftaran'];
        $responseJson["jenis_perkara"]  = $dudetail['jenisPerkara'];
        $responseJson["nomor_perkara"]  = $dudetail['noPerkara'];
        $responseJson["tanggal_surat"]  = $dudetail['tanggal_surat'];
        $responseJson["petitum"]        = $dudetail['petitumDakwaan'];
        $responseJson["status_akhir"]   = $dudetail['statusAkhir'];
        $responseJson["pihak_pertama"]  = $dudetail['pihakPertama'];
        $responseJson["pihak_kedua"]    = $dudetail['pihakKedua'];
        $responseJson["pihak_ketiga"]   = $dudetail['pihakKetiga'];
        $responseJson["pihak_keempat"]  = $dudetail['pihakKeempat'];
        $responseJson["tanggal_minut"]  = $dudetail['tanggal_minutasi'];
        $responseJson["tanggal_bht"]    = $dudetail['tanggal_bht'];
    }

    echo json_encode($responseJson); 
});
// riwayat
// $app ->get('/riwayat', function() use($app, $db){
// 	$dosen["error"] = false;
// 	$dosen["message"] = "Berhasil mendapatkan data riwayat";
//     foreach($db->view_riwayat() as $data){
//         $dosen['semuariwayat'][] = array(
//             'id' => $data['IDPerkara'],
//             'tahapan' => $data['tahapan'],
//             'proses' => $data['proses']
//             );
//     }
//     echo json_encode($dosen);
// });

$app ->get('/riwayat/{id}', function($request, $response, $args) use($app, $db){
    $riwayat["error"] = false;
    $riwayat["message"] = "Riwayat ditemukan";
    foreach($db->view_riwayat()->where('IDPerkara', $args['id']) as $data){
        $riwayat['riwayatdetil'][] = array(
            'id' =>$data['IDPerkara'],
            'tahapan' =>$data['tahapan'],
            'proses' =>$data['proses'],
            'tanggal' =>$data['tanggal']
        );
    }
    echo json_encode($riwayat); 
});
// end

// Transaksi
$app ->get('/transaksi/{id}', function($request, $response, $args) use($app, $db){
    $transaksi["error"] = false;
    $transaksi["message"] = "Transaksi ditemukan";
    foreach($db->view_transaksi()->where('IDPerkara', $args['id']) as $data){
        $transaksi['transaksidetil'][] = array(
            'id'                =>$data['ID'],
            'id_perkara'        =>$data['IDPerkara'],
            'jenis_transaksi'   =>$data['jenis_transaksi'],
            'tanggal_transaksi' =>$data['tanggal_transaksi'],
            'uraian'            =>$data['uraian'],
            'nominal'           =>$data['nominal'],
            'keterangan'        =>$data['keterangan']
        );
    }
    echo json_encode($transaksi); 
});
// end

// Sidang
$app ->get('/sidang/{id}', function($request, $response, $args) use($app, $db){
    $sidang["error"]                = false;
    $sidang["message"]              = "sidang ditemukan";
    foreach($db->view_sidang()->where('IDPerkara', $args['id']) as $data){
        $sidang['sidangdetil'][]    = array(
            'id'                =>$data['ID'],
            'id_perkara'        =>$data['IDPerkara'],
            'tanggal_sidang'    =>$data['tanggal_sidang'],
            'jam_sidang'        =>$data['jamSidang'],
            'jam_selesai'       =>$data['selesaiSidang'],
            'agenda'            =>$data['agenda'],
            'ruangan'           =>$data['ruangan'],
            'alasan_tunda'      =>$data['alasanDitunda']
        );
    }
    echo json_encode($sidang); 
});
// end

//run App
$app->run();