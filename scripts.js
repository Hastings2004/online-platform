// Function to validate the registration form
function validateRegistrationForm() {
    let name = document.forms["registrationForm"]["name"].value;
    let email = document.forms["registrationForm"]["email"].value;
    let password = document.forms["registrationForm"]["password"].value;
    let confirmPassword = document.forms["registrationForm"]["confirm_password"].value;

    if (name == "") {
        alert("Name must be filled out");
        return false;
    }
    if (email == "") {
        alert("Email must be filled out");
        return false;
    }
    if (password == "") {
        alert("Password must be filled out");
        return false;
    }
    if (confirmPassword == "") {
        alert("Please confirm your password");
        return false;
    }
    if (password != confirmPassword) {
        alert("Passwords do not match");
        return false;
    }
    return true;
}

// Function to validate the login form
function validateLoginForm() {
    let email = document.forms["loginForm"]["email"].value;
    let password = document.forms["loginForm"]["password"].value;

    if (email == "") {
        alert("Email must be filled out");
        return false;
    }
    if (password == "") {
        alert("Password must be filled out");
        return false;
    }
    return true;
}

// Function to handle add to cart action using AJAX
function addToCart(productId, quantity) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Product added to cart successfully");
            // You can also update the cart icon or count here
        }
    };
    xhr.send("action=add&product_id=" + productId + "&quantity=" + quantity);
}

// Function to handle remove from cart action using AJAX
function removeFromCart(productId) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Product removed from cart successfully");
            // You can also update the cart display here
        }
    };
    xhr.send("action=remove&product_id=" + productId);
}

// Function to handle checkout action using AJAX
function checkout() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Checkout successful");
            // You can also redirect to an order confirmation page here
        }
    };
    xhr.send("action=checkout");
}

// Add event listeners for form validation
document.getElementById("registrationForm").onsubmit = function() {
    return validateRegistrationForm();
};

document.getElementById("loginForm").onsubmit = function() {
    return validateLoginForm();
};

// Example usage of addToCart, removeFromCart, and checkout functions
// Assuming you have buttons with specific IDs for these actions
document.getElementById("addToCartButton").onclick = function() {
    let productId = this.dataset.productId;
    let quantity = document.getElementById("quantityInput").value;
    addToCart(productId, quantity);
};

document.getElementById("removeFromCartButton").onclick = function() {
    let productId = this.dataset.productId;
    removeFromCart(productId);
};

document.getElementById("checkoutButton").onclick = function() {
    checkout();
};
function addToCart(productId, quantity) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Product added to cart successfully");
            // Update cart icon or count here
        }
    };
    xhr.send("action=add&product_id=" + productId + "&quantity=" + quantity);
}
function removeFromCart(productId) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Product removed from cart successfully");
            // Update cart display here
        }
    };
    xhr.send("action=remove&product_id=" + productId);
}
function checkout() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Checkout successful");
            // Redirect to order confirmation page here
        }
    };
    xhr.send("action=checkout");
}
document.getElementById("registrationForm").onsubmit = function() {
    return validateRegistrationForm();
};

document.getElementById("loginForm").onsubmit = function() {
    return validateLoginForm();
};

document.getElementById("addToCartButton").onclick = function() {
    let productId = this.dataset.productId;
    let quantity = document.getElementById("quantityInput").value;
    addToCart(productId, quantity);
};

document.getElementById("removeFromCartButton").onclick = function() {
    let productId = this.dataset.productId;
    removeFromCart(productId);
};

document.getElementById("checkoutButton").onclick = function() {
    checkout();
};
function addToCart(productId, quantity) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Product added to cart successfully");
        }
    };
    xhr.send("action=add&product_id=" + productId + "&quantity=" + quantity);
}

function removeFromCart(productId) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Product removed from cart successfully");
        }
    };
    xhr.send("action=remove&product_id=" + productId);
}

function checkout() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Checkout successful");
        }
    };
    xhr.send("action=checkout");
}
