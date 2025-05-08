<style>
body {
    background-color: #ffffff;
    color: black;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    width: 100%;
    max-width: 400px;
    margin: auto;
    padding: 20px;
    margin-top: 50px;
}

.login-box {
    background-color: #A9E159;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.login-box h2 {
    text-align: center;
    margin-bottom: 20px;
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    font-weight: bold;
}

.input-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-submit {
    background-color: #72CB10;
    color: white;
    padding: 10px 15px;
    width: 100%;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-submit:hover {
    background-color: #5ab507;
}

.registrarse {
    text-align: center;
    display: block;
    margin-top: 10px;
    color: #007BFF;
    text-decoration: none;
}

.footer {
    text-align: center;
    margin-top: 20px;
    color: gray;
}
</style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Iniciar sesión</h2>
            <form method="POST" action="?action=login">
                <label>Correo:</label>
                <input type="email" name="correo" required><br>

                <label>Contraseña:</label>
                <input type="password" name="contraseña" required><br>

                <button type="submit">Iniciar sesión</button>
            </form>

            <p><a href="?action=registrarse">Registrarse</a> |
                <a href="?action=olvideContraseña">¿Olvidaste tu contraseña?</a>
            </p>

        </div>
        <p class="footer">&copy; 2025 Colhumus. Todos los derechos reservados.</p>
    </div>
</body>

</html>