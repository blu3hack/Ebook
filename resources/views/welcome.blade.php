<!DOCTYPE html>
<html lang="en">
  <head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/formlogin.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Archivo:ital,wght@1,200&family=Caveat:wght@500&family=Cormorant+Garamond&family=IBM+Plex+Serif:wght@300&family=Lobster&family=Poppins:ital,wght@0,100;0,200;0,500;1,300;1,500&family=Shadows+Into+Light&display=swap"
      rel="stylesheet"
    />
    <title>Belajar</title>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row full-height">
            <div class="col-6 left border login-side">
                <div class="left-side">
                    <div class="sisi-kiri-logo">
                        <div class="logo">
                            <div class="logo-sekolah">
                                <img src="img/logo.png" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="judul">
                        <p>Selamat Datang di Portal E-Book</p>
                        <p>Al-Azhar Kelapa Gading Surabaya</p>
                        <p>Allah akan meninggikan orang-orang yang beriman di antaramu dan orang-orang yang diberi ilmu pengetahuan beberapa derajat <br> (QS. Al Mujadilah : 11)</p>
                    </div>
                </div>
                
            </div>
            <div class="col-6 right login-side form-login">
                <section id="contact" class="right-side">
                    <h2><span>Masuk</span></h2>
                    <p>Silahkan login dengan akun anda</p>
                    <div class="row">
                        <div class="keterangan"></p></div>
                        <form action="login.php" method="post">
                            <label for="name">Masukan Username</label>
                            <div class="input-group">
                                <input type="text" name="username"/>
                            </div>
                            <label for="token">Masukan Password</label>
                            <div class="input-group">
                                <input type="password" name="token" />
                            </div>
                            <div class="button">
                                <button type="submit" name="login" class="btn">Masuk</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
  </body>
</html>


