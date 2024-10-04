<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="stylesheet" href="{{ asset('delfood-1.0.0/css/sty.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo">Flavora</div>
        <div class="login-container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="login-button">Masuk</button>
                <div class="register-prompt">
                    Belum memiliki akun? <a class="register-link" href="{{ route('register') }}">Daftar</a>
                </div>
            </form>
        </div>
        <img class="background-image" src="https://via.placeholder.com/1440x1026" alt="Background Image" />
    </div>
</body>
</html>
