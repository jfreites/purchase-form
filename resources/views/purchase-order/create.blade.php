<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="This is a checkout page for demo purpose based on a Bootstrap 5 checkout page">
    <meta name="author" content="Jonathan Freites">
    <title>Bamba = Demo</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
  </head>
  <body class="bg-light">
    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="/images/logo.svg" alt="Bamba logo" width="132" height="24">
      <h2>Creación de orden de compra</h2>
      <p class="lead">Selecciona un producto de la lista y la cantidad que deseas (máximo 10) para que se agregue al carrito, una vez tengas todos los productos que deseas presiona "Confirmar compra" para completar el proceso.</p>
    </div>

    <div class="row g-5">

      @if(session()->has('success'))
      <div id="userMessage" class="alert alert-success alert-dismissible fade show" role="alert">
          <span>{{ session('success') }}</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Tu carrito</span>
          <span id="productCounter" class="badge bg-primary rounded-pill">0</span>
        </h4>

        <ul id="orderItems" class="list-group mb-3">
        </ul>

        <form id="cartForm" action="{{ route('purchase-order.store') }}" method="POST" class="card p-2">
          <button class="w-100 btn btn-primary btn-lg" type="submit" onclick="submitOrder(event)">Confirmar orden</button>
        </form>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Selecciona un producto</h4>
        <form novalidate>
            <div class="row g-3">
                <div class="col-md-5">
                <label for="product_sku" class="form-label">SKU</label>
                <select class="form-select" name="product_sku" id="product_sku" required>
                    <option value="">Elegir...</option>
                    @foreach ($products as $product)
                        <option data-price="{{ $product->price }}" value="{{ $product->sku }}">{{ $product->sku }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select a valid product.
                </div>
                </div>

                <div class="col-md-4">
                <label for="state" class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="quantity" id="quantity" min="1" max="10" required>
                <div class="invalid-feedback">
                    Please provide a quantity for this product.
                </div>
                </div>

                <div class="col-md-3">
                    <span onclick="addOrderItem()" class="btn btn-secondary" style="margin: 15px auto;">Agregar</span>
                </div>
            </div>
        </form>
      </div>
    </div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2022 Creación de orden de compra</p>
  </footer>
</div>

            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        // Create a "close" button and append it to each list item
        var myNodelist = document.getElementsByTagName("LI");
        var i;
        for (i = 0; i < myNodelist.length; i++) {
            let span = document.createElement("SPAN");
            let txt = document.createTextNode("\u00D7");
            span.className = "close";
            span.appendChild(txt);
            myNodelist[i].appendChild(span);
        }

        // Click on a close button to hide the current list item
        var close = document.getElementsByClassName("close");
        var i;
        for (i = 0; i < close.length; i++) {
            close[i].onclick = function() {
                let div = this.parentElement;
                div.style.display = "none";
            }
        }

        // Global array list with the cart items..
        var cartListItems = [];

        // Add an element to the cart list
        function addOrderItem() {
            let li = document.createElement("li");
            li.classList.add("list-group-item","d-flex","justify-content-between","lh-sm");

            let productSelect = document.getElementById("product_sku");
            let inputSKU = productSelect.options[productSelect.selectedIndex].value;
            let inputQTY = document.getElementById("quantity").value;
            let productPrice = productSelect.options[productSelect.selectedIndex].dataset.price;

            // TODO: if the same product is added twice, the quantity should be increased

            let textNode = document.createTextNode(inputSKU + " [x " + inputQTY + "] - $" + productPrice);

            li.appendChild(textNode);
            
            if ('' === inputSKU) {
                alert("You must select a product!");
            } else {
                document.getElementById("orderItems").appendChild(li);
            }

            document.getElementById("product_sku").value = "";

            let span = document.createElement("SPAN");
            let txt = document.createTextNode("\u00D7");
            
            span.className = "close";
            span.appendChild(txt);
            li.appendChild(span);

            //let productCounter = document.getElementById("productCounter");
            //productCounter.appendChild(document.getElementById("orderItems").childNodes.length);

            let cartListItem = { 'sku': inputSKU, 'qty': inputQTY };
            cartListItems.push(cartListItem);

            for (i = 0; i < close.length; i++) {
                close[i].onclick = function() {
                    let div = this.parentElement;
                    div.style.display = "none";
                }
            }
        }

        // Clear the things up
        function clearCart() {
          cartListItems = [];
          let ul = document.getElementById("orderItems");
          let child = ul.lastElementChild;
          while (child) {
            ul.removeChild(child);
            child = ul.lastElementChild;
          }
        }

        // Handler for the form submission
        function submitOrder(event) {
          event.preventDefault();

          postPurchaseOrder(JSON.stringify(cartListItems));
        } 
        
        // Ajax request to the backend
        function postPurchaseOrder(postData) {
          const xmlhttp = new XMLHttpRequest();

          let csrfToken = "{{ csrf_token() }}";

          xmlhttp.open("POST", "/purchase-order/create");
          xmlhttp.setRequestHeader("x-csrf-token", csrfToken);    
          xmlhttp.setRequestHeader("Accept", "application/json");
          xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

          xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log("We got a response : " + xmlhttp.response);
                window.location.reload();
            } else if (xmlhttp.status == 0) {
                console.log("Something went wrong");
            }
          };

          xmlhttp.send(postData);
        }
    </script>
  </body>
</html>