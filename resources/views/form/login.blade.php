<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập hệ thống</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #74ebd5, #ACB6E5);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .login-container input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    .login-container button {
      width: 100%;
      padding: 12px;
      background-color: #4a90e2;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-container button:hover {
      background-color: #357ABD;
    }

    .switch-btn {
      margin-top: 15px;
      text-align: center;
    }

    .switch-btn a {
      color: #4a90e2;
      cursor: pointer;
      text-decoration: underline;
      font-size: 14px;
    }
  </style>
</head>

<body>

  <div class="login-container">
    <h2 id="login-title">Đăng nhập hệ thống nhân viên</h2>

    @if(session('error'))
    <p style="color:red; text-align:center">{{ session('error') }}</p>
  @endif

    <form method="POST" action="{{ route('login.submit') }}">
      @csrf
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mật khẩu" required>
      <input type="hidden" name="type" value="staff" id="user-type">
      <button type="submit">Đăng nhập</button>
    </form>

    <div class="switch-btn">
      <a id="switch-link">Chuyển sang đăng nhập admin</a>
    </div>
  </div>
  <script>
    const title = document.getElementById('login-title');
    const switchLink = document.getElementById('switch-link');
    const userTypeInput = document.getElementById('user-type');
    let isAdmin = false;

    switchLink.addEventListener('click', () => {
      isAdmin = !isAdmin;
      title.textContent = isAdmin ? 'Đăng nhập hệ thống admin' : 'Đăng nhập hệ thống nhân viên';
      switchLink.textContent = isAdmin ? 'Chuyển sang đăng nhập nhân viên' : 'Chuyển sang đăng nhập admin';
      userTypeInput.value = isAdmin ? 'admin' : 'staff';
    });
  </script>

</body>

</html>