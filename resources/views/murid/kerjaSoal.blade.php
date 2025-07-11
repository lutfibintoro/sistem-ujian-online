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
        .exam-header {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .question-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .question-number {
            color: #A0C878;
            font-weight: bold;
            margin-right: 10px;
        }
        .submit-btn {
            background-color: #A0C878;
            border-color: #A0C878;
            padding: 10px 25px;
            font-size: 1.1rem;
        }
        .timer {
            font-size: 1.2rem;
            font-weight: bold;
            color: #dc3545;
        }
        .option-item {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.2s;
            margin-left: 12px;
        }
        .option-item:hover {
            background-color: #f8f9fa;
        }
        .option-item input[type="radio"] {
            transform: scale(1.2);
            margin-right: 10px;
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
                            <i class="fas fa-pencil-alt me-2"></i>{{$nama_pelajaran}}
                        </a>
                        <div class="d-flex align-items-center">
                            <span class="timer me-3">
                                <i class="fas fa-clock me-1"></i> 01:25:30
                            </span>
                            <span class="me-3 d-none d-sm-block"><strong>{{$username}}</strong></span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    <!-- Header Ujian -->
                    <div class="exam-header">
                        <h4>{{$nama_ujian}}</h4>
                        <p class="text-muted">{{$penjelasan_ujian}}</p>
                        <!-- <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">5/20</div>
                        </div> -->
                    </div>

                    <!-- Daftar Pertanyaan -->
                    <form id="examForm" method="post" action="/soal/siswa/{{$username}}/{{$pass}}/{{$id_soal_ujian}}}">
                        @csrf
                        @foreach($soals as $soal)
                            <div class="question-container">
                                <h5><span class="question-number">{{$soal['nomer_soal']}}. </span>{{$soal['pertanyaan']}}</h5>
                                <div class="options mt-3">
                                    @foreach($soal['opsi'] as $option)
                                        <div class="option-item form-check">
                                            <input value="{{$option['jawaban']}}" class="form-check-input" type="radio" name="question{{$soal['nomer_soal']}}" id="q{{$soal['nomer_soal']}}option{{$option['jawaban']}}">
                                            <label class="form-check-label" for="q{{$soal['nomer_soal']}}option{{$option['jawaban']}}">{{$option['jawaban_text']}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <!-- Tombol Submit -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success submit-btn">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Jawaban
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Timer countdown
            function startTimer(duration, display) {
                let timer = duration, minutes, seconds;
                setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.textContent = minutes + ":" + seconds;

                    if (--timer < 0) {
                        // Auto submit ketika waktu habis
                        document.getElementById('examForm').submit();
                    }
                }, 1000);
            }

            // Mulai timer (90 menit = 5400 detik)
            const display = document.querySelector('.timer');
            const menitWaktu = "{{$durasi_ujian}}";
            startTimer(parseInt(menitWaktu) * 60, display);

            // Form submission
            // document.getElementById('examForm').addEventListener('submit', function(e) {
                // e.preventDefault();
                
                // Validasi apakah semua pertanyaan dijawab
                // const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
                // const totalQuestions = 3; // Ganti dengan jumlah pertanyaan sebenarnya
                
                // if(answeredQuestions < totalQuestions) {
                //     if(!confirm(`Anda baru menjawab ${answeredQuestions} dari ${totalQuestions} pertanyaan. Yakin ingin mengirim?`)) {
                //         return;
                //     }
                // }
                
                // Kirim jawaban ke server
                // alert('Jawaban berhasil dikirim!');
                // Di sini biasanya ada AJAX request ke server
            // });
        });
    </script>
@endsection