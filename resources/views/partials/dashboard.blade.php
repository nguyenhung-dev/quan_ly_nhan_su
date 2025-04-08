<header class="admin-menu">
  <h1>Quản lý nhân sự</h1>
  <div class="header-action">
    <div class="message">
      <i class="fa-solid fa-message"></i>
    </div>
    <div class="notifi">
      <i class="fa-solid fa-bell"></i>
    </div>
    <div class="avatar">
      <a href="{{route('admin.users.index')}}">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9z2IpZagy0I6RWL80m6dFmz60PsauqPR9Bw&s"
          alt="avatar" width="45" height="45">
        <span>Admin</span>
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
      <li><a href="{{route('admin.index')}}"><i class="fa-solid fa-chart-simple"></i>Thống kê</a></li>
      <li><a href="{{route('admin.users.index')}}"><i class="fa-solid fa-users"></i>Quản lý nhân sự</a></li>
      <li> <a href="{{route('admin.position.index')}}"><i class="fa-solid fa-user-tie"></i>Quản lý chức vụ</a></li>
      <li> <a href=""><i class="fa-solid fa-clock"></i>Quản lý giờ làm</a></li>
      <li><a href="/admin/attendances"><i class="fa-solid fa-calendar-days"></i>Quản lý chấm công</a>
      </li>
      <li> <a href=""><i class="fa-solid fa-money-bill-1-wave"></i>Quản lý lương</a></li>
      <li><a href=""><i class="fa-solid fa-award"></i>Khen thưởng / kỷ luật</a></li>
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