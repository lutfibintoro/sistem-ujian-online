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
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profil/{{$username}}/{{$pass}}">
                                <i class="fas fa-user me-2"></i> Edit Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/soal/guru/{{$username}}/{{$pass}}">
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
                        <a class="navbar-brand" href="#">Dashboard</a>
                        <div class="d-flex align-items-center">
                            <span class="me-3 d-none d-sm-block">Selamat datang, <strong>{{$username}}</strong></span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    <!-- Data Diri User -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4 profile-card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-user-circle me-2"></i>Data Diri</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="data-label">Username</p>
                                            <p class="text-muted">{{$username}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="data-label">Password</p>
                                            <p class="text-muted">{{$pass}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="data-label">Peran</p>
                                            <p class="text-muted">
                                                <span class="badge bg-primary">{{$peran}}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="data-label">Nama Lengkap</p>
                                            <p class="text-muted">{{$nama}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="data-label">Kontak</p>
                                            <p class="text-muted">{{$kontak}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="data-label">Email</p>
                                            <p class="text-muted">{{$email}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white text-end">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Widget waktu terdaftar -->
                        <div class="col-lg-4">
                            <div class="card shadow mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Akun</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-light rounded p-3 me-3">
                                            <i class="fas fa-calendar-alt text-success" style="color: #A0C878;"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 data-label">Tanggal Terdaftar</p>
                                            <p class="text-muted mb-0">{{$tanggalTerdaftar}}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-light rounded p-3 me-3">
                                            <i class="fas fa-solid fa-clock text-success" style="color: #A0C878;"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 data-label">Waktu Terdaftar</p>
                                            <p class="text-muted mb-0">{{$waktuTerdaftar}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection