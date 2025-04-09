<header class="admin-menu">
  <h1>AZ MEDIA</h1>
  <div class="header-action">
    <div class="message">
      <i class="fa-solid fa-message"></i>
    </div>
    <div class="notifi">
      <i class="fa-solid fa-bell"></i>
    </div>
    <div class="avatar">
      <a href="{{route('employee.my-info')}}">
        <span>Xin chào, </span>
        <span>@yield('username')</span>
        <img src="{{ asset('storage/' . trim($__env->yieldContent('avatar'))) }}" alt="avatar" width="45" height="45">
      </a>
    </div>
  </div>
</header>
<div class="dashboard">
  <div class="logo">
    <h2>Dashboard</h2>
  </div>
  <div class="main-dashboard">
    <ul>
      <li><a href="/employee"><i class="fa-solid fa-calendar-days"></i>Chấm công</a></li>
      <li> <a href="/employee/my-info"><i class="fa-solid fa-user"></i>Thông tin cá nhân</a></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
      <a href=" #" onclick="logout(event)">
        Đăng xuất
      </a>
    </form>
  </div>
</div>

<script>
  function logout(event) {
    event.preventDefault();
    const confirmLogout = confirm('Bạn có chắc chắn muốn đăng xuất không?');
    if (confirmLogout) {
      document.getElementById('logout-form').submit();
    }
  }
</script>