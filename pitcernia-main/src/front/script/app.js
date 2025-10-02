// Render pizza menu
function renderMenu() {
  const menuContainer = document.getElementById("menuContainer");

  menuContainer.innerHTML = pizzas
    .map(
      (pizza) => `
      <div class="pizza-item">
        <div class="pizza-info">
          <div class="pizza-name">${pizza.name}</div>
          <div class="pizza-description">${pizza.description}</div>
          <div class="pizza-price">${pizza.price.toFixed(2)} zł</div>
        </div>
        <div class="pizza-actions">
          <input type="number" class="quantity-input" id="qty-${pizza.id}" value="1" min="1" max="10">
          <button class="add-to-cart" onclick="addToCart(${pizza.id})">
            Dodaj do koszyka
          </button>
        </div>
      </div>
    `
    )
    .join("");
}

// Initialize page
document.addEventListener("DOMContentLoaded", function () {
  renderMenu();
  checkLoginStatus();
  updateCartCount();
});