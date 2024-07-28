import React from 'react';
import './Producto.css'; // Importar el archivo CSS para los estilos

function Producto({ producto ,handleAddToCart }) {
    return (
        <div className="product-card">
            <img src={producto.image} alt={producto.Name} />
            <h2>{producto.Name}</h2>
            <p>{producto.Description}</p>
            <div className="product-details">
                <p>Precio: ${producto.Price}</p>
                <p>Stock: {producto.stock}</p>
                <button onClick={() => handleAddToCart(producto.id)}>Añadir al carrito</button>
            </div>
        </div>
    );
}

export default Producto;