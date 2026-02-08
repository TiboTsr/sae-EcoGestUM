<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #273572 0%, #2d3768 100%);
            padding: 20px;
        }
        .error-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #d13434;
            margin-bottom: 20px;
            line-height: 1;
        }
        .error-title {
            font-size: 32px;
            color: #333;
            margin-bottom: 15px;
        }
        .error-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-primary {
            background: #d13434;
            color: white;
        }
        .btn-primary:hover {
            background: #b82e2e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(209, 52, 52, 0.4);
        }
        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }
        .btn-secondary:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-title">Page non trouvée</div>
        <div class="error-message">
            La page que vous cherchez n'existe pas ou a été déplacée.
        </div>
        <div class="error-actions">
            <a href="index.php?page=tableaudebord" class="btn btn-primary">Accueil</a>
            <button class="btn btn-secondary" onclick="history.back()">Retour</button>
        </div>
    </div>
</body>
</html>
