@extends('layouts.app')

@section('main-content')
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
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
        .code-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .code-input {
            letter-spacing: 4px;
            font-size: 1.5rem;
            text-align: center;
            text-transform: uppercase;
        }
        .btn-submit {
            background-color: #A0C878;
            border-color: #A0C878;
            padding: 10px 25px;
            font-size: 1.1rem;
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
                            <a class="nav-link active" href="/dashboard/{{$username}}/{{$pass}}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profil/{{$username}}/{{$pass}}">
                                <i class="fas fa-user me-2"></i> Edit Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-solid fa-pen-to-square me-2"></i> Kerjakan Soal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/list/siswa/{{$username}}/{{$pass}}">
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
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand" href="#">
                            <i class="fas fa-key me-2"></i> Masukkan Kode Ujian
                        </a>
                        <div class="d-flex align-items-center">
                            <span class="me-3 d-none d-sm-block"><strong>Andi Santoso</strong></span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="code-container text-center">
                                <h3 class="mb-4"><i class="fas fa-key me-2"></i> Masukkan Kode Ujian</h3>
                                <p class="text-muted mb-4">Silakan masukkan kode akses yang diberikan oleh guru/pengajar</p>
                                
                                <form id="codeForm">
                                    <div class="mb-4">
                                        <input type="number" class="form-control form-control-lg code-input" 
                                               placeholder="XXXX" required 
                                               pattern="[A-Za-z0-9]{4}-[A-Za-z0-9]{4}"
                                               title="Format kode: XXXX (angka)">
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-submit">
                                            <i class="fas fa-arrow-right me-2"></i> Lanjutkan
                                        </button>
                                    </div>
                                </form>
                                
                                <div class="mt-4">
                                    <p class="text-muted">
                                        <i class="fas fa-info-circle me-2"></i> 
                                        Kode akses terdiri dari angka bilangan bulat 0-9 dengan format XXXX
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection