<?php
$currentAction = $action ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Colhumus</title>
    <link rel="icon" type="image/x-icon" href="./Assets/Images/Colhumus%20icono.ico">
    <link rel="stylesheet" href="./Assets/Css/navbarStyle.css">
    <link rel="stylesheet" href="./Assets/Css/scrollbarStyle.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="action" value="dashboard">
                <div class="nav-logo">
                    <button type="submit"></button>
                    <img src="./Assets/Images/Colhumus logo text.png" alt="Logo">
                </div>
            </form>

            <div class="divider">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="40" viewBox="0 0 10 40">
                    <rect width="10" height="40" rx="5" fill="#468704" />
                </svg>
            </div>

            <div class="nav-items">
                <form action="index.php" method="GET" class="nav-form">
                    <input type="hidden" name="action" value="dashboard">
                    <div class="nav-item <?= $currentAction === 'dashboard' ? 'active' : '' ?>">
                        <span>Inicio</span>
                        <button type="submit"></button>
                    </div>
                </form>

                <div class="divider">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="40" viewBox="0 0 10 40">
                        <rect width="10" height="40" rx="5" fill="#468704" />
                    </svg>
                </div>

                <form action="index.php" method="GET" class="nav-form">
                    <input type="hidden" name="action" value="acercaDe">
                    <div class="nav-item <?= $currentAction === 'acercaDe' ? 'active' : '' ?>">
                        <span>¿Acerca de?</span>
                        <button type="submit"></button>
                    </div>
                </form>

                <div class="divider">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="40" viewBox="0 0 10 40">
                        <rect width="10" height="40" rx="5" fill="#468704" />
                    </svg>
                </div>

                <a class="nav-item contacto <?= $currentAction === 'contacto' ? 'active' : '' ?>" href="https://web.whatsapp.com/send/?phone=573155829805&text&type=phone_number&app_absent=0" target="_blank">
                    <span class="icon-contacto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="28" fill="currentColor"
                            viewBox="0 -2 16 16">
                            <path fill-rule="evenodd"
                                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708" />
                        </svg>
                    </span>
                    <span>Contacto</span>
                </a>

                <div class="divider">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="40" viewBox="0 0 10 40">
                        <rect width="10" height="40" rx="5" fill="#468704" />
                    </svg>
                </div>

                <div class="nav-item iniciar-sesion <?= $currentAction === 'iniciarSesion' ? 'active' : '' ?>">
                    <span class="icon-iniciar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="28" fill="currentColor" class="bi bi-person-walking" viewBox="0 -2 16 16">
                            <path d="M9.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M6.44 3.752A.75.75 0 0 1 7 3.5h1.445c.742 0 1.32.643 1.243 1.38l-.43 4.083a1.8 1.8 0 0 1-.088.395l-.318.906.213.242a.8.8 0 0 1 .114.175l2 4.25a.75.75 0 1 1-1.357.638l-1.956-4.154-1.68-1.921A.75.75 0 0 1 6 8.96l.138-2.613-.435.489-.464 2.786a.75.75 0 1 1-1.48-.246l.5-3a.75.75 0 0 1 .18-.375l2-2.25Z" />
                            <path d="M6.25 11.745v-1.418l1.204 1.375.261.524a.8.8 0 0 1-.12.231l-2.5 3.25a.75.75 0 1 1-1.19-.914zm4.22-4.215-.494-.494.205-1.843.006-.067 1.124 1.124h1.44a.75.75 0 0 1 0 1.5H11a.75.75 0 0 1-.531-.22Z" />
                        </svg>
                    </span>
                    <form action="index.php" method="GET">
                        <input type="hidden" name="action" value="iniciarSesion">
                        <div class="iniciar-text">
                            <span>Iniciar</span>
                            <span>Sesión</span>
                        </div>
                        <button type="submit"></button>
                    </form>
                </div>

                <div class="divider">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="40" viewBox="0 0 10 40">
                        <rect width="10" height="40" rx="5" fill="#468704" />
                    </svg>
                </div>
                <div class="search-section">
                    <form action="index.php" method="GET" class="search-form">
                        <input type="hidden" name="action" value="searchNoticias">
                        <input type="text" name="query" class="search-bar" placeholder="Buscar noticias...">
                        <button class="search-button" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018" />
                                <path
                                    d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</body>

</html>