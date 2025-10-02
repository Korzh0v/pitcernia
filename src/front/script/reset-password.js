// Umieść ten kod w nowym pliku: front/script/reset-password.js

document.addEventListener("DOMContentLoaded", function() {
  const resetForm = document.getElementById("resetForm");
  
  if (resetForm) {
    resetForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      console.log("Formularz został wysłany"); // Debug
      
      const emailInput = document.getElementById("email");
      const message = document.getElementById("resetMessage");
      
      if (!emailInput || !message) {
        console.error("Nie znaleziono elementów formularza");
        return;
      }
      
      const email = emailInput.value;
      console.log("Email:", email); // Debug
      
      // Wyczyść poprzedni komunikat
      message.textContent = "Wysyłanie...";
      message.style.color = "blue";
      
      try {
        const response = await fetch("../back/reset_request.php", {
          method: "POST",
          headers: { 
            "Content-Type": "application/x-www-form-urlencoded" 
          },
          body: "email=" + encodeURIComponent(email)
        });
        
        const text = await response.text();
        console.log("Odpowiedź backendu:", text); // Debug
        
        if (text.startsWith("OK")) {
          const parts = text.split("|");
          message.style.color = "green";
          message.innerHTML = "✓ Link resetujący został wygenerowany:<br>" + parts[1];
          emailInput.value = ""; // Wyczyść pole
        } else {
          message.style.color = "red";
          message.textContent = "✗ " + text;
        }
      } catch (err) {
        console.error("Błąd:", err); // Debug
        message.style.color = "red";
        message.textContent = "✗ Wystąpił błąd. Spróbuj ponownie później.";
      }
    });
  } else {
    console.error("Nie znaleziono formularza resetForm");
  }
});