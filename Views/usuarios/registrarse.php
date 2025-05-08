<link rel="stylesheet" href=".\Assets\Css\login.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Registrarse</h2>
            <form method="POST" action="?action=registrarse">
                <div class="input-group">
                    <label>Nombre de usuario:</label>
                    <input type="text" name="nombre_usuario" required>
                </div>

                <div class="input-group">
                    <label>Correo:</label>
                    <input type="email" name="correo" required>
                </div>

                <div class="input-group">
                    <label>Contraseña:</label>
                    <input type="password" name="contraseña" required>
                </div>

                <button type="submit" class="btn-submit">Registrarse</button>
            </form>

            <p class="registrarse">
                <a href="?action=iniciarSesion">¿Ya tienes cuenta? Inicia sesión</a>
            </p>
        </div>
    </div>
</body>
</html>
