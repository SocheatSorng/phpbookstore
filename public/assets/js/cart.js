// Move escapeHtml function outside of DOMContentLoaded
function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

document.addEventListener("DOMContentLoaded", function () {
  // =============== PART 1: Add to Cart Functionality =================
  document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const bookId = this.getAttribute("data-book-id");
      // Add loading state
      this.disabled = true;
      const originalText = this.innerHTML;
      this.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
      addToCart(bookId, this, originalText);
    });
  });

  // =============== PART 2: Remove from Cart Functionality =================
  document.body.addEventListener("click", function (e) {
    const removeBtn = e.target.closest(".remove-item");
    if (removeBtn) {
      e.preventDefault();
      const url = removeBtn.getAttribute("data-url");

      fetch(url)
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // If successfully removed, refresh the cart UI with new data
            refreshCartUI(data.cart_items, data.cart_count, data.cart_total);
            showMessage("Item removed from cart", "success");
          } else {
            console.error("Error removing item:", data.message);
            showMessage("Failed to remove item from cart", "error");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showMessage("An error occurred while removing the item", "error");
        });
    }
  });
});

function addToCart(bookId, button, originalText) {
  console.log("Sending request to add book ID:", bookId); // Debug log

  fetch(`${SITE_ROOT}/cart/add`, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `book_id=${bookId}&quantity=1`,
  })
    .then(handleResponse)
    .then(handleSuccess)
    .catch(handleError)
    .finally(() => resetButton(button, originalText));
}

function handleResponse(response) {
  console.log("Response status:", response.status); // Debug log
  if (!response.ok) {
    throw new Error("Network response was not ok");
  }
  return response.json();
}

function handleSuccess(data) {
  console.log("Response data:", data); // Debug log
  if (data.success) {
    refreshCartUI(data.cart_items, data.cart_count, data.cart_total);
    showMessage("Book added to cart successfully!", "success");
  } else {
    throw new Error(data.message || "Error adding item to cart");
  }
}

function handleError(error) {
  console.error("Error:", error);
  showMessage(error.message, "error");
  alert("Error: " + error.message); // Debug alert
}

function resetButton(button, originalText) {
  if (button) {
    button.disabled = false;
    button.innerHTML = originalText;
  }
}

function updateCartTotal(total) {
  const cartTotalElements = document.querySelectorAll(".cart-total");
  cartTotalElements.forEach((element) => {
    element.textContent = `$${parseFloat(total).toFixed(2)}`;
  });
}
// Helper function to update cart count displays
function updateCartCount(count) {
  document
    .querySelectorAll(
      ".cart-count, .cart-dropdown .fs-6.fw-light, .badge.bg-primary.rounded-pill"
    )
    .forEach((element) => {
      if (element.classList.contains("fs-6")) {
        element.textContent = `(${count})`;
      } else if (element.classList.contains("badge")) {
        element.textContent = count;
      } else {
        element.textContent = count;
      }
    });
}

function refreshCartUI(cartItems, cartCount, cartTotal) {
  // Update cart count in all locations
  updateCartCount(cartCount);

  // Update cart total
  const cartTotalElement = document.getElementById("cart-total");
  if (cartTotalElement) {
    cartTotalElement.textContent = `$${parseFloat(cartTotal).toFixed(2)}`;
  }

  // Refresh the entire dropdown content
  const cartList = document.querySelector(".cart-dropdown .list-group");
  if (!cartList) return;

  // If cart is empty
  if (!cartItems || cartItems.length === 0) {
    cartList.innerHTML = `
      <li class="list-group-item bg-transparent text-center">
        Your cart is empty
      </li>
    `;

    // Hide checkout button
    const checkoutBtn = document.querySelector(".cart-dropdown .btn-primary");
    if (checkoutBtn) {
      checkoutBtn.style.display = "none";
    }
    return;
  }

  // If cart has items, rebuild the entire cart list
  let html = "";
  let total = 0;

  cartItems.forEach((item) => {
    total += parseFloat(item.Price) * parseInt(item.Quantity);
    html += `
      <li class="list-group-item bg-transparent d-flex justify-content-between lh-sm">
        <div>
          <h5>
            <a href="${SITE_ROOT}/singleproduct/${item.BookID}">${escapeHtml(
      item.Title
    )}</a>
          </h5>
          <small>Quantity: ${item.Quantity} × $${parseFloat(item.Price).toFixed(
      2
    )}</small>
          <br>
          <a href="#" 
            data-url="${SITE_ROOT}/cart/remove?book_id=${item.BookID}" 
            class="btn btn-sm btn-danger mt-2 remove-item">
            Remove
          </a>
        </div>
        <span class="text-primary">$${(
          parseFloat(item.Price) * parseInt(item.Quantity)
        ).toFixed(2)}</span>
      </li>
    `;
  });

  html += `
    <li class="list-group-item bg-transparent d-flex justify-content-between">
      <span class="text-capitalize"><b>Total (USD)</b></span>
      <strong>$${parseFloat(total).toFixed(2)}</strong>
    </li>
  `;

  cartList.innerHTML = html;

  // Show checkout button
  const checkoutBtn = document.querySelector(".cart-dropdown .btn-primary");
  if (checkoutBtn) {
    checkoutBtn.style.display = "block";
  }
}

// Helper function to show messages to the user
function showMessage(message, type = "success") {
  const alertDiv = document.createElement("div");
  alertDiv.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
  alertDiv.style.zIndex = "9999";
  alertDiv.innerHTML = message;
  document.body.appendChild(alertDiv);

  // Remove existing alerts
  setTimeout(() => {
    alertDiv.classList.add("fade");
    setTimeout(() => alertDiv.remove(), 300);
  }, 3000);
}

// Quantity update feature for cart
document.querySelectorAll(".quantity-right-plus").forEach((button) => {
  button.addEventListener("click", function (e) {
    e.preventDefault();
    const inputGroup = this.closest(".input-group");
    const qtyInput = inputGroup.querySelector(".input-number");
    let currentVal = parseInt(qtyInput.value) || 1;
    qtyInput.value = currentVal + 1;
    updateQuantity(qtyInput);
  });
});

document.querySelectorAll(".quantity-left-minus").forEach((button) => {
  button.addEventListener("click", function (e) {
    e.preventDefault();
    const inputGroup = this.closest(".input-group");
    const qtyInput = inputGroup.querySelector(".input-number");
    let currentVal = parseInt(qtyInput.value) || 1;
    if (currentVal > 1) {
      qtyInput.value = currentVal - 1;
      updateQuantity(qtyInput);
    } else {
      showMessage("Quantity cannot be less than 1", "error");
    }
  });
});

function updateQuantity(qtyInput) {
  const newQty = qtyInput.value;
  // Extract book id from input field id, e.g. quantity_123 => 123
  const bookId = qtyInput.getAttribute("id").split("_")[1];

  fetch(`${SITE_ROOT}/cart/updateQuantity`, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `book_id=${bookId}&quantity=${newQty}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        // Update cart totals and counts using your existing functions
        updateCartTotal(data.cart_total);
        updateCartCount(data.cart_count);
        showMessage("Cart updated successfully", "success");
      } else {
        throw new Error(data.message || "Error updating quantity");
      }
    })
    .catch((error) => {
      console.error("Error updating cart quantity:", error);
      showMessage(error.message, "error");
    });
}
