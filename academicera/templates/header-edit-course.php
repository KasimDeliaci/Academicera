<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik Planlayıcınız</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style-header.css">
    <style>
        .nav-link {
            cursor: pointer;
        }
        .nav-link.active {
            text-decoration: underline;
            font-weight: bold;
            
        }
        .d-none {
            display: none;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-header fixed-top">
    <a class="navbar-brand" href="./index.php">Akademik Planlayıcınız</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link toggle-form" data-target="edit-course-form">Ders Düzenle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link toggle-form" data-target="add-study-plan-form">Çalışma Planı Ekle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link toggle-form" data-target="add-assignment-form">Ödev Ekle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link toggle-form" data-target="add-exam-form">Sınav Ekle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./courses.php">Derslerim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./dashboard.php">Ana Sayfa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./index.php">Çıkış Yap</a>
            </li>
        </ul>
    </div>
</nav>