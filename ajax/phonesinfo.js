document.getElementById('product-filter').addEventListener('change', function() {
    const selectedCategory = this.value;
    filterProducts(selectedCategory);
});

function filterProducts(category) {
    const productList = document.querySelector('.container .row');
    productList.innerHTML = ''; 
    
 
    fetch(`../backend/get_products.php?category=${category}`)
        .then(response => response.json())
        .then(products => {
            products.forEach(product => {  
                productList.innerHTML += `
                    <div class="col mb-5" style="width:280px; height: 515px;">
                        <div class="card h-100" style="width:280px; height: 515px;">
                            <!-- Product image-->
                            <img class="card-img-top" src="../${product.image}" alt="${product.name}" style="width:270px; height: 250px;" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">${product.name}</h5>
                                    <!-- Product price-->
                                    ${product.price}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
}

