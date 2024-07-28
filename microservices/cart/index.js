const express = require('express');
const cors = require('cors');
const axios = require('axios');

const app = express();
const port = 3001;

try {
    app.use(cors({
        origin: 'http://localhost:3000' // O especifica tu origen permitido
    }));
} catch (error) {
    console.error('Error al configurar CORS:', error);
}

app.post('/api/add/cart', async (req, res) => {
    const { productId } = req.body;

    if (!productId) {
        return res.status(400).json({ message: 'Falta el producto (productId) en la solicitud' });
    }

    try {
        const apiUrl = 'http://localhost:58000/api/cart/add';
        const response = await axios.post(apiUrl, { productId });

        if (response.status === 200) {
            // Producto añadido correctamente
            res.json({ message: 'Producto añadido al carrito' });
        } else {
            // Error al añadir el producto
            res.status(500).json({ message: 'Error al añadir el producto al carrito' });
        }
    } catch (error) {
        console.error('Error al comunicarse con la API Symfony:', error);
        res.status(500).json({ message: 'Error interno del servidor' });
    }
});

app.listen(port, () => {
    console.log(`Microservicio de carrito escuchando en el puerto ${port}`);
});