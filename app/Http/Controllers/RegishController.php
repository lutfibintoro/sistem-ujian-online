<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
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
                DB::rollBack();
                return view('registrasi.signUp',
                [
                    'alert_status' => 'Error'.'! ',
                    'username' => 'username mengandung karakter yang tidak valid, username hanya mendukung [a-z 0-9 _]'
                ]);
            }

            if ($validPass->fails()) {
                DB::rollBack();
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

            $errorCode = $th->errorInfo[1];

            if ($errorCode == 1062) {
                return view('registrasi.signUp', [
                    'alert_status' => 'Error! ',
                    'username' => 'duplikat username '.$akunData['username']
                ]);

            } elseif ($errorCode == 1406) {
                return view('registrasi.signUp', [
                    'alert_status' => 'Error! ',
                    'username' => 'Data terlalu panjang. Periksa input dan coba lagi.'
                ]);

            } else {
                return view('registrasi.signUp', [
                    'alert_status' => 'Error! ',
                    'username' => 'Kesalahan sistem: ' . $errorMessage
                ]);
            }
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
    public function signIn(Request $request) {
        $data = $request->all();
        try {
            $userPendidikan = UserPendidikan::where('username', $data['username'])->where('pass', $data['pass'])->firstOrFail();
            return redirect('/dashboard'.'/'.$data['username'].'/'.urlencode($data['pass']));

        } catch (ModelNotFoundException $th) {
            return redirect('/sign-in/Error'.'/'.$data['username']);
        }
    }


    /**
     * return halaman dashboard beserta semua data yang diperlukan
     */
    public function dashboard($username, $pass) {
        try {
            $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
            
            if ($userPendidikan->peran == 'guru') {
                $dataPribadi = Guru::where('id_guru', $userPendidikan->id_guru)->firstOrFail();

                return view('guru.dashboard',
                [
                    'username' => $userPendidikan->username,
                    'pass' => $userPendidikan->pass,
                    'peran' => $userPendidikan->peran,
                    'nama' => $dataPribadi->nama,
                    'kontak' => $dataPribadi->kontak,
                    'email' => $dataPribadi->email,
                    'tanggalTerdaftar' => Carbon::parse($userPendidikan->tanggal_dibuat)->toDateString(),
                    'waktuTerdaftar' => Carbon::parse($userPendidikan->tanggal_dibuat)->format('H:i:s')
                ]);

            } elseif ($userPendidikan->peran == 'siswa') {
                $dataPribadi = Siswa::where('id_siswa', $userPendidikan->id_siswa)->firstOrFail();

                return view('murid.dashboard',
                [
                    'username' => $userPendidikan->username,
                    'pass' => $userPendidikan->pass,
                    'peran' => $userPendidikan->peran,
                    'nama' => $dataPribadi->nama,
                    'kontak' => $dataPribadi->kontak,
                    'email' => $dataPribadi->email,
                    'tanggalTerdaftar' => Carbon::parse($userPendidikan->tanggal_dibuat)->toDateString(),
                    'waktuTerdaftar' => Carbon::parse($userPendidikan->tanggal_dibuat)->format('H:i:s')
                ]);
            } else {
                throw new QueryException();
            }
            
            
        } catch (ModelNotFoundException $th) {
            return redirect('/sign-in/Error'.'/'.$username);
        }
    }


    /**
     * logic untuk masuk halaman edit profil serta logic untuk update edit data
     */
    public function profil(Request $request, $username, $pass) {
        try {
            if ($request->isMethod('put')) {
                DB::beginTransaction();
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
                    DB::rollBack();
                    return view('registrasi.signUp',
                    [
                        'alert_status' => 'Error'.'! ',
                        'username' => 'gagal update, username mengandung karakter yang tidak valid, username hanya mendukung [a-z 0-9 _]'
                    ]);
                }

                if ($validPass->fails()) {
                    DB::rollBack();
                    return view('registrasi.signUp',
                    [
                        'alert_status' => 'Error'.'! ',
                        'username' => 'gagal update, password mengandung karakter yang tidak valid, password tidak boleh berisi spasi'
                    ]);
                }


                $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
                if ($akunData['peran'] == 'guru') {
                    $userPendidikan->username = $akunData['username'];
                    $userPendidikan->pass = $akunData['pass'];

                    $guru = Guru::where('id_guru', $userPendidikan->id_guru)->firstOrFail();
                    $guru->nama = $pribadiData['nama'];
                    $guru->kontak = $pribadiData['kontak'];
                    $guru->email = $pribadiData['email'];

                    $guru->save();
                    $userPendidikan->save();

                } else {
                    $userPendidikan->username = $akunData['username'];
                    $userPendidikan->pass = $akunData['pass'];

                    $siswa = Siswa::where('id_siswa', $userPendidikan->id_siswa)->firstOrFail();
                    $siswa->nama = $pribadiData['nama'];
                    $siswa->kontak = $pribadiData['kontak'];
                    $siswa->email = $pribadiData['email'];

                    $siswa->save();
                    $userPendidikan->save();
        
                }
                DB::commit();
                return redirect('/profil'.'/'.$akunData['username'].'/'.$akunData['pass']);
            }


            // jika http method get kode ini yang akan jalan dan mengembalikan halaman edit profil
            $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
            if ($userPendidikan->peran == 'guru') {
                $dataPribadi = Guru::where('id_guru', $userPendidikan->id_guru)->firstOrFail();

                return view('guru.editProfil',
                [
                    'username' => $userPendidikan->username,
                    'pass' => $userPendidikan->pass,
                    'peran' => $userPendidikan->peran,
                    'nama' => $dataPribadi->nama,
                    'kontak' => $dataPribadi->kontak,
                    'email' => $dataPribadi->email
                ]);

            } elseif ($userPendidikan->peran == 'siswa') {
                $dataPribadi = Siswa::where('id_siswa', $userPendidikan->id_siswa)->firstOrFail();

                return view('murid.editProfil',
                [
                    'username' => $userPendidikan->username,
                    'pass' => $userPendidikan->pass,
                    'peran' => $userPendidikan->peran,
                    'nama' => $dataPribadi->nama,
                    'kontak' => $dataPribadi->kontak,
                    'email' => $dataPribadi->email
                ]);
            } else {
                throw new QueryException();
            }

        } catch (QueryException $th) {
            DB::rollBack();

            $errorCode = $th->errorInfo[1];

            if ($errorCode == 1062) {
                return view('registrasi.signUp', [
                    'alert_status' => 'Error! ',
                    'username' => 'duplikat username '.$akunData['username']
                ]);

            } elseif ($errorCode == 1406) {
                return view('registrasi.signUp', [
                    'alert_status' => 'Error! ',
                    'username' => 'Data terlalu panjang. Periksa input dan coba lagi.'
                ]);

            } else {
                return view('registrasi.signUp', [
                    'alert_status' => 'Error! ',
                    'username' => 'Kesalahan sistem: ' . $errorMessage
                ]);
            }
        }
    }


    /**
     * halaman untuk guru membuat data soal ujian
     */
    public function soalNewMeta($username, $pass) {
        $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();

        if ($userPendidikan->peran == 'guru') {
            $dataPribadi = Guru::where('id_guru', $userPendidikan->id_guru)->firstOrFail();
            $pelajarans = Pelajaran::get();

            return view('guru.buatSoal',
            [
                'username' => $userPendidikan->username,
                'pass' => $userPendidikan->pass,
                'pelajarans' => $pelajarans
            ]);

        } else {
            throw new QueryException();
        }
    }


    /**
     * simpan data soal yang sudah di buat guru lalu tampilkan pembuatan pertanyaan
     */
    public function soalNew(Request $request, $username, $pass) {
        $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
        if ($userPendidikan->peran == 'guru') {
            $dataPribadi = Guru::where('id_guru', $userPendidikan->id_guru)->firstOrFail();

            $requestDataUjian = $request->all();
            $dataUjian = new DataUjian();
            $dataUjian->nama_ujian = $requestDataUjian['nama_ujian'];
            $dataUjian->penjelasan_ujian = $requestDataUjian['penjelasan_ujian'];
            $dataUjian->durasi_ujian = $requestDataUjian['durasi_ujian'];
            $dataUjian->ujian_dibuka = Carbon::parse($requestDataUjian['ujian_dibuka']);
            $dataUjian->ujian_ditutup = Carbon::parse($requestDataUjian['ujian_ditutup']);
            $dataUjian->id_pelajaran = $requestDataUjian['id_pelajaran'];
            
            if ($requestDataUjian['ujian_ditutup'] < $requestDataUjian['ujian_dibuka']) {
                return redirect('/soal/guru'.'/'.$username.'/'.$pass);;
            }
            
            $dataUjian->save();
            return view('guru.isiSoal',
            [
                'username' => $username,
                'pass' => $pass,
                'id_data_ujian' => $dataUjian->id_data_ujian
            ]);

        } else {
            throw new QueryException();
        }
    }


    /**
     * simpan pertanyaan ke dalam database
     */
    public function pertanyaanNew(Request $request, $username, $pass, $id_data_ujian) {
        $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
        if (!$userPendidikan->peran == 'guru') {
            throw new QueryException();
        }

        $newSoalUjian = $request->all();
        $soalUjian = new SoalUjian();
        $soalUjian->pertanyaan = $newSoalUjian['pertanyaan'];
        $soalUjian->jawaban = $newSoalUjian['option'];
        $soalUjian->j1 = $newSoalUjian['j1'] ?? null;
        $soalUjian->j2 = $newSoalUjian['j2'] ?? null;
        $soalUjian->j3 = $newSoalUjian['j3'] ?? null;
        $soalUjian->j4 = $newSoalUjian['j4'] ?? null;
        $soalUjian->j5 = $newSoalUjian['j5'] ?? null;
        $soalUjian->j6 = $newSoalUjian['j6'] ?? null;
        $soalUjian->j7 = $newSoalUjian['j7'] ?? null;
        $soalUjian->j8 = $newSoalUjian['j8'] ?? null;
        $soalUjian->j9 = $newSoalUjian['j9'] ?? null;
        $soalUjian->j10 = $newSoalUjian['j10'] ?? null;
        $soalUjian->id_guru = $userPendidikan->id_guru;
        $soalUjian->id_data_ujian = $id_data_ujian;
        $soalUjian->save();

        return 'ok';
    }


    /**
     * batalakan pertanyaan dan hapus dari database
     */
    public function pertanyaanDel(Request $request, $username, $pass, $id_data_ujian) {
        
        $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
        if (!$userPendidikan->peran == 'guru') {
            throw new QueryException();
        }

        $soalGuru = SoalUjian::where('id_guru', $userPendidikan->id_guru)->where('id_data_ujian', $id_data_ujian)->exists();
        if (!$soalGuru) {
            return redirect('/soal/guru'.'/'.$username.'/'.$pass);
        }

        DataUjian::destroy($id_data_ujian);
        return redirect('/soal/guru'.'/'.$username.'/'.$pass);
    }


    /**
     * tampilkan halaman list soal untuk guru
     */
    public function soalSaya($username, $pass) {
        $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
        if ($userPendidikan->peran == 'guru') {
            $dataPribadi = Guru::where('id_guru', $userPendidikan->id_guru)->firstOrFail();

            $infos = UserPendidikan::join('guru', 'user_pendidikan.id_guru', '=', 'guru.id_guru')
                                    ->join('soal_ujian', 'guru.id_guru', '=', 'soal_ujian.id_guru')
                                    ->join('data_ujian', 'soal_ujian.id_data_ujian', '=', 'data_ujian.id_data_ujian')
                                    ->join('pelajaran', 'data_ujian.id_pelajaran', '=', 'pelajaran.id_pelajaran')
                                    ->select(
                                        'data_ujian.nama_ujian as nama_ujian',
                                        'data_ujian.durasi_ujian as durasi_ujian',
                                        'data_ujian.penjelasan_ujian as penjelasan_ujian',
                                        'data_ujian.ujian_dibuka as ujian_dibuka',
                                        'data_ujian.ujian_ditutup as ujian_ditutup',
                                        'data_ujian.id_data_ujian as id_data_ujian',
                                        'pelajaran.nama_pelajaran as nama_pelajaran',
                                        'guru.nama as nama',
                                        'guru.kontak as kontak',
                                        'guru.email as email')
                                    ->where('user_pendidikan.username', $username)->where('user_pendidikan.pass', $pass)
                                    ->distinct()->get()->toArray();

            foreach ($infos as &$info) {
                $panjang = SoalUjian::where('id_data_ujian', $info['id_data_ujian'])->count();
                $info['panjang'] = $panjang;

                $dibuka = Carbon::parse($info['ujian_dibuka']);
                $ditutup = Carbon::parse($info['ujian_ditutup']);

                if (now() < $dibuka) {
                    $info['status'] = 'warning';
                    $info['status_ujian'] = 'Belum Aktif';

                } elseif ((now() > $dibuka) && (now() < $ditutup)) {
                    $info['status'] = 'success';
                    $info['status_ujian'] = 'Aktif';

                } else {
                    $info['status'] = 'danger';
                    $info['status_ujian'] = 'Tidak Aktif';

                }
            }

            return view('guru.soalSaya', [
                'username' => $username,
                'pass' => $pass,
                'infos' => $infos
            ]);

        } else {
            throw new QueryException();
        }
    }


    /**
     * halaman input kode soal bagi mahasiswa
     */
    public function inputKodeSoal($username, $pass) {
        $userPendidikan = UserPendidikan::where('username', $username)->where('pass', $pass)->firstOrFail();
        if ($userPendidikan->peran == 'siswa') {
            return view('murid.kodeSoal',
            [
                'username' => $username,
                'pass' => $pass
            ]);
        } else {
            throw new QueryException();
        }
    }
}
