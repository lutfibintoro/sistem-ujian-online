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
        .exam-info-card {
            border-left: 4px solid #A0C878;
        }
        .info-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .info-section h5 {
            color: #A0C878;
            border-bottom: 2px solid #DDEB9D;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bolder;
            color: #495057;
            min-width: 100px;
            display: inline-block;
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
                            <a class="nav-link" href="/profil/{{$username}}/{{$pass}}">
                                <i class="fas fa-user me-2"></i> Edit Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/kode/siswa/{{$username}}/{{$pass}}">
                                <i class="fas fa-solid fa-pen-to-square me-2"></i> Kerjakan Soal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-list me-2"></i> Soal Selesai
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
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand" href="#">Informasi Ujian</a>
                        <div class="d-flex align-items-center">
                            <span class="me-3 d-none d-sm-block">Halo, <strong>{{$username}}</strong></span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    @foreach($infos as $info)
                        <!-- Contoh ujian yang sudah dikerjakan -->
                        <div class="card shadow exam-info-card mt-4">
                            <div class="card-header bg-white">
                                <h4 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Ujian</h4>
                            </div>

                            <div class="card-body">
                                <!-- Judul Ujian dan Info Utama -->
                                <div class="mb-4">
                                    <h3 class="mb-2">{{$info['nama_ujian']}}</h3>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-info">
                                            <i class="fas fa-clock me-1"></i> Durasi: {{$info['durasi_ujian']}} menit
                                        </span>
                                        <span class="badge bg-primary">
                                            <i class="fas fa-question-circle me-1"></i> Jumlah Pertanyaan: {{$info['jumlah_pertanyaan']}}
                                        </span>
                                        <span class="badge bg-success">
                                            Nilai: {{$info['nilai']}}
                                        </span>
                                        <span class="badge bg-danger">
                                            Benar: {{$info['total_benar']}}
                                        </span>
                                    </div>
                                </div>

                                <!-- Grid untuk tiga bagian informasi -->
                                <div class="row">
                                    <!-- Bagian Mata Pelajaran -->
                                    <div class="col-md-4 mb-4">
                                        <div class="info-section h-100">
                                            <h5><i class="fas fa-book-open me-2"></i>Mata Pelajaran</h5>
                                            <div class="info-item">
                                                <span class="info-label">Nama:</span><br>
                                                <span>{{$info['nama_pelajaran']}}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Deskripsi:</span><br>
                                                <span>{{$info['penjelasan_ujian']}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bagian Jadwal Ujian -->
                                    <div class="col-md-4 mb-4">
                                        <div class="info-section h-100">
                                            <h5><i class="fas fa-calendar-alt me-2"></i>Jadwal Ujian</h5>
                                            <div class="info-item">
                                                <span class="info-label">Dibuka:</span><br>
                                                <span>{{$info['ujian_dibuka']}}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Ditutup:</span><br>
                                                <span>{{$info['ujian_ditutup']}}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Status:</span><br>
                                                <span class="badge bg-success">Selesai</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bagian Informasi Pembuat -->
                                    <div class="col-md-4 mb-4">
                                        <div class="info-section h-100">
                                            <h5><i class="fas fa-user-tie me-2"></i>Pembuat Ujian</h5>
                                            <div class="info-item">
                                                <span class="info-label">Nama:</span><br>
                                                <span>{{$info['nama']}}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Kontak:</span><br>
                                                <span>{{$info['kontak']}}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Email:</span><br>
                                                <span>{{$info['email']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection