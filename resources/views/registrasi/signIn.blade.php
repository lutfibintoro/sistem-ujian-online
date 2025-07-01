@extends('layouts.app')

@section('main-content')
<div class="bg-light" style="background-color: #FFFDF6 !important; height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h2 class="text-success" style="color: #A0C878 !important;">Sign-In</h2>
                            <p class="text-muted">Silakan masuk dengan akun Anda</p>
                        </div>
                        
                        <div id="alert-box" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong id="alert-status">{{ $alert_status }}</strong>{{ $alert_message }}
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

                        <form action="" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Masukkan username" value="{{$username}}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="pass" class="form-label">Password</label>
                                <input name="pass" type="password" class="form-control" id="pass" placeholder="Masukkan password" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success" style="background-color: #A0C878 !important; border-color: #A0C878 !important;">Login</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p class="text-muted">Belum punya akun? <a href="/sign-up/" class="text-success" style="color: #A0C878 !important;">Daftar disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection