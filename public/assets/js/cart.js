document.addEventListener("DOMContentLoaded", function () {
  // Add to cart button click handlers
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

  // Remove from cart functionality
  document.querySelectorAll(".remove-item").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const url = this.getAttribute("data-url");
      const itemContainer = this.closest(".list-group-item");

      fetch(url)
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Update cart display
            itemContainer.remove();

            // Update cart count
            const cartCountElements = document.querySelectorAll(".cart span");
            cartCountElements.forEach((el) => {
              el.textContent = `(${data.cart_count})`;
            });

            // Update cart total
            const cartTotalElement = document.getElementById("cart-total");
            if (cartTotalElement) {
              cartTotalElement.textContent = `$${parseFloat(
                data.cart_total
              ).toFixed(2)}`;
            }

            // If cart is empty, show empty message
            const cartItems = document.querySelectorAll(".list-group-item");
            if (cartItems.length === 0) {
              const cartList = document.querySelector(".list-group");
              if (cartList) {
                cartList.innerHTML =
                  '<li class="list-group-item bg-transparent text-center">Your cart is empty</li>';
              }
            }
          } else {
            console.error("Error removing item:", data.message);
            alert("Failed to remove item from cart");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while removing the item");
        });
    });
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
    updateCartDropdown(data.cart_items);
    updateCartCount(data.cart_count);
    updateCartTotal(data.cart_total);
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

function updateCartCount(count) {
  document
    .querySelectorAll(".cart-count, .cart-dropdown .fs-6.fw-light")
    .forEach((element) => {
      element.textContent = element.classList.contains("fs-6")
        ? `(${count})`
        : count;
    });
}

function updateCartDropdown(cartItems) {
  const cartList = document.querySelector(".cart-dropdown .list-group");
  if (!cartList) return;

  if (!cartItems || cartItems.length === 0) {
    cartList.innerHTML = `
              <li class="list-group-item bg-transparent text-center">
                  Your cart is empty
              </li>
          `;
    return;
  }

  let html = "";
  let total = 0;

  cartItems.forEach((item) => {
    total += item.Price * item.Quantity;
    html += `
              <li class="list-group-item bg-transparent d-flex justify-content-between lh-sm">
                  <div>
                      <h5>
                          <a href="${SITE_ROOT}/singleproduct/${
      item.BookID
    }">${escapeHtml(item.Title)}</a>
                      </h5>
                      <small>Quantity: ${
                        item.Quantity
                      } × $${item.Price.toFixed(2)}</small>
                  </div>
                  <span class="text-primary">$${(
                    item.Price * item.Quantity
                  ).toFixed(2)}</span>
                  <button class="btn btn-danger btn-sm remove-item" 
                          data-book-id="${item.BookID}">
                      <i class="bi bi-trash"></i>
                  </button>
              </li>
          `;
  });

  html += `
          <li class="list-group-item bg-transparent d-flex justify-content-between">
              <span class="text-capitalize"><b>Total (USD)</b></span>
              <strong>$${total.toFixed(2)}</strong>
          </li>
      `;

  cartList.innerHTML = html;

  // Update checkout button visibility
  const checkoutBtn = document.querySelector(".cart-dropdown .btn-primary");
  if (checkoutBtn) {
    checkoutBtn.style.display = cartItems.length > 0 ? "block" : "none";
  }
}

function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

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
