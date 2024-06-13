document.addEventListener('DOMContentLoaded', function () {
    const userNavItem = document.getElementById('user-nav-item');
    const token = localStorage.getItem('user');
  
    if (token) {
      // User is logged in, modify the nav item
      userNavItem.innerHTML = `
        <div class="dropdown">
          <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg class="user">
              <use xlink:href="#user"></use>
            </svg>
          </a>
          <ul class="dropdown-menu" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="#profile">Profile</a></li>
            <li><a class="dropdown-item" href="#" id="logout">Logout</a></li>
          </ul>
        </div>
      `;
  
      // Add logout functionality
      document.getElementById('logout').addEventListener('click', function () {
        localStorage.removeItem('user');
        location.reload();
      });
    }
  });
  