function openLoginModal() {
  document.getElementById("loginModal").style.display = "block";
}

function openRegisterModal() {
  document.getElementById("registerModal").style.display = "block";
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}

function switchToRegister() {
  closeModal("loginModal");
  openRegisterModal();
}

function switchToLogin() {
  closeModal("registerModal");
  openLoginModal();
}

window.onclick = function (event) {
  const modals = document.querySelectorAll(".modal");
  modals.forEach((modal) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
};

function openResetPasswordModal() {
  closeModal("loginModal");
  openModal("resetPasswordModal");
}


function openChangePasswordModal() {
  closeModal('profileModal');
  openModal('changePasswordModal');
}

function openModal(modalId) {
  document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}

document.getElementById("resetForm").addEventListener("submit", async function (e) {
  e.preventDefault();

  const email = document.getElementById("resetEmail").value;
  const message = document.getElementById("resetMessage");

  try {
    const response = await fetch("back/reset_request.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "email=" + encodeURIComponent(email)
    });

    const text = await response.text();

    if (text.trim() === "OK") {
      message.style.color = "green";
      message.textContent = "Na Twój e-mail został wysłany link do resetu hasła.";
    } else {
      message.style.color = "red";
      message.textContent = text;
    }

  } catch (err) {
    message.style.color = "red";
    message.textContent = "Wystąpił błąd. Spróbuj ponownie później.";
  }
});
