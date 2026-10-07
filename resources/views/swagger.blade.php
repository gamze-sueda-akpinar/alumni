<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mezun Takip Sistemi - Swagger API Dokümantasyonu</title>
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.18.2/swagger-ui.css">
    <link rel="icon" type="image/png" href="https://unpkg.com/swagger-ui-dist@5.18.2/favicon-32x32.png" sizes="32x32" />
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fafafa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .top-navbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .top-navbar h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .top-navbar .nav-links a {
            color: #e0e7ff;
            text-decoration: none;
            margin-left: 16px;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.1);
        }
        .top-navbar .nav-links a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.25);
        }
        .swagger-ui .topbar {
            display: none !important;
        }
        #swagger-ui {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 60px;
        }
    </style>
</head>
<body>
    <header class="top-navbar">
        <h1>
            <span>🎓</span> Mezun Takip Sistemi — REST API Swagger
        </h1>
        <div class="nav-links">
            <a href="/admin" target="_blank">Admin Paneli (Filament)</a>
            <a href="/main" target="_blank">Ana Sayfa</a>
            <a href="/api/swagger.json" target="_blank" download>OpenAPI JSON İndir</a>
        </div>
    </header>

    <div id="swagger-ui"></div>

    <!-- Swagger UI Bundle JS -->
    <script src="https://unpkg.com/swagger-ui-dist@5.18.2/swagger-ui-bundle.js" charset="UTF-8"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.18.2/swagger-ui-standalone-preset.js" charset="UTF-8"></script>
    <script>
        window.onload = function() {
            window.ui = SwaggerUIBundle({
                url: "/api/swagger.json",
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "BaseLayout",
                defaultModelsExpandDepth: 1,
                defaultModelExpandDepth: 2,
                docExpansion: "list",
                displayRequestDuration: true,
                filter: true
            });
        };
    </script>
</body>
</html>
