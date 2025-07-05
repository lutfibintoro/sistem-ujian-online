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
                            <a class="nav-link" href="/profil/{{$username}}/{{$pass}}">
                                <i class="fas fa-user me-2"></i> Edit Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-plus-circle me-2"></i> Buat Soal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
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
                        <a class="navbar-brand" href="#">Buat Soal Ujian</a>
                        <div class="d-flex align-items-center">
                            <span class="me-3 d-none d-sm-block">Halo, <strong>{{$username}}</strong></span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    <!-- Form Buat Soal -->
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow exam-form-card mb-4">
                                <div class="card-header bg-white">
                                    <h4 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Metadata Ujian</h4>
                                </div>
                                <div class="card-body">
                                    <form id="examForm" method="post" action="soal/guru/{{$username}}/{{$pass}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="examName" class="form-label">Nama Ujian</label>
                                                <input name="nama_ujian" type="text" class="form-control" id="examName" required>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="subject" class="form-label">Pelajaran</label>
                                                <select name="pelajaran" class="form-select" id="subject" required>
                                                    <option value="" selected disabled>Pilih Pelajaran</option>
                                                    @foreach ($pelajarans as $pelajaran)
                                                        <option value="{{$pelajaran->id_pelajaran}}">{{$pelajaran->nama_pelajaran}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="examDescription" class="form-label">Penjelasan Ujian</label>
                                            <textarea name="deskripsi_ujian" class="form-control" id="examDescription" rows="3"></textarea>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="duration" class="form-label">Durasi Ujian (menit)</label>
                                                <input name="durasi" type="number" class="form-control" id="duration" min="1" required>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="openTime" class="form-label">Ujian Dibuka</label>
                                                <input name="tanggal_ujian_dibuka" type="datetime-local" class="form-control" id="openTime" required>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="closeTime" class="form-label">Ujian Ditutup</label>
                                                <input name="tanggal_ujian_ditutup" type="datetime-local" class="form-control" id="closeTime" required>
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                            <button type="button" class="btn btn-secondary me-md-2" onclick="window.location.href='/soal/guru/{{$username}}/{{$pass}}'">
                                                <i class="fas fa-times me-1"></i> Batal
                                            </button>
                                            <button type="submit" class="btn btn-success" style="background-color: #A0C878; border-color: #A0C878;">
                                                <i class="fas fa-save me-1"></i> Simpan Metadata
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Bagian untuk menambahkan soal (akan diisi setelah metadata disimpan) -->
                            <div class="card shadow mb-4" id="questionSection" style="display: none;">
                                <div class="card-header bg-white">
                                    <h4 class="card-title mb-0"><i class="fas fa-question-circle me-2"></i>Tambah Soal</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Silakan tambahkan soal setelah menyimpan metadata ujian</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection