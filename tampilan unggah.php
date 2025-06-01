<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Halaman Favorit</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      color: #333;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 50px 20px;
    }

    .container {
      background-color: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 600px;
      width: 100%;
    }

    .icon-heart {
      font-size: 40px;
      color: #e74c3c;
    }

    h2 {
      margin-top: 10px;
      font-size: 28px;
      color: #333;
    }

    p {
      margin-top: 10px;
      color: #555;
    }

    .btn-container {
      margin-top: 30px;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .btn {
      padding: 10px 20px;
      background-color: #27ae60;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #219150;
    }

    .breadcrumb {
      margin-bottom: 20px;
      color: #666;
      font-size: 14px;
    }
  </style>
</head>
<body>
  
  <div class="container">
    <div class="icon-unggah">🍲</div>
    <h2> Unggah Resep Mu Di Sini dan lihat hasil nya</h2>
    <p>Buat dan unggah resep hasil masakan mu.<br/>Klik untuk Unggah resep jika ingin melihat resepmu klik lihat resep.</p>
    <div class="btn-container">
      <a href="unggah resep.php" class="btn">❤️unggah resep</a>
      <a href="resepku.php" class="btn">🍲 Resepku</a>
    </div>
  </div>

</body>
</html>
