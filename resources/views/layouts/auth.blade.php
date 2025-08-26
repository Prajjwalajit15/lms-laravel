<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auth - LMS Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

 <style>
    body {
      background-color: #121212; /* Dark background */
      color: #f1f1f1; /* Light text */
      font-family: Arial, sans-serif;
    }
    .auth-card {
      background: #1e1e1e;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }
    .form-control {
      background: #2b2b2b;
      border: 1px solid #444;
      color: #f1f1f1;
    }
    .form-control:focus {
      background: #333;
      color: #fff;
      border-color: #0d6efd;
      box-shadow: none;
    }
    .btn-primary {
      background-color: #0d6efd;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0b5ed7;
    }
    a {
      color: #0d6efd;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="auth-card">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
</body>
</html>
