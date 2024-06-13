
// document.addEventListener('DOMContentLoaded', function(){

    
//     const el = document.querySelector('#product-filter')
//     console.log({el})


// el.addEventListener('change', function() {
//     const selectedCategory = this.value;
//     filterProducts(selectedCategory);
// });


// function filterProducts(category) {
//     const productList = document.querySelector('.container .row');
//     productList.innerHTML = ''; 
    
//     fetch(`../backend/get_products.php?category=${category}`)
//         .then(response => response.json())
//         .then(products => {
//             products.forEach(product => {  
//                 productList.innerHTML += `
//                     <div class="col mb-5" style="width:280px; height: 515px;">
//                         <div class="card h-100" style="width:280px; height: 515px;">
//                             <!-- Product image-->
//                             <img class="card-img-top" src="../${product.image}" alt="${product.name}" style="width:270px; height: 250px;" />
//                             <!-- Product details-->
//                             <div class="card-body p-4">
//                                 <div class="text-center">
//                                     <!-- Product name-->
//                                     <h5 class="fw-bolder">${product.name}</h5>
//                                     <!-- Product price-->
//                                     ${product.price}
//                                 </div>
//                             </div>
//                             <!-- Product actions-->
//                             <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
//                                 <div class="text-center">
//                                     <a class="btn btn-outline-dark mt-auto add-to-cart" href="#" data-product-id="${product.product_id}">Add to cart</a>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 `;
//             });

//             // Add event listeners for the "Add to cart" buttons
//             document.querySelectorAll('.add-to-cart').forEach(button => {
//                 button.addEventListener('click', function(event) {
//                     event.preventDefault();
//                     const productId = this.getAttribute('data-product-id');
//                     addToCart(productId);
//                 });
//             });
//         })
//         .catch(error => {
//             console.error('Error fetching products:', error);
//         });
// }

// function addToCart(productId) {
//     // Get the JWT token from local storage
//     const token = localStorage.getItem('user');
    
//     fetch('../backend/add-to-cart', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'Authentication': `${token}`
//         },
//         body: JSON.stringify({ product_id: productId, quantity: 1 })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.error) {
//             console.error('Error adding to cart:', data.error);
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: 'There was an error adding the product to your cart.'
//             });
//         } else {
//             console.log('Product added to cart:', data);
//             Swal.fire({
//                 icon: 'success',
//                 title: 'Added to Cart',
//                 text: 'The product has been added to your cart!'
//             });
//             // Optionally, update the UI to reflect the added item
//         }
//     })
//     .catch(error => {
//         console.error('Error adding to cart:', error);
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'There was an error adding the product to your cart.'
//         });
//     });
// }

// })




