<link rel="stylesheet" href=".\Assets\Css\login.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Reestablecer contraseña</h2>
            <form method="POST" action="?action=reestablecerContraseña">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

                <div class="input-group">
                    <label>Nueva contraseña:</label>
                    <input type="password" name="contraseña" required>
                </div>

                <button type="submit" class="btn-submit">Reestablecer</button>
            </form>

            <p class="registrarse">
                <a href="?action=iniciarSesion">Volver al inicio de sesión</a>
            </p>
        </div>
    </div>
</body>
</html>
