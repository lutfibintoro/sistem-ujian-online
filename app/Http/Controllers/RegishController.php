<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\DataUjian;
use App\Models\Guru;
use App\Models\Pelajaran;
use App\Models\Pengerjaan;
use App\Models\Siswa;
use App\Models\SoalUjian;
use App\Models\UserPendidikan;

class RegishController extends Controller
{
    /**
     * mengirim data untuk melakukan sign-up atau meminta halaman sign-up
     */
    public function signUp(Request $request) {
        try {
            DB::beginTransaction();
            if (!$request->isMethod('post')) {
                return view('registrasi.signUp',
                [
                    'alert_status' => '',
                    'username' => ''
                ]);
            }
    
            $akunData = $request->only(['username', 'pass', 'peran']);
            $pribadiData = $request->only(['nama', 'kontak', 'email']);

            $validUser = Validator::make($akunData, [
                'username' => [
                    'required',
                    'regex:/^[a-z0-9_]+$/'
                ]
            ]);

            $validPass = Validator::make($akunData, [
                'pass' => [
                    'required',
                    'regex:/^\S+$/'
                ]
            ]);

            if ($validUser->fails()) {
                return view('registrasi.signUp',
                [
                    'alert_status' => 'Error'.'! ',
                    'username' => 'username mengandung karakter yang tidak valid, username hanya mendukung [a-z 0-9 _]'
                ]);
            }

            if ($validPass->fails()) {
                return view('registrasi.signUp',
                [
                    'alert_status' => 'Error'.'! ',
                    'username' => 'password mengandung karakter yang tidak valid, password tidak boleh berisi spasi'
                ]);
            }
    
            if ($akunData['peran'] == 'guru') {
                $guru = Guru::create($pribadiData);
                $idGuru = $guru->id_guru;
    
                $akunData['id_guru'] = $idGuru;
                $akunData['id_siswa'] = null;
                UserPendidikan::create($akunData);
    
            } else {
                $siswa = Siswa::create($pribadiData);
                $idSiswa = $siswa->id_siswa;
    
                $akunData['id_guru'] = null;
                $akunData['id_siswa'] = $idSiswa;
                UserPendidikan::create($akunData);
    
            }
            DB::commit();
            return redirect('/sign-in/Succes'.'/'.$akunData['username']);

        } catch (QueryException $th) {
            DB::rollBack();
            return view('registrasi.signUp',
            [
                'alert_status' => 'Error'.'! ',
                'username' => 'duplikat username '.$akunData['username']
            ]);
        }

    }


    /**
     * menampilkan halaman sign-in setelah sukses melakukan sign-up
     */
    public function signUpSukses($alert_status, $username) {
        if ($alert_status == 'Succes') {
            return view('registrasi.signIn',
            [
                'alert_status' => $alert_status.'! ',
                'username' => $username,
                'alert_message' => 'Username: '.$username.' berhasil di buat, silahkan sign-in'
            ]);
        } else {
            return view('registrasi.signIn',
            [
                'alert_status' => 'Error'.'! ',
                'username' => $username,
                'alert_message' => 'username atau password salah, islahkan ulangi'
            ]);
        }
    }


    /**
     * logic untuk masuk ke dashbord siswa / guru setelah melakukan sign-in
     */
    public function signIn(Request $request) {}
}
