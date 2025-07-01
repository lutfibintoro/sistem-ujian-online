<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegishController extends Controller
{
    /**
     * mengirim data untuk melakukan sign-up atau meminta halaman sign-up
     */
    public function signUp(Request $request) {
        if ($request->isMethod('post')){
            $data = $request->all();
            return redirect('/sign-in/Succes'.'/'.$data['username']);
        } else {
            return view('registrasi.signUp', ['alert_status' => '', 'username' => '']);
        }
    }


    /**
     * menampilkan halaman sign-in setelah sukses melakukan sign-up
     */
    public function signUpSukses($alert_status, $username) {
        if ($alert_status == 'Succes') {
            return view('registrasi.signIn', ['alert_status' => $alert_status.'! ', 'username' => $username, 'alert_message' => 'Username: '.$username.' berhasil di buat, silahkan sign-in']);
        } else {
            return view('registrasi.signIn', ['alert_status' => 'Error'.'! ', 'username' => $username, 'alert_message' => '']);
        }
    }
}
