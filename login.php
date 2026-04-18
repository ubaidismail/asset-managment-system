<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f5f6f8;
    }
    .login-card {
      max-width: 400px;
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100">

  <div class="card login-card p-4">
    <h3 class="text-center mb-4">Login</h3>

    <form action="" method="POST">

      <!-- Email -->
      <div class="mb-3">
        <label class="form-label">Employee ID</label>
        <input type="emp_id" name="emp_id" class="form-control" placeholder="Enter Employee ID" required>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
      </div>

      <!-- Remember + Forgot -->
      <div class="d-flex justify-content-between mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <a href="#" class="text-decoration-none">Forgot?</a>
      </div>

      <!-- Button -->
      <button type="submit" class="btn btn-primary w-100">
        Login
      </button>

    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>