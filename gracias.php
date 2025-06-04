<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        body {
            background-color: #f8f9fa;
        }
        .text-success-custom {
            color: black; 
        }
    </style>
</head>
<body>
    <div class="container text-center mt-5 fade-in">
        <h1 class="text-success-custom">¡Gracias por contactarnos!</h1>
        <p class="lead">Hemos recibido tu mensaje y nos pondremos en contacto contigo lo antes posible.</p>
        <a href="index.php" class="btn btn-warning mt-3">Volver a Inicio</a>
    </div>
</body>
</html>