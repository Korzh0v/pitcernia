// Modal functions
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

// Close modal when clicking outside
window.onclick = function (event) {
  const modals = document.querySelectorAll(".modal");
  modals.forEach((modal) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
};