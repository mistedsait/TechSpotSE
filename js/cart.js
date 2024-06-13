document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('user');

    fetch(Constants.get_api_base_url()+'cart', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authentication': `${token}`
        }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('cart-items-container');
        const itemCount = document.getElementById('item-count');
        const subtotalElement = document.getElementById('subtotal');
        const totalElement = document.getElementById('total');
        const totalAmountElement = document.getElementById('total-amount');
        
        let subtotal = 0;

        container.innerHTML = '';
        data.forEach(item => {
            const itemTotal = item.product_price * item.quantity;
            subtotal += itemTotal;

            const cartItem = `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                                <div>
                                    <img src="${item.product_image}" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                </div>
                                <div class="ms-3">
                                    <h5>${item.product_name}</h5>
                                    <p class="small mb-0">${item.product_description}</p>
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <div style="width: 50px;">
                                    <h5 class="fw-normal mb-0">${item.quantity}</h5>
                                </div>
                                <div style="width: 80px;">
                                    <h5 class="mb-0">$${item.product_price}</h5>
                                </div>
                                <a href="#!" class="delete-item" data-id="${item.cart_item_id}" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', cartItem);
        });

        const shipping = 20;
        const total = subtotal + shipping;

        itemCount.textContent = `You have ${data.length} items in your cart`;
        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
        totalElement.textContent = `$${total.toFixed(2)}`;
        totalAmountElement.textContent = `$${total.toFixed(2)}`;

        document.querySelectorAll('.delete-item').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const cartItemId = this.getAttribute('data-id');
                fetch(Constants.get_api_base_url()+'cart-delete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authentication': `${token}`
                    },
                    body: JSON.stringify({ cart_item_id: cartItemId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Item removed successfully') {
                        // Refresh cart or update the UI
                        this.closest('.card').remove();
                        // Update subtotal and total after item removal
                        subtotal -= parseFloat(this.closest('.card').querySelector('.mb-0').textContent.replace('$', '')) * parseInt(this.closest('.card').querySelector('.fw-normal').textContent);
                        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
                        totalElement.textContent = `$${(subtotal + shipping).toFixed(2)}`;
                        totalAmountElement.textContent = `$${(subtotal + shipping).toFixed(2)}`;
                        itemCount.textContent = `You have ${document.querySelectorAll('.card').length} items in your cart`;
                    } else {
                        console.error('Error removing item:', data.error);
                    }
                })
                .catch(error => console.error('Error removing item:', error));
            });
        });
    })
    .catch(error => console.error('Error fetching cart items:', error));
});
