// app.js

document.addEventListener("DOMContentLoaded", () => {
  // Obsługa logowania / wylogowania
  checkLoginStatus();

  // Event listenery do przycisków logowania/rejestracji
  const loginBtn = document.getElementById("loginBtn");
  const registerBtn = document.getElementById("registerBtn");
  const logoutBtn = document.getElementById("logoutBtn");

  if (loginBtn) {
    loginBtn.addEventListener("click", () => openModal("loginModal"));
  }

  if (registerBtn) {
    registerBtn.addEventListener("click", () => openModal("registerModal"));
  }

  if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
      fetch("../back/logout.php")
        .then(() => {
          alert("Wylogowano!");
          location.reload();
        })
        .catch((err) => console.error("Błąd wylogowania:", err));
    });
  }
});
