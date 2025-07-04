@extends('layouts.app')

@section('main-content')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #FFFDF6;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #495057;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover {
            background-color: #DDEB9D;
        }
        .sidebar .nav-link.active {
            background-color: #A0C878;
            color: white;
        }
        .main-content {
            padding: 20px;
        }
        .navbar-brand {
            color: #A0C878;
            font-weight: bold;
        }
        .profile-card {
            border-left: 4px solid #A0C878;
        }
        .data-label {
            font-weight: 600;
            color: #495057;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigasi -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar p-0">
                <div class="p-3">
                    <h4 class="text-center mb-4" style="color: #A0C878;">E-Learning</h4>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard/{{$username}}/{{$pass}}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-user me-2"></i> Edit Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-plus-circle me-2"></i> Buat Soal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-list me-2"></i> Soal Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto main-content">
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand" href="#">Edit Profil</a>
                        <div class="d-flex align-items-center">
                            <span class="me-3 d-none d-sm-block">Halo, <strong>{{$username}}</strong></span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    <!-- Form Edit Profil -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow profile-form-card">
                                <div class="card-header bg-white">
                                    <h4 class="card-title mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profil</h4>
                                </div>
                                <div class="card-body">
                                    <form id="profileForm" method="post" action="/profil/{{$username}}/{{$pass}}/edit">
                                        @csrf
                                        @method('PUT')
                                        <!-- Informasi Akun -->
                                        <h5 class="mb-3 text-success" style="color: #A0C878;">Informasi Akun</h5>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input name="username" type="text" class="form-control" id="username" value="{{$username}}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input name="pass" type="text" class="form-control" id="password" placeholder="Masukkan password baru" value="{{$pass}}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Peran</label>
                                            <select name="peran" class="form-select" id="role">
                                                <option value="guru" selected>Guru</option>
                                            </select>
                                            <small class="text-muted">Peran tidak dapat diubah</small>
                                        </div>
                                        
                                        <hr class="my-4">
                                        
                                        <!-- Data Pribadi -->
                                        <h5 class="mb-3 text-success" style="color: #A0C878;">Data Pribadi</h5>
                                        <div class="mb-3">
                                            <label for="fullName" class="form-label">Nama Lengkap</label>
                                            <input name="nama" type="text" class="form-control" id="fullName" value="{{$nama}}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="contact" class="form-label">Kontak</label>
                                            <input name="kontak" type="tel" class="form-control" id="contact" value="{{$kontak}}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input name="email" type="email" class="form-control" id="email" value="{{$email}}" required>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                            <button type="submit" class="btn btn-success" style="background-color: #A0C878; border-color: #A0C878;">
                                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection