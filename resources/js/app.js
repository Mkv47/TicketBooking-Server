import axios from 'axios';
import './bootstrap';


document.addEventListener("DOMContentLoaded", function () {
  const bookingForm = document.getElementById("bookingForm");
  const formMessage = document.getElementById("formMessage");
  const ticketType = document.getElementById("ticketType");
  const promoCode = document.getElementById("promoCode");
  const totalPrice = document.getElementById("totalPrice");
  const finalPrice = document.getElementById("finalPrice");

  function updateTotal() {
    const ticketTypeValue = ticketType.value;
    const promoCodeValue = promoCode.value.trim();

    axios.post('/get-price', {
      ticket_type: ticketTypeValue,
      promo_code: promoCodeValue,
    })
    .then(response => {
      const price = parseFloat(response.data.price);
      totalPrice.textContent = `$${price.toFixed(2)}`;
      finalPrice.value = price.toFixed(2);
    })
    .catch(error => {
      console.error("Failed to calculate price:", error);
      totalPrice.textContent = "$0.00";
      finalPrice.value = "0.00";
    });
  }

  ticketType.addEventListener("change", updateTotal);
  promoCode.addEventListener("input", updateTotal);
  updateTotal(); // initial call

  bookingForm.addEventListener("submit", function (e) {
    e.preventDefault();
    formMessage.textContent = "";

    const formData = new FormData(bookingForm);

    axios.post('/booking', formData)
      .then(response => {
        formMessage.style.color = "green";
        formMessage.textContent = response.data.message || "Booking successful!";
        bookingForm.reset();
        updateTotal();
      })
      .catch(error => {
        formMessage.style.color = "red";
        if (error.response && error.response.data.errors) {
          const errors = error.response.data.errors;
          formMessage.textContent = Object.values(errors).flat().join('\n');
        } else {
          formMessage.textContent = "An error occurred. Please try again.";
        }
      });
  });

  window.toggleAdminOverlay = function () {
  const overlay = document.getElementById('adminLoginOverlay');
  overlay.classList.toggle('hidden');
  };

  document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const messageDiv = document.getElementById('adminLoginMessage');
    
    axios.post('/admin/login', formData)
      .then(response => {
        if (response.data.success) {
          window.location.href = response.data.redirect;
        }
      })
      .catch(error => {
        messageDiv.textContent = error.response?.data?.message || 'Login failed.';
        messageDiv.style.color = 'red';
      });
  });
});