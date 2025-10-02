    function changePassword() {
      const current = document.getElementById('currentPassword').value;
      const newPass = document.getElementById('newPassword').value;
      const confirm = document.getElementById('confirmNewPassword').value;

      if (newPass !== confirm) {
        alert('Nowe hasła nie są identyczne');
        return;
      }

      if (newPass.length < 6) {
        alert('Hasło musi mieć co najmniej 6 znaków');
        return;
      }

      const formData = new FormData();
      formData.append('current_password', current);
      formData.append('new_password', newPass);

      fetch('../back/change_password.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Hasło zostało zmienione!');
            closeModal('changePasswordModal');
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmNewPassword').value = '';
          } else {
            alert('Błąd: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Wystąpił błąd podczas zmiany hasła');
        });
    }

    