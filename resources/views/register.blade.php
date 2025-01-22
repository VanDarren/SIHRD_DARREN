<body class="light">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('aksi_register') }}" method="POST">
                @csrf
                <div class="w-100 mb-4 d-flex">
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center" >
                        <img src="{{ asset('img/' . $darren2->iconlogin) }}" alt="Iconlogin" class="logo-dashboard">
                    </a>
                </div>
                <h1 class="h6 mb-3">Register</h1>
                <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required autofocus>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="nohp" class="form-control form-control-lg" placeholder="Nomor HP" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Confirm Password" required>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
                <p class="mt-5 mb-3 text-muted">© 2024/@vdarren</p>
                <p>Already have an account? <a href="{{ route('login') }}">Login here</a>.</p>
            </form>
        </div>
    </div>
</body>
<style>
    .logo-dashboard {
        width: 100%;
        height: auto;
        max-width: 2500px;
        margin: 0 auto;
        display: block;
    }

    .img-fit-menu {
        width: 200px;
        height: 100px;
        object-fit: contain;
        margin: 0 auto;
    }
</style>
