<link rel="stylesheet" href=".\Assets\Css\login.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Recuperar contraseña</h2>
            <form method="POST" action="?action=enviarEmail">
                <div class="input-group">
                    <label>Correo:</label>
                    <input type="email" name="correo" required>
                </div>

                <button type="submit" class="btn-submit">Enviar enlace</button>
            </form>

            <p class="registrarse">
                <a href="?action=iniciarSesion">Volver al inicio de sesión</a>
            </p>
        </div>
    </div>
</body>
</html>
