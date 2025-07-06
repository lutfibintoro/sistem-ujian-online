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
                        <a class="navbar-brand" href="#">Buat Pertanyaan Ujian</a>
                        <div class="d-flex align-items-center">
                            <span class="me-3 d-none d-sm-block">Halo, <strong>{{$username}}</strong></span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    <!-- Daftar Pertanyaan -->
                    <div id="questionsContainer">
                        <!-- Pertanyaan akan ditambahkan di sini -->
                    </div>

                    <!-- Tombol Tambah Pertanyaan -->
                    <div class="text-center mb-4">
                        <button type="button" class="btn btn-success" id="addQuestionBtn" style="background-color: #A0C878; border-color: #A0C878;">
                            <i class="fas fa-plus me-1"></i> Tambah Pertanyaan
                        </button>
                        <a href="/soal/guru/{{$username}}/{{$pass}}/{{$id_data_ujian}}" class="btn btn-danger" id="addQuestionBtn">
                            <i class="fas fa-trash me-1"></i> Hapus Semua Perubahan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Template Pertanyaan (Hidden) -->
    <template id="questionTemplate">
        <div class="card shadow question-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pertanyaan Baru</h5>
                <!-- <button type="button" class="btn btn-sm btn-danger remove-question-btn">
                    <i class="fas fa-trash"></i> Hapus
                </button> -->
            </div>
            <div class="card-body">
                <form class="question-form" method="post" action="/soal/guru/{{$username}}/{{$pass}}/{{$id_data_ujian}}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <textarea name="pertanyaan" class="form-control question-text" rows="3" placeholder="Masukkan pertanyaan" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <div class="options-container">
                            <!-- <div class="option-item">
                                <input value="op1" type="radio" name="option" class="form-check-input">
                                <input type="text" name="j1" class="form-control option-text" placeholder="Jawaban 1">
                                <button type="button" class="btn btn-sm remove-option-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="option-item">
                                <input value="op2" type="radio" name="option" class="form-check-input">
                                <input type="text" name="j2" class="form-control option-text" placeholder="Jawaban 2">
                                <button type="button" class="btn btn-sm remove-option-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div> -->
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-success add-option-btn mt-2">
                            <i class="fas fa-plus me-1"></i> Tambah Jawaban
                        </button>
                    </div>
                    
                    <div class="question-actions d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2 cancel-question-btn">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success" style="background-color: #A0C878; border-color: #A0C878;">
                            <i class="fas fa-save me-1"></i> Simpan Pertanyaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
    <!-- logika interaktif pertanyaan -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set menu Buat Soal sebagai aktif
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if(link.querySelector('.fa-plus-circle')) {
                    link.classList.add('active');
                }
            });

            const questionsContainer = document.getElementById('questionsContainer');
            const questionTemplate = document.getElementById('questionTemplate');
            let questionCount = 0;

            // Tambah pertanyaan baru
            document.getElementById('addQuestionBtn').addEventListener('click', function() {
                const questionClone = questionTemplate.content.cloneNode(true);
                const questionElement = questionClone.querySelector('.card');
                questionElement.dataset.questionId = ++questionCount;
                questionElement.querySelector('.card-title').textContent = `Pertanyaan ${questionCount}`;
                
                questionsContainer.appendChild(questionClone);
                
                // Set event listeners untuk pertanyaan baru
                setupQuestionEvents(questionElement);
            });

            // Setup event listeners untuk sebuah pertanyaan
            function setupQuestionEvents(questionElement) {
                const questionForm = questionElement.querySelector('.question-form');
                
                // Hapus pertanyaan
                //questionElement.querySelector('.remove-question-btn').addEventListener('click', function() {
                //    if(confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
                //        questionElement.remove();
                //    }
                //});
                
                // Batal pertanyaan
                questionElement.querySelector('.cancel-question-btn').addEventListener('click', function() {
                    if(confirm('Apakah Anda yakin ingin membatalkan pertanyaan ini?')) {
                        questionElement.remove();
                        const containerCard = document.getElementById('questionsContainer');
                        const card = containerCard.getElementsByClassName('card');
                        let loop = containerCard.children.length;
                        questionCount = loop;

                        for (let i = 0; i < loop; i++) {
                            card[i].dataset.questionId = 1 + i;
                            card[i].querySelector('.card-title').textContent = `Pertanyaan ${i + 1}`;
                        }
                    }
                });
                
                // Tambah opsi jawaban
                questionElement.querySelector('.add-option-btn').addEventListener('click', function() {
                    const optionsContainer = questionElement.querySelector('.options-container');
                    const optionItems = optionsContainer.getElementsByClassName('option-item');
                    const optionCount = optionsContainer.children.length;
                    
                    if(optionCount >= 10) {
                        alert('Maksimal 10 jawaban per pertanyaan');
                        return;
                    }
                    

                    const newOption = document.createElement('div');
                    newOption.className = 'option-item';
                    newOption.innerHTML = `
                        <input value="op${optionCount + 1}" type="radio" name="option" class="form-check-input">
                        <input type="text" name="j${optionCount + 1}" class="form-control option-text" placeholder="Jawaban ${optionCount + 1}">
                        <button type="button" class="btn btn-sm remove-option-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    optionsContainer.appendChild(newOption);


                    // Set event listener untuk hapus opsi
                    newOption.querySelector('.remove-option-btn').addEventListener('click', function() {
                        if(optionsContainer.children.length <= 2) {
                            alert('Minimal harus ada 2 jawaban');
                            return;
                        }
                        newOption.remove();

                        const ooptionItems = optionsContainer.querySelectorAll('.option-item');
                        for (let i = 0; i < ooptionItems.length; i++) {
                            const inputText = ooptionItems[i].querySelector('.option-text');
                            inputText.placeholder = `Jawaban ${i + 1}`;
                            inputText.name = `j${i + 1}`;

                            const radioInput = ooptionItems[i].querySelector('.form-check-input');
                            radioInput.value = `op${i + 1}`;
                        }
                    });


                    // [...optionItems].forEach(el => el.remove());

                    for (let i = 0; i < optionCount + 1; i++) {
                        const inputText = optionItems[i].querySelector('.option-text');
                        inputText.placeholder = `Jawaban ${i + 1}`;
                        inputText.name = `j${i + 1}`;

                        const radioInput = optionItems[i].querySelector('.form-check-input');
                        radioInput.value = `op${i + 1}`;
                    }
                });
                
                // Hapus opsi jawaban (untuk opsi yang sudah ada)
                questionElement.querySelectorAll('.remove-option-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const optionsContainer = questionElement.querySelector('.options-container');
                        if(optionsContainer.children.length <= 2) {
                            alert('Minimal harus ada 2 jawaban');
                            return;
                        }
                        btn.closest('.option-item').remove();
                    });

                });
                
                // Submit form pertanyaan
                questionForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Validasi jawaban benar
                    const optionsContainer = questionElement.querySelector('.options-container');
                    const radioButtons = optionsContainer.querySelectorAll('input[type="radio"]');
                    let isChecked = false;
                    
                    radioButtons.forEach(radio => {
                        if(radio.checked) isChecked = true;
                    });
                    
                    if(!isChecked) {
                        alert('Harap pilih jawaban yang benar');
                        return;
                    }
                    
                    // Simpan pertanyaan
                    const questionText = questionElement.querySelector('.question-text').value;
                    const options = [];
                    let correctAnswerIndex = -1;
                    
                    questionElement.querySelectorAll('.option-item').forEach((optionEl, optIndex) => {
                        const optionText = optionEl.querySelector('.option-text').value;
                        const isCorrect = optionEl.querySelector('input[type="radio"]').checked;
                        
                        options.push({
                            text: optionText,
                            isCorrect: isCorrect
                        });
                        
                        if(isCorrect) correctAnswerIndex = optIndex;
                    });
                    
                    // Di sini Anda bisa mengirim data pertanyaan ke server
                    console.log('Pertanyaan disimpan:', {
                        question: questionText,
                        options: options,
                        correctAnswerIndex: correctAnswerIndex
                    });
                    
                    alert('Pertanyaan berhasil disimpan!');
                    
                    // Nonaktifkan form setelah disimpan
                    questionForm.querySelectorAll('input, textarea, button').forEach(el => {
                        el.disabled = true;
                    });
                    questionElement.querySelector('.remove-question-btn').disabled = false;
                });
            }

            // Tambahkan pertanyaan pertama secara otomatis
            document.getElementById('addQuestionBtn').click();
        });
    </script>
@endsection