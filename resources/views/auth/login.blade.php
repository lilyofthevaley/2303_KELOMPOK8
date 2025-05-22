<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Sekolah</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #4e73df;
            font-family: 'Nunito', sans-serif;
        }
        
        .login-container {
            margin-top: 100px;
        }
        
        .card {
            border: 0;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            text-align: center;
            padding: 1.5rem;
        }
        
        .card-header h4 {
            margin-bottom: 0;
            color: #4e73df;
            font-weight: bold;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .login-image {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .login-icon {
            font-size: 4rem;
            color: #4e73df;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row login-container justify-content-center">
            <div class="col-lg-5">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="card">
                    <div class="card-header">
                        <h4>Sistem Absensi Sekolah</h4>
                    </div>
                    <div class="card-body">
                        <div class="login-image">
                            <i class="fas fa-user-circle login-icon"></i>
                        </div>
                        
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">Username / NIP / NIS</label>
                                <input type="text" class="form-control" id="username" name="username" required autofocus>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Admin: username 'admin', password 'admin123'<br>
                                    <i class="fas fa-info-circle"></i> Guru & Siswa: Gunakan NIP/NIS sebagai password
                                </small>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>