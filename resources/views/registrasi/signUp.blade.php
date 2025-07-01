@extends('layouts.app')

@section('main-content')
<div class="bg-light" style="background-color: #FFFDF6 !important; min-height: 100vh; display: flex; align-items: center; margin-top: 35px; margin-bottom: 35px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h2 class="text-success" style="color: #A0C878 !important;">Sign-Up</h2>
                            <p class="text-muted">Silakan isi form berikut untuk mendaftar</p>
                        </div>

                        <div id="alert-box" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong id="alert-status">{{ $alert_status }}</strong>{{ $username }}
                        </div>
                        <script>
                            const alertStatus = document.getElementById("alert-status");
                            if (String(alertStatus.textContent.slice(0, -1)) == String('Succes!')) {
                                const alertBox = document.getElementById("alert-box");
                                alertBox.classList.remove('alert');
                                alertBox.classList.remove('alert-danger');
                                alertBox.classList.remove('alert-info');
                                alertBox.classList.remove('alert-dismissible');
                                alertBox.classList.remove('fade');
                                alertBox.classList.remove('show');
                                
                                alertBox.classList.add('alert');
                                alertBox.classList.add('alert-info');
                                alertBox.classList.add('alert-dismissible');
                                alertBox.classList.add('fade');
                                alertBox.classList.add('show');
                                
                            } else if (String(alertStatus.textContent.slice(0, -1)) == 'Error!') {
                                alertBox.classList.remove('alert');
                                alertBox.classList.remove('alert-danger');
                                alertBox.classList.remove('alert-info');
                                alertBox.classList.remove('alert-dismissible');
                                alertBox.classList.remove('fade');
                                alertBox.classList.remove('show');

                                alertBox.classList.add('alert');
                                alertBox.classList.add('alert-danger');
                                alertBox.classList.add('alert-dismissible');
                                alertBox.classList.add('fade');
                                alertBox.classList.add('show');
                                
                            } else {
                                const alertBox = document.getElementById("alert-box");
                                alertBox.classList.remove('alert');
                                alertBox.classList.remove('alert-danger');
                                alertBox.classList.remove('alert-info');
                                alertBox.classList.remove('alert-dismissible');
                                alertBox.classList.remove('fade');
                                alertBox.classList.remove('show');
                            }
                        </script>

                        <form action="/sign-up/" method="post">
                            @csrf
                            <!-- Bagian Akun -->
                            <div class="mb-4">
                                <h5 class="text-success mb-3" style="color: #A0C878 !important;">Akun</h5>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input name="username" type="text" class="form-control" id="username" placeholder="Buat username" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="pass" class="form-label">Password</label>
                                    <input name="pass" type="pass" class="form-control" id="pass" placeholder="Buat password" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="peran" class="form-label">Peran</label>
                                    <select name="peran" class="form-select" id="peran" required>
                                        <option value="" selected disabled>Pilih peran</option>
                                        <option value="siswa">Siswa</option>
                                        <option value="guru">Guru</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Bagian Data Pribadi -->
                            <div class="mb-4">
                                <h5 class="text-success mb-3" style="color: #A0C878 !important;">Data Pribadi</h5>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input name="nama" type="text" class="form-control" id="nama" placeholder="Masukkan nama lengkap" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="kontak" class="form-label">Kontak</label>
                                    <input name="kontak" type="tel" class="form-control" id="kontak" placeholder="Nomor telepon/WA" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Masukkan email" required>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success" style="background-color: #A0C878 !important; border-color: #A0C878 !important;">Daftar</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p class="text-muted">Sudah punya akun? <a href="/" class="text-success" style="color: #A0C878 !important;">Login disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection