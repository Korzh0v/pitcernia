function toggleUserDropdown() {
  const dropdown = document.getElementById("userDropdown");
  dropdown.classList.toggle("show");
}

document.addEventListener('click', function(event) {
  const userMenu = document.querySelector('.user-menu');
  const dropdown = document.getElementById("userDropdown");
  
  if (dropdown && !userMenu.contains(event.target)) {
    dropdown.classList.remove("show");
  }
});

function openProfileModal() {
  document.getElementById("profileModal").style.display = "block";
  document.getElementById("userDropdown").classList.remove("show");
  loadUserProfile();
}

function openOrderHistoryModal() {
  document.getElementById("orderHistoryModal").style.display = "block";
  document.getElementById("userDropdown").classList.remove("show");
  loadOrderHistory();
}

function openSettingsModal() {
  document.getElementById("settingsModal").style.display = "block";
  document.getElementById("userDropdown").classList.remove("show");
}

function openSupportModal() {
  document.getElementById("supportModal").style.display = "block";
  document.getElementById("userDropdown").classList.remove("show");
}

function loadUserProfile() {
  fetch("../back/get_user_profile.php")
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.getElementById("profileUsername").value = data.user.nazwa;
        document.getElementById("profileEmail").value = data.user.email;
        document.getElementById("profileAddress").value = data.user.adres;
      }
    })
    .catch(error => console.error('Error loading profile:', error));
}

function loadOrderHistory() {
  fetch("../back/get_order_history.php")
    .then(response => response.json())
    .then(data => {
      const historyContainer = document.getElementById("orderHistoryContent");
      if (data.success && data.orders.length > 0) {
        historyContainer.innerHTML = data.orders.map(order => `
          <div class="order-item">
            <div class="order-header">
              <strong>Zamówienie #${order.id}</strong>
              <span class="order-date">${order.data_zamowienia}</span>
            </div>
            <div class="order-total">Suma: ${order.suma_cena} zł</div>
            <div class="order-status">Status: ${order.status}</div>
          </div>
        `).join('');
      } else {
        historyContainer.innerHTML = '<p style="text-align: center;">Brak zamówień w historii</p>';
      }
    })
    .catch(error => console.error('Error loading order history:', error));
}


function saveUserProfile() {
  const formData = new FormData();
  formData.append('username', document.getElementById("profileUsername").value);
  formData.append('email', document.getElementById("profileEmail").value);
  formData.append('address', document.getElementById("profileAddress").value);

  fetch("../back/update_profile.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Profil został zaktualizowany!");
        closeModal('profileModal');
      } else {
        alert("Błąd podczas aktualizacji profilu: " + data.message);
      }
    })
    .catch(error => {
      console.error('Error updating profile:', error);
      alert("Wystąpił błąd podczas aktualizacji profilu");
    });
}


