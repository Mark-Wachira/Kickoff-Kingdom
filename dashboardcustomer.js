// Function to add items to the cart
function addToCart(productName, price) {
    // Create a new cart item object
    var item = {
        name: productName,
        price: price
    };

    // Retrieve the cart items from localStorage or initialize an empty array
    var cartItems = JSON.parse(localStorage.getItem('cart')) || [];

    // Add the new item to the cart
    cartItems.push(item);

    // Store the updated cart items back into localStorage
    localStorage.setItem('cart', JSON.stringify(cartItems));

    // Refresh the cart display
    displayCart();
}

// Function to display the cart
function displayCart() {
    // Retrieve cart items from localStorage
    var cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    var cartList = document.getElementById('cart-items');
    var total = 0;

    // Clear the existing cart items
    cartList.innerHTML = '';

    // Iterate through each item in the cart
    cartItems.forEach(function(item) {
        var listItem = document.createElement('li');
        listItem.textContent = item.name + ' - $' + item.price;
        cartList.appendChild(listItem);

        // Update total price
        total += parseFloat(item.price);
    });

    // Display the total price
    document.getElementById('total').textContent = total.toFixed(2);
}

// Function to handle the checkout process
function checkout() {
    // Clear the cart items from localStorage
    localStorage.removeItem('cart');

    // Display a confirmation message
    alert('Thank you for your purchase!');

    // Refresh the cart display
    displayCart();
}

// Display the cart initially when the page loads
displayCart();
