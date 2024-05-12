document.addEventListener('DOMContentLoaded', function () {
  const asideElement = document.querySelector('.row aside');
  let data;

  function loadImages() {
    fetch("../data/product.json")
      .then(response => response.json())
      .then(fetchedData => {
        data = fetchedData;
        let imageItems = ''; // Variable to store HTML content
        const products = data.product;
        if (Array.isArray(products)) {
          products.map(product => {
            imageItems += `
              <div class="border rounded-4 mb-3 d-flex justify-content-center">
                <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big.webp">
                  <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="${product.image}" style="width: 300px; height: 600px;"/>
                </a>
              </div>
              <div class="d-flex justify-content-center mb-3">
                <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big1.webp" class="item-thumb">
                  <img width="60" height="60" class="rounded-2" src="${product.image2}" />
                </a>
                <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big2.webp" class="item-thumb">
                  <img width="60" height="60" class="rounded-2" src="${product.image3}" />
                </a>
                <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big3.webp" class="item-thumb">
                  <img width="60" height="60" class="rounded-2" src="${product.image4}" />
                </a>
              </div>
            `;
          });
          asideElement.innerHTML += imageItems; // Append the HTML content
        } else {
          console.error('The "product" property is not an array or is undefined in the JSON data.');
        }
      })
      .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
  }

  loadImages();
});