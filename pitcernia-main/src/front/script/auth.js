function checkLoginStatus() {
  fetch("../back/check_login.php")
    .then(response => response.json())
    .then(data => {
      updateAuthButtons(data);
    })
    .catch(error => {
      console.error('Error checking login status:', error);
      updateAuthButtons({ logged_in: false });
    });
}

function updateAuthButtons(loginData) {
  const authButtons = document.getElementById("authButtons");
  
  if (loginData.logged_in) {
    authButtons.innerHTML = `
      <div class="user-menu">
        <button class="user-icon-btn" onclick="toggleUserDropdown()">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          <span class="username">${loginData.user_name}</span>
          <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6,9 12,15 18,9"/>
          </svg>
        </button>
        <div class="user-dropdown" id="userDropdown">
          <div class="dropdown-item user-greeting">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Witaj, ${loginData.user_name}!</span>
          </div>
          <div class="dropdown-divider"></div>
          
          <button class="dropdown-item menu-btn" onclick="openProfileModal()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            Mój profil
          </button>
          
          <button class="dropdown-item menu-btn" onclick="openOrderHistoryModal()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 11H5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h4l3 3V8l-3 3Z"/>
              <path d="M22 11v-1a2 2 0 0 0-2-2h-1"/>
            </svg>
            Historia zamówień
          </button>
          
          
          <button class="dropdown-item menu-btn" onclick="openSupportModal()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
              <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Pomoc
          </button>
          
          <div class="dropdown-divider"></div>
          
          <button class="dropdown-item logout-btn" onclick="logout()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
              <polyline points="16,17 21,12 16,7"/>
              <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Wyloguj się
          </button>
        </div>
      </div>
    `;
  } else {
    authButtons.innerHTML = `
      <button class="auth-btn" onclick="openLoginModal()">Zaloguj się</button>
      <button class="auth-btn register" onclick="openRegisterModal()">Zarejestruj się</button>
    `;
  }
}

// Logout function
function logout() {
  fetch("../back/logout.php")
    .then(() => {
      checkLoginStatus(); // Refresh the auth buttons
      alert("Zostałeś wylogowany!");
    })
    .catch(error => {
      console.error('Logout error:', error);
      alert("Wystąpił błąd podczas wylogowywania");
    });
}