<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Proyecto - CodeIgniter + Vue</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; }
        #app { max-width: 800px; margin: 50px auto; padding: 20px; }
        .card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 10px; }
        .status { color: #4caf50; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; }
        button { background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div id="app">
        <div class="card">
            <h1>CodeIgniter + Vue.js</h1>
            <p>Estado: <span class="status">{{ estado }}</span></p>
            <p>{{ mensaje }}</p>
        </div>
        
        <div class="card">
            <h2>Usuarios</h2>
            <button @click="cargarUsuarios">Cargar Usuarios</button>
            <table v-if="usuarios.length">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in usuarios" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.nombre }}</td>
                        <td>{{ user.email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const { createApp } = Vue;
        
        createApp({
            data() {
                return {
                    estado: 'Conectando...',
                    mensaje: '',
                    usuarios: []
                }
            },
            mounted() {
                this.verificarConexion();
            },
            methods: {
                verificarConexion() {
                    axios.get('/mi-proyecto/index.php/api')
                        .then(response => {
                            this.estado = response.data.status;
                            this.mensaje = response.data.message;
                        })
                        .catch(error => {
                            this.estado = 'Error';
                            this.mensaje = 'No se pudo conectar con la API';
                            console.error(error);
                        });
                },
                cargarUsuarios() {
                    axios.get('/mi-proyecto/index.php/api/usuarios')
                        .then(response => {
                            this.usuarios = response.data.data;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }
        }).mount('#app');
    </script>
</body>
</html>
