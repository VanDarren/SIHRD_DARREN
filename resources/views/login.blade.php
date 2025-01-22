<body class="light">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" novalidate action="{{ route('aksi_login') }}" method="POST" id="loginForm" onsubmit="return validateForm();">
                @csrf
                <div class="w-100 mb-4 d-flex">
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center">
                    <img src="{{ asset('img/' . $darren2->iconlogin) }}" alt="Iconlogin" class="logo-dashboard">

                    </a>
                </div>

                <h1 class="h6 mb-3">Sign in</h1>

                <!-- Username Field -->
                <div class="form-group">
                    <label for="inputUsername" class="sr-only">Username</label>
                    <input type="text" name="username" id="inputUsername" class="form-control form-control-lg" placeholder="Username" required autofocus>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password" id="inputPassword" class="form-control form-control-lg" placeholder="Password" required>
                </div>

                <!-- CAPTCHA -->
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <!-- Online CAPTCHA -->
            <div id="recaptcha-container" class="g-recaptcha" data-sitekey="6LdFhCAqAAAAALvjUzF22OEJLDFAIsg-k7e-aBeH"></div>
            
            <!-- Offline CAPTCHA -->
            <div id="offline-captcha" style="display: none;">
              <p>Please enter the characters shown below:</p>
              <img src="{{ route('generateCaptcha') }}" alt="CAPTCHA">
              <input type="text" name="backup_captcha" class="form-control mt-2" placeholder="Enter CAPTCHA" required>
            </div>
 

                <!-- Submit Button -->
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

                <!-- Register Link -->
                <p class="mt-2">
                    <a href="{{ route('register') }}">Don't have an account? Register here.</a>
                </p>

                <!-- Footer -->
                <p class="mt-5 mb-3 text-muted">© 2024/@vdarren</p>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            var response = grecaptcha.getResponse();
            var backupCaptcha = document.querySelector('input[name="backup_captcha"]').value;
            var isOffline = !navigator.onLine;

            if (isOffline) {
                if (backupCaptcha.length === 0) {
                    alert('Please complete the offline CAPTCHA.');
                    return false;
                }
            } else {
                if (response.length === 0) {
                    alert('Please complete the online CAPTCHA.');
                    return false;
                }
            }
            return true;
        }

        window.addEventListener('load', function() {
            var isOffline = !navigator.onLine;

            if (isOffline) {
                document.getElementById('recaptcha-container').style.display = 'none';
                document.getElementById('offline-captcha').style.display = 'block';
            } else {
                document.getElementById('recaptcha-container').style.display = 'block';
                document.getElementById('offline-captcha').style.display = 'none';
            }
        });
    </script>
</body>

<style>
    .logo-dashboard {
        width: 100%; /* Pastikan gambar memenuhi lebar kotak */
        height: auto; /* Pertahankan rasio aspek gambar */
        max-width: 2500px; /* Atur batas maksimum untuk memastikan tidak terlalu besar */
        margin: 0 auto; /* Pusatkan gambar */
        display: block; /* Pastikan gambar diperlakukan sebagai blok */
    }
</style>
