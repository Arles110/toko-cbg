<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title> Login Page | Ayennn</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
             <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role" value="staff">
                <h1>Create Account</h1>
                {{-- --- TEMPEL DI SINI (DI ATAS INPUT NAMA) --- --}}
        @if ($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 12px; text-align: left;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
                <div class="social-icons">
                    <a href="{{ route('auth.socialite', 'google') }}" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="{{ route('auth.socialite', 'facebook') }}" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                
                <button type="submit">Sign Up</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="{{ route('auth.socialite', 'google') }}" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="{{ route('auth.socialite', 'facebook') }}" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>or use your email password</span>

                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="{{ route('password.request') }}">Forget Your Password? </a>
                <button type="submit">Sign In</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle"> 
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1> Hello Friend!</h1>
                    <p>Register with your personal details to use all of site</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>