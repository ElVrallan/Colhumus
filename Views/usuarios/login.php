<link rel="stylesheet" href=".\Assets\Css\login.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Iniciar sesión</h2>
            <form method="POST" action="?action=login">
                <div class="input-group">
                    <label>Correo:</label>
                    <input type="email" name="correo" required>
                </div>

                <div class="input-group">
                    <label>Contraseña:</label>
                    <input type="password" name="contraseña" required>
                </div>

                <button type="submit" class="btn-submit">Iniciar sesión</button>
            </form>

            <p class="registrarse">
                <a href="?action=registrarse">Registrarse</a> |
                <a href="?action=olvideContraseña">¿Olvidaste tu contraseña?</a>
            </p>
        </div>
        <p class="footer">&copy; 2025 Colhumus. Todos los derechos reservados.</p>
    </div>
</body>

</html>