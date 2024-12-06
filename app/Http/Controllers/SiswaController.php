<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{

    public function show($id) {
        $siswa = Siswa::find($id);
        return response()->json($siswa);
    }

    public function getsiswa(){
        $dt_siswa=siswa::join('kelas','siswa.id_kelas','=','kelas.id_kelas')->get();
        return response()->json($dt_siswa);
    }

    public function createsiswa(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
            'id_kelas' => 'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }

        $save = Siswa::create([
            'nama'    =>$req->get('nama'),
            'tgl_lahir'        =>$req->get('tgl_lahir'),
            'gender'        =>$req->get('gender'),
            'alamat'        =>$req->get('alamat'),
            'no_tlp'      =>$req->get('no_tlp'),
            'id_kelas'      =>$req->get('id_kelas'),
        ]);
        if($save){
            return Response()->json(['status'=>true, 'message' => 'Sukses update siswa']);
        }else {
            return Response()->json(['status'=>false, 'message' => 'Gagal update siswa']);
     }

    }

//     public function updatesiswa(Request $req, $id)
//     {
//         $validaator = Validator::make($req->all(), [
//             'nama' => 'required',
//             'tgl_lahir' => 'required',
//             'gender' => 'required',
//             'alamat' => 'required',
//             'no_tlp' => 'required',
//             'id_kelas' => 'required'
//     ]);

//     if($validaator->fails()){
//         return response()->json($validaator->errors(),400);
//     }

//     $ubah = siswa::where('id',$id)->update([
//         'nama' => $req->get('nama'),
//         'tgl_lahir' => $req->get('tgl_lahir'),
//         'gender' => $req->get('gender'),
//         'alamat' => $req->get('alamat'),
//         'no_tlp' => $req->get('no_tlp'),
//         'id_kelas' => $req->get('id_kelas')
//     ]);

//     if($ubah){
//         return Response()->json(['status'=>true, 'message' => 'Sukses update siswa']);
//     }else {
//         return Response()->json(['status'=>false, 'message' => 'Gagal update siswa']);
//  }
//     }

    public function updatesiswa(Request $req, $id)
    {
        $validaator = Validator::make($req->all(), [
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
            'id_kelas' => 'required'
    ]);

    if($validaator->fails()){
        return response()->json($validaator->errors(),400);
    }

    $siswa = Siswa::find($id);

    if(!$siswa) {
        return response()->json(['status'=>false, 'message'=>'Siswa tidak ditemukan'],404);
    }

    $siswa->update($req->only([
        'nama','tgl_lahir','gender','alamat','no_tlp','id_kelas'
    ]));

    return response()->json(['status'=>true, 'message'=> 'Siswa berhasil diupdate']);

    }

    public function deletesiswa($id){
        $siswa = Siswa::find($id);

        if(!$siswa) {
            return response()->json(['status'=>false, 'message'=> "Siswa dengan id $id tidak ditemukan"],404);
        }

        $siswa->delete();

        return response()->json(['status'=>true, 'message'=>'Siswa berhasil dihapus']);
    }
}