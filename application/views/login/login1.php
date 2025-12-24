<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #eef2f7;
        }
        .login-box {
			width: 100%;
			height: auto;
            max-width: 520px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.07);
        }
        .login-title {
            font-weight: 700;
        }
        .logo-circle {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            background: #2563eb;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 30px;
            margin: 0 auto 20px auto;
            font-weight: bold;
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100">

        <div class="login-box">

            <!-- Logo -->
            <div class="logo-circle">
                GMS
            </div>

            <!-- Title -->
            <h3 class="text-center login-title mb-4">Sign In</h3>

            <!-- Error Message -->
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger text-center">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('index.php/login/verify_login') ?>" method="POST">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Enter username"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <div class="password-container">
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="form-control" 
                               placeholder="Enter password"
                               required>

                        <span class="password-toggle" onclick="togglePassword()">
                            👁️
                        </span>
                    </div>
                </div>

                <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" name="remember">
                        <label>Remember me</label>
                    </div>

                    <a href="#" class="text-primary small">Forgot Password?</a>
                </div> -->

                <button type="submit" class="btn btn-primary w-100 py-2 mt-1">
                    Login
                </button>

            </form>

        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const pass = document.getElementById('password');
            pass.type = pass.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>
