<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik Planlayıcınız</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style-footer.css">

    <style>
        .navbar {
            background-color: #F0F7FF !important; /* Example style */
            background-image: linear-gradient(#F0F7FF, #F0F7FF);
            box-shadow: 0 10px 15px rgba(0, 123, 255, 0.15); /* Example style */
        }
        .right {
            background-color: #007BFF !important; 
            background-image: linear-gradient(to right, #007bff , #F0F7FF);
        }
        .left {
            background-color: #007BFF !important; /* Example style */
            background-image: linear-gradient(to left, #007bff , #F0F7FF);
        }
        .card {
            border-radius: 15px;
            box-shadow: rgba(0, 123, 255, 0.25) 0px 30px 100px -20px, rgba(0, 123, 255, 0.4) 0px 20px 60px -30px, rgba(0, 123, 255, 0.4) 0px -2px 6px 0px inset;
            cursor: pointer;
            background-color: #F0F7FF;
        }
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .container-fluid {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Navbar -- This is not header-->
    <nav class="navbar navbar-expand-lg">
        <span class="navbar-brand mb-0 h1" style="color: black;">Akademik Planlayıcınız</span>
    </nav>

    <div class="container-fluid">
        <div class="row" style="height: calc(100vh - 56px);">
            <div class="col-md-3 right"></div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="text-center border p-4 card" style="background-color: white;">
                    <div style="height: 200px; border: none; margin-bottom: 20px;">
                        <img src="logo.png" alt="logo">
                    </div>
                    <a href="login.html" class="btn btn-primary btn-block mb-3 login-button">Giriş Yap</a>
                    <p>veya</p>
                    <a href="register.html" class="btn btn-secondary btn-block">Kayıt ol</a>
                </div>
            </div>
            <div class="col-md-3 left"></div>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
