function addToCart(pizzaId) {
  const pizza = pizzas.find((p) => p.id === pizzaId);
  const quantity = parseInt(document.getElementById(`qty-${pizzaId}`).value);

  const existingItem = cart.find((item) => item.id === pizzaId);

  if (existingItem) {
    existingItem.quantity += quantity;
  } else {
    cart.push({ id: pizzaId, name: pizza.name, price: pizza.price, quantity: quantity });
  }

  updateCartCount();
  renderCart();
  document.getElementById(`qty-${pizzaId}`).value = 1;
}

function updateCartCount() {
  const cartCount = document.getElementById("cartCount");
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

  cartCount.textContent = totalItems;
  cartCount.style.display = totalItems > 0 ? "inline" : "none";
}

function openCart() {
  renderCart();
  document.getElementById("cartModal").style.display = "block";
}

function renderCart() {
  const cartItems = document.getElementById("cartItems");
  const cartTotal = document.getElementById("cartTotal");
  const checkoutBtn = document.getElementById("checkoutBtn");

  if (cart.length === 0) {
    cartItems.innerHTML = '<p style="text-align: center;">Koszyk jest pusty</p>';
    cartTotal.innerHTML = "";
    checkoutBtn.style.display = "none";
    return;
  }

  let total = 0;
  cartItems.innerHTML = cart
    .map((item) => {
      const itemTotal = item.price * item.quantity;
      total += itemTotal;

      return `
      <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #eee;">
        <div>
          <strong>${item.name}</strong><br>
          <small>${item.price.toFixed(2)} zł x ${item.quantity}</small>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
          <span>${itemTotal.toFixed(2)} zł</span>
          <button onclick="removeFromCart(${item.id})" style="background: #e74c3c; color: white; border: none; border-radius: 3px; padding: 5px 10px; cursor: pointer;">
            Usuń
          </button>
        </div>
      </div>
    `;
    })
    .join("");

  cartTotal.innerHTML = `Suma: ${total.toFixed(2)} zł`;
  checkoutBtn.style.display = "block";
}

function removeFromCart(pizzaId) {
  cart = cart.filter((item) => item.id !== pizzaId);
  updateCartCount();
  renderCart();
}

function checkout() {
  if (cart.length === 0) {
    alert("Koszyk jest pusty!");
    return;
  }

  fetch("../back/checkout.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ cart: cart }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Zamówienie zostało złożone pomyślnie!");
        cart = [];
        updateCartCount();
        renderCart();
        closeModal("cartModal");
      } else {
        alert("Błąd podczas składania zamówienia: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Wystąpił błąd podczas składania zamówienia");
    });
}