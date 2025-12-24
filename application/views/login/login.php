<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Login | GMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Tailwind -->
	<script src="https://cdn.tailwindcss.com"></script>

	<!-- Optional: Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<style>
		body {
			font-family: 'Inter', sans-serif;
		}
	</style>
</head>

<!-- <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600"> -->
<!-- <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 via-blue-300 to-indigo-400"> -->
<!-- <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-300 via-blue-200 to-indigo-300"> -->

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-400 via-blue-300 to-indigo-400">

	<!-- Background decoration -->
	<div class="absolute inset-0">
		<svg class="absolute bottom-0 left-0 w-full h-64 text-white/10"
			viewBox="0 0 1440 320" fill="currentColor">
			<path d="M0,224L60,229.3C120,235,240,245,360,240C480,235,600,213,720,208C840,203,960,213,1080,202.7C1200,192,1320,160,1380,144L1440,128V320H0Z"></path>
		</svg>
	</div>
	<!-- Soft background -->
	<div class="absolute inset-0 bg-[url('<?= base_url("public/images/car1.png") ?>')]
                bg-center bg-no-repeat bg-contain opacity-5 pointer-events-none"></div>

	<!-- Login Card -->
	<div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

		<!-- Logo -->
		<div class="flex flex-col items-center mb-6">
			<!-- <div class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                GMS
            </div> -->
			<div class="brand flex items-center gap-3 px-4 py-3">
				<img src="<?= base_url('public/images/car1.png') ?>"
					alt="GMS Logo"
					class="h-10 w-auto">

				<h2 class="text-xl font-semibold text-gray-800 whitespace-nowrap">
					Auto 360+
				</h2>
			</div>
			<h2 class="mt-4 text-2xl font-semibold text-gray-800">Sign in to your account</h2>
			<!-- <p class="text-sm text-gray-500">Garage Management System</p> -->
		</div>

		<!-- Error Message -->
		<?php if (!empty($error)): ?>
			<div class="mb-4 p-3 text-sm text-red-700 bg-red-100 rounded">
				<?= $error ?>
			</div>
		<?php endif; ?>

		<!-- Login Form -->
		<form method="post" action="<?= base_url('index.php/login/verify_login') ?>" class="space-y-5">

			<!-- Username -->
			<div>
				<label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
				<input type="text" name="username" required
					class="w-full px-4 py-3 rounded-lg border border-gray-300
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              outline-none transition"
					placeholder="Enter your username">
			</div>

			<!-- Password -->
			<div>
				<label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
				<div class="relative">
					<input type="password" name="password" id="password" required
						class="w-full px-4 py-3 rounded-lg border border-gray-300
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  outline-none transition"
						placeholder="Enter your password">

					<!-- Show/Hide -->
					<button type="button"
						onclick="togglePassword()"
						class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
						👁
					</button>
				</div>
			</div>

			<!-- Remember -->
			<!-- <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded text-blue-600">
                    Remember me
                </label>

                <a href="#" class="text-blue-600 hover:underline">
                    Forgot password?
                </a>
            </div> -->

			<!-- Login Button -->
			<button type="submit"
				class="w-full py-3 rounded-lg bg-blue-600 text-white font-semibold
                           hover:bg-blue-700 transition shadow-md">
				Login
			</button>
		</form>

		<!-- Footer -->
		<p class="mt-6 text-center text-xs text-gray-400">
			© <?= date('Y') ?> Garage Management System
		</p>
	</div>

	<!-- Password Toggle -->
	<script>
		function togglePassword() {
			const input = document.getElementById('password');
			input.type = input.type === 'password' ? 'text' : 'password';
		}
	</script>

</body>

</html>
