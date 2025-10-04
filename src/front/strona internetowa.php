<?php include "../back/filter_logic.php"; ?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pizzeria</title>
  <link rel="stylesheet" href="../front/style/style.css" />
</head>

<body>
  <div class="header">
    <h1>Menu Pizzerii</h1>
    <div class="auth-buttons" id="authButtons"></div>
  </div>

  <button id="butt1" onclick="openCart()">
    Koszyk
    <span id="cartCount" class="cart-count" style="display: none">0</span>
  </button>

  <div class="main-container">
    <!-- Filters Sidebar -->
    <aside class="filters-sidebar">
      <h3>Filtry</h3>
      <form method="GET">
        <div class="filter-section">
          <label>Składniki:</label>
          <div class="checkbox-group">
            <?php
            $wszystkieSkladniki = [
              "sos pomidorowy",
              "sos kremowy",
              "mozzarella",
              "podwójna mozzarella",
              "szynka",
              "pieczarki",
              "boczek",
              "cebula",
              "ananas",
              "pepperoni",
              "kukurydza",
              "pomidorki koktajlowe",
              "papryka",
              "oregano",
              "papryczki jalapeno"
            ];
            foreach ($wszystkieSkladniki as $s) {
              $checked = in_array($s, $ingredients) ? "checked" : "";
              echo "<label><input type='checkbox' name='ingredients[]' value='$s' $checked> $s</label>";
            }
            ?>
          </div>
        </div>

        <div class="filter-section">
          <label>Rozmiar:</label>
          <select name="size">
            <option value="">Dowolny</option>
            <option value="mały" <?php if ($size == "mały") echo "selected"; ?>>Mały (24cm)</option>
            <option value="średni" <?php if ($size == "średni") echo "selected"; ?>>Średni (32cm)</option>
            <option value="duży" <?php if ($size == "duży") echo "selected"; ?>>Duży (40cm)</option>
          </select>
        </div>

        <div class="filter-section">
          <label>Cena (zł):</label>
          <div class="price-range">
            <input type="number" name="minPrice" placeholder="Od" value="<?php echo $minPrice; ?>">
            <span>-</span>
            <input type="number" name="maxPrice" placeholder="Do" value="<?php echo $maxPrice; ?>">
          </div>
        </div>

        <div class="filter-section">
          <button type="submit">Szukaj</button>
        </div>
      </form>
    </aside>

    <!-- Pizza Grid -->
    <main>
      <div class="pizza-grid">
        <?php
        if (!empty($pizze)) {
          $grupy = [];
          foreach ($pizze as $p) {
            $grupy[$p['nazwa']][] = $p;
          }

          foreach ($grupy as $nazwa => $warianty) {
            $zdjecie = $warianty[0]['obrazek'];
            $skladniki = $warianty[0]['skladniki'];

            echo "<div class='pizza-card'>";
            echo "<img src='../../public/img/$zdjecie' alt='$nazwa' class='pizza-image'>";
            echo "<div class='pizza-content'>";
            echo "<div class='pizza-name'>$nazwa</div>";
            echo "<div class='pizza-description'>$skladniki</div>";

            echo "<div class='size-options'>";
            $firstSize = true;
            foreach ($warianty as $w) {
              $rozmiarDisplay = $w['rozmiar'];
              $cm = "";
              if ($w['rozmiar'] == "mały") $cm = " (24cm)";
              if ($w['rozmiar'] == "średni") $cm = " (32cm)";
              if ($w['rozmiar'] == "duży") $cm = " (40cm)";

              $checked = $firstSize ? "checked" : "";
              $firstSize = false;

              echo "<div class='size-option'>";
              echo "<input type='radio' name='size_$nazwa' id='size_{$w['id']}' value='{$w['id']}' data-pizza-name='$nazwa' data-size='$rozmiarDisplay' data-price='{$w['cena']}' $checked>";
              echo "<label for='size_{$w['id']}'>$rozmiarDisplay$cm - <strong>{$w['cena']} zł</strong></label>";
              echo "</div>";
            }
            echo "</div>";

            echo "<div class='pizza-actions'>";
            echo "<input type='number' class='quantity-input' id='qty_" . str_replace(' ', '_', $nazwa) . "' value='1' min='1' max='10'>";
            echo "<button class='add-to-cart' onclick='addToCartFromDB(\"$nazwa\")'>Dodaj do koszyka</button>";
            echo "</div>";
            echo "<a href='#' class='details-link' onclick='showPizzaDetails(\"" . urlencode($nazwa) . "\"); return false;'>Szczegóły</a>";
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<div class='no-results'>Brak wyników wyszukiwania</div>";
        }
        ?>
      </div>
    </main>
  </div>

  <!-- Pizza Details Modal -->
  <div id="pizzaDetailsModal" class="modal">
    <div class="modal-content" style="max-width: 700px;">
      <span class="close" onclick="closeModal('pizzaDetailsModal')">&times;</span>
      <div id="pizzaDetailsContent">
        <!-- Content will be loaded dynamically -->
      </div>
    </div>
  </div>

  <!-- Login Modal -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('loginModal')">&times;</span>
      <h2>Zaloguj się</h2>
      <form action="../back/login.php" method="POST">
        <div class="form-group">
          <label for="loginUsername">Nazwa użytkownika:</label>
          <input type="text" id="loginUsername" name="username" required />
        </div>
        <div class="form-group">
          <label for="loginPassword">Hasło:</label>
          <input type="password" id="loginPassword" name="password" required />
        </div>
        <button type="submit" class="submit-btn">Zaloguj się</button>
      </form>
      <button type="button" class="forgot-pass-btn" onclick="openResetPasswordModal()">
        Zapomniałeś hasła?
      </button>
      <div class="form-footer">
        <p>Nie masz konta? <a onclick="switchToRegister()">Zarejestruj się</a></p>
      </div>
    </div>
  </div>

  <!-- Register Modal -->
  <div id="registerModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('registerModal')">&times;</span>
      <h2>Zarejestruj się</h2>
      <form action="../back/action_page.php" method="POST" onsubmit="return validateForm()">
        <div class="form-group">
          <label for="registerUsername">Nazwa użytkownika:</label>
          <input type="text" id="registerUsername" name="username" required />
        </div>
        <div class="form-group">
          <label for="registerEmail">Email:</label>
          <input type="email" id="registerEmail" name="email" required />
        </div>
        <div class="form-group">
          <label for="registerAddress">Adres:</label>
          <textarea id="registerAddress" name="address" placeholder="Ulica, numer domu/mieszkania, kod pocztowy, miasto" required></textarea>
        </div>
        <div class="form-group">
          <label for="registerPassword">Hasło:</label>
          <input type="password" id="registerPassword" name="password" required />
          <div class="password-requirements">Hasło musi mieć co najmniej 6 znaków</div>
        </div>
        <div class="form-group">
          <label for="confirmPassword">Potwierdź hasło:</label>
          <input type="password" id="confirmPassword" name="psw-repeat" required />
          <div id="passwordError" class="error-message">Hasła nie są identyczne</div>
        </div>
        <button type="submit" class="submit-btn">Zarejestruj się</button>
      </form>
    </div>
  </div>

  <!-- Profile Modal -->
  <div id="profileModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('profileModal')">&times;</span>
      <h2>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
          <circle cx="12" cy="7" r="4" />
        </svg>
        Mój profil
      </h2>
      <form onsubmit="event.preventDefault(); saveUserProfile();">
        <div class="form-group">
          <label for="profileUsername">Nazwa użytkownika:</label>
          <input type="text" id="profileUsername" name="username" required />
        </div>
        <div class="form-group">
          <label for="profileEmail">Email:</label>
          <input type="email" id="profileEmail" name="email" required />
        </div>
        <div class="form-group">
          <label for="profileAddress">Adres:</label>
          <textarea id="profileAddress" name="address" placeholder="Ulica, numer domu/mieszkania, kod pocztowy, miasto" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Zapisz zmiany</button>
        <button type="button" class="secondary-btn" onclick="openChangePasswordModal()">Zmień hasło</button>
      </form>
    </div>
  </div>

  <!-- Change Password Modal -->
  <div id="changePasswordModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('changePasswordModal')">&times;</span>
      <h2>Zmiana hasła</h2>
      <form onsubmit="event.preventDefault(); changePassword();">
        <div class="form-group">
          <label for="currentPassword">Aktualne hasło:</label>
          <input type="password" id="currentPassword" required />
        </div>
        <div class="form-group">
          <label for="newPassword">Nowe hasło:</label>
          <input type="password" id="newPassword" required minlength="6" />
          <div class="password-requirements">Hasło musi mieć co najmniej 6 znaków</div>
        </div>
        <div class="form-group">
          <label for="confirmNewPassword">Potwierdź nowe hasło:</label>
          <input type="password" id="confirmNewPassword" required />
        </div>
        <button type="submit" class="submit-btn">Zmień hasło</button>
      </form>
    </div>
  </div>

  <!-- Order History Modal -->
  <div id="orderHistoryModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('orderHistoryModal')">&times;</span>
      <h2>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 11H5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h4l3 3V8l-3 3Z" />
          <path d="M22 11v-1a2 2 0 0 0-2-2h-1" />
        </svg>
        Historia zamówień
      </h2>
      <div id="orderHistoryContent" class="content-container"></div>
    </div>
  </div>

  <!-- Reset Password Modal -->
  <div id="resetPasswordModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('resetPasswordModal')">&times;</span>
      <h2>Resetowanie hasła</h2>
      <form id="resetForm">
        <div class="form-group">
          <label for="resetEmail">Adres E-mail:</label>
          <input type="email" id="resetEmail" name="email" placeholder="twoj@email.com" required>
        </div>
        <button type="submit" class="submit-btn">Wyślij Link Resetujący</button>
      </form>
      <p id="resetMessage" style="margin-top:10px; font-size:14px;"></p>
      <div class="back-link" style="margin-top: 15px;">
        <a href="#" onclick="switchToLoginFromReset()">← Powrót do logowania</a>
      </div>
    </div>
  </div>

  <!-- Support Modal -->
  <div id="supportModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('supportModal')">&times;</span>
      <h2>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10" />
          <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
          <line x1="12" y1="17" x2="12.01" y2="17" />
        </svg>
        Pomoc i wsparcie
      </h2>
      <div class="support-container">
        <div class="faq-section">
          <h3>Często zadawane pytania:</h3>
          <div class="faq-item">
            <h4>Jak złożyć zamówienie?</h4>
            <p>Wybierz pizzę z menu, dodaj do koszyka i kliknij "Złóż zamówienie".</p>
          </div>
          <div class="faq-item">
            <h4>Jak długo trwa dostawa?</h4>
            <p>Standardowy czas dostawy wynosi 30-45 minut.</p>
          </div>
          <div class="faq-item">
            <h4>Jakie są sposoby płatności?</h4>
            <p>Przyjmujemy gotówkę, karty płatnicze i płatności online.</p>
          </div>
        </div>
        <div class="contact-section">
          <h3>Kontakt:</h3>
          <p><strong>Telefon:</strong> +48 123 456 789</p>
          <p><strong>Email:</strong> kontakt@pizzeria.pl</p>
          <p><strong>Adres:</strong> ul. Pizzowa 123, 00-001 Warszawa</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Cart Modal -->
  <div id="cartModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('cartModal')">&times;</span>
      <h2>Koszyk</h2>
      <div id="cartItems"></div>
      <div id="cartTotal" style="text-align: center; font-size: 18px; font-weight: bold; margin-top: 20px;"></div>
      <button id="checkoutBtn" class="submit-btn" onclick="checkout()" style="margin-top: 20px; display: none">Złóż zamówienie</button>
    </div>
  </div>

  <script src="../front/script/user-menu.js"></script>
  <script src="../front/script/data.js"></script>
  <script src="../front/script/auth.js"></script>
  <script src="../front/script/cart.js"></script>
  <script src="../front/script/modals.js"></script>
  <script src="../front/script/app.js"></script>
  <script src="../front/script/reset-password.js"></script>
  <script src="../front/script/update-profile.js"></script>

  <script>
    // Funkcja ładowania szczegółów pizzy
    async function showPizzaDetails(pizzaName) {
      try {
        const response = await fetch(`../back/get_pizza_details.php?nazwa=${pizzaName}`);
        const data = await response.json();

        if (data.error) {
          alert(data.error);
          return;
        }

        let html = `
          <div style="text-align: center;">
            <h2 style="margin-bottom: 20px; color: #d32f2f;">${data.nazwa}</h2>
            <img src="../../public/img/${data.obrazek}" alt="${data.nazwa}" 
                 style="max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 20px;">
            
            <div style="text-align: left; padding: 0 20px;">
              <h3 style="color: #333; margin-top: 20px;">Składniki:</h3>
              <p style="font-size: 16px; color: #666; line-height: 1.6;">${data.skladniki}</p>
              
              <h3 style="color: #333; margin-top: 20px;">Opis:</h3>
              <p style="font-size: 16px; color: #666; line-height: 1.6;">${data.opis}</p>
              
              <h3 style="color: #333; margin-top: 20px;">Dostępne rozmiary:</h3>
              <div style="margin-top: 15px;">
        `;

        data.rozmiary.forEach((r, index) => {
          let cm = "";
          if (r.rozmiar === "mały") cm = "24cm";
          if (r.rozmiar === "średni") cm = "32cm";
          if (r.rozmiar === "duży") cm = "40cm";

          html += `
            <div style="display: flex; align-items: center; justify-content: space-between; 
                        padding: 15px; background: #f5f5f5; border-radius: 8px; margin-bottom: 10px;">
              <div>
                <input type="radio" name="detailSize" id="detailSize${index}" 
                       value="${r.id}" data-price="${r.cena}" data-size="${r.rozmiar}" 
                       ${index === 0 ? 'checked' : ''}>
                <label for="detailSize${index}" style="margin-left: 10px; font-size: 16px;">
                  <strong>${r.rozmiar}</strong> (${cm}) - <span style="color: #d32f2f; font-weight: bold;">${r.cena} zł</span>
                </label>
              </div>
            </div>
          `;
        });

        html += `
              </div>
              <div style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
                <label>Ilość:</label>
                <input type="number" id="detailQuantity" value="1" min="1" max="10" 
                       style="width: 60px; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                <button onclick="addToCartFromDetails('${data.nazwa}')" 
                        style="flex: 1; padding: 12px; background: #d32f2f; color: white; 
                               border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;">
                  Dodaj do koszyka
                </button>
              </div>
            </div>
          </div>
        `;

        document.getElementById('pizzaDetailsContent').innerHTML = html;
        openModal('pizzaDetailsModal');
      } catch (error) {
        alert('Błąd podczas ładowania szczegółów pizzy');
        console.error(error);
      }
    }

    // Dodawanie do koszyka z modala szczegółów
    function addToCartFromDetails(pizzaName) {
      const selectedRadio = document.querySelector('input[name="detailSize"]:checked');
      const quantity = parseInt(document.getElementById('detailQuantity').value);

      if (!selectedRadio) {
        alert('Wybierz rozmiar pizzy');
        return;
      }

      const pizzaId = parseInt(selectedRadio.value);
      const size = selectedRadio.dataset.size;
      const price = parseFloat(selectedRadio.dataset.price);
      const fullName = pizzaName + ' (' + size + ')';

      const existingItem = cart.find(item => item.id === pizzaId);
      if (existingItem) {
        existingItem.quantity += quantity;
      } else {
        cart.push({
          id: pizzaId,
          name: fullName,
          price: price,
          quantity: quantity
        });
      }

      updateCartCount();
      renderCart();
      closeModal('pizzaDetailsModal');
      alert('Dodano do koszyka!');
    }

    function addToCartFromDB(pizzaName) {
      const sanitizedName = pizzaName.replace(/ /g, '_');
      const quantity = parseInt(document.getElementById('qty_' + sanitizedName).value);

      const selectedRadio = document.querySelector(`input[name="size_${pizzaName}"]:checked`);
      if (!selectedRadio) {
        alert('Wybierz rozmiar pizzy');
        return;
      }

      const pizzaId = parseInt(selectedRadio.value);
      const size = selectedRadio.dataset.size;
      const price = parseFloat(selectedRadio.dataset.price);
      const fullName = pizzaName + ' (' + size + ')';

      const existingItem = cart.find(item => item.id === pizzaId);
      if (existingItem) {
        existingItem.quantity += quantity;
      } else {
        cart.push({
          id: pizzaId,
          name: fullName,
          price: price,
          quantity: quantity
        });
      }

      updateCartCount();
      renderCart();
      document.getElementById('qty_' + sanitizedName).value = 1;
      alert('Dodano do koszyka!');
    }

    function switchToLoginFromReset() {
      closeModal("resetPasswordModal");
      openModal("loginModal");
    }

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

    function switchToRegister() {
      closeModal('loginModal');
      openModal('registerModal');
    }

    window.onclick = function(event) {
      if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
      }
    }
  </script>
</body>

</html>