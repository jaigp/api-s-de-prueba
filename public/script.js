/**
* URL de la API para interactuar con los productos.
* @constant {string}
*/
const URL_API = "http://localhost/api-productos/API/";
/**
* FunciÃ³n principal que se ejecuta cuando el DOM estÃ¡ completamente cargado.
* Configura los manejadores de eventos para cargar, aÃ±adir, actualizar y
eliminar productos.
*/
document.addEventListener('DOMContentLoaded', () => {
/**
* Maneja el evento de clic en el botÃ³n de carga de productos.
* Recupera la lista de productos desde la API y la muestra en la interfaz.
*/
const loadProductsButton = document.getElementById('load-products');
if (loadProductsButton) {
    loadProductsButton.addEventListener('click', () => {
    fetch(URL_API)
    .then(response => response.json())
    .then(data => {
        const productList = document.getElementById('product-list');
        if (productList) {
            productList.innerHTML = '';
            data.forEach(product => {
                const li = document.createElement('li');
                li.textContent = `ID: ${product.id} - Nombre: ${product.nombre} - Precio: ${product.precio} - DescripciÃ³n: ${product.descripcion}`;
                productList.appendChild(li);
            });
        }
})
    .catch(error => console.error('Error:', error));
});
} else {
}
/**
* Maneja el evento de envÃo del formulario para aÃ±adir un nuevo producto.
* EnvÃa los datos del producto a la API y recarga la lista de productos en
caso de Ã©xito.
* @param {Event} event - El evento de envÃo del formulario.
*/
document.getElementById('add-product-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const precio = document.getElementById('precio').value;
    const descripcion = document.getElementById('descripcion').value;
    fetch(URL_API, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            nombre: nombre,
            precio: precio,
            descripcion: descripcion
        })
})
.then(response => response.json())
.then(data => {
    console.log('Producto aÃ±adido:', data);
    // Opcional: Recargar la lista de productos
    document.getElementById('load-products').click();
})
.catch(error => console.error('Error:', error));
    console.error('Elemento con ID "load-products" no encontrado.');
})})