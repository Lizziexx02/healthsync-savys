// Function to toggle step description visibility
function toggleStep(step) {
    const stepContent = document.getElementById(`step-${step}`);
    if (stepContent.style.display === 'none' || stepContent.style.display === '') {
        stepContent.style.display = 'block';
    } else {
        stepContent.style.display = 'none';
    }
}

function toggleStep(stepNumber) {
    const stepContent = document.getElementById('step-' + stepNumber);
    
    if (stepContent.style.display === "none" || stepContent.style.display === "") {
        stepContent.style.display = "block";
    } else {
        stepContent.style.display = "none";
    }
}



/* ==================================
    HOW IT WORKS - Trigger Step Info 
   ================================== */
function toggleStep(stepNumber) {
    const stepContent = document.getElementById('step-' + stepNumber);
            
    if (stepContent.style.display === "none" || stepContent.style.display === "") {
        stepContent.style.display = "block";
    } else {
        stepContent.style.display = "none";
    }
}



/* ==============================
    MY ACCOUNT - Edit Name Modal 
   ==============================*/
// Get modal and button for name edit
var nameModal = document.getElementById("editNameModal");
var nameBtn = document.getElementById("editNameBtn");
var nameSpan = document.getElementById("closeNameModal");

// Open the modal when the user clicks the "Edit Name" button
nameBtn.onclick = function() {
    nameModal.style.display = "block";
}

// Close the modal when the user clicks the "x"
nameSpan.onclick = function() {
    nameModal.style.display = "none";
}

// Get modal and button for email edit
var emailModal = document.getElementById("editEmailModal");
var emailBtn = document.getElementById("editEmailBtn");
var emailSpan = document.getElementById("closeEmailModal");

// Open the modal when the user clicks the "Edit Email" button
emailBtn.onclick = function() {
    emailModal.style.display = "block";
}

// Close the modal when the user clicks the "x"
emailSpan.onclick = function() {
    emailModal.style.display = "none";
}

// Close the modal if the user clicks anywhere outside the modal
window.onclick = function(event) {
    if (event.target == nameModal) {
        nameModal.style.display = "none";
    }
    if (event.target == emailModal) {
        emailModal.style.display = "none";
    }
}



// Enable/Disable checkout button based on checkbox status
document.getElementById('terms').addEventListener('change', function() {
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (this.checked) {
        checkoutBtn.disabled = false; // Enable button when checkbox is checked
    } else {
        checkoutBtn.disabled = true;  // Disable button when checkbox is unchecked
    }
});




function updateQuantity(prod_id, change) {
    const input = document.querySelector('.cart-item[data-prod-id="' + prod_id + '"] .quantity-control input');
    let quantity = parseInt(input.value);
    quantity += change;
    if (quantity < 1) return; // Prevent going below 1

    // Update the cart in the session (this could be done via AJAX or page reload)
    input.value = quantity;

    // Update session storage/cart
    window.location.href = "update-cart.php?prod_id=" + prod_id + "&quantity=" + quantity; // Redirect to update the cart
}