<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion | ODC STORE</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    /* Background gradient + digital animation */
    body {
      margin: 0;
      height: 100vh;
      overflow: hidden;
      font-family: "Poppins", sans-serif;
      background: #020617;
      color: #ffffff;
    }

    canvas#bg {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: 0;
    }

    /* 3D Card container */
    .login-wrapper {
      position: relative;
      z-index: 10;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      perspective: 1200px;
    }

    /* Card Styled */
    .login-card {
      width: 420px;
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(18px);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.6);
      border: 1px solid rgba(255,255,255,0.08);
      transform-style: preserve-3d;
      transition: transform .3s ease-out;
    }

    .login-card:hover {
      box-shadow: 0 35px 90px rgba(0,0,0,0.8);
    }

    /* Title */
    .title {
      font-size: 28px;
      font-weight: 700;
      color: #ff8c42;
      text-shadow: 0 0 12px rgba(255,140,66,0.4);
    }

    /* Inputs */
    .form-control {
      border-radius: 12px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      color: #fff;
    }

    .form-control:focus {
      border-color: #ff8c42;
      box-shadow: 0 0 15px rgba(255,140,66,0.4);
    }

    /* Button */
    .btn-orange {
      background: linear-gradient(90deg, #ff8c42, #ff6a00);
      border: none;
      border-radius: 12px;
      color: white;
      padding: 12px;
      font-size: 16px;
      font-weight: 600;
      box-shadow: 0 12px 30px rgba(255,140,66,0.3);
      transition: transform .15s ease-out;
    }

    .btn-orange:active {
      transform: translateY(2px) scale(0.98);
    }

    a {
      color: #ff8c42;
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Background animation -->
<canvas id="bg"></canvas>

<div class="login-wrapper">
  <div class="login-card" id="card3d">
    <div class="text-center mb-4">
      <h2 class="title"><i class="fa-solid fa-store"></i> ODC STORE</h2>
    </div>

    <form action="<?= base_url('login') ?>" method="post">

      <div class="mb-3">
        <label class="form-label">Pseudo</label>
        <input type="text" name="pseudo" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" required>
          <span class="input-group-text bg-transparent text-white"><i class="fa-solid fa-lock"></i></span>
        </div>
      </div>

      <button type="submit" class="btn btn-orange w-100 mt-2">
        <i class="fa-solid fa-right-to-bracket"></i> Se connecter
      </button>
    </form>

    <div class="text-center mt-3">
      <p>Pas encore de compte ?
        <a href="<?= base_url('register') ?>">S’inscrire</a>
      </p>
    </div>

    <footer class="text-center text-muted mt-3" style="font-size: 0.8rem;">
      © Francis 2025
    </footer>
  </div>
</div>

<script>
/* ----------- 3D Card Tilt ----------- */
const card = document.getElementById("card3d");
document.addEventListener("mousemove", (e) => {
  let x = (window.innerWidth / 2 - e.clientX) / 25;
  let y = (window.innerHeight / 2 - e.clientY) / 25;
  card.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
});

/* ----------- Digital Animated Background ----------- */
const canvas = document.getElementById("bg");
const ctx = canvas.getContext("2d");

function resize() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
resize();
window.onresize = resize;

let particles = [];
let count = 90;

for (let i = 0; i < count; i++) {
  particles.push({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    r: Math.random() * 2 + 1,
    dx: (Math.random() - 0.5) * 0.7,
    dy: (Math.random() - 0.5) * 0.7
  });
}

function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.fillStyle = "#02101a";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  particles.forEach(p => {
    ctx.beginPath();
    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
    ctx.fillStyle = "rgba(0,200,255,0.7)";
    ctx.fill();

    p.x += p.dx;
    p.y += p.dy;

    if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
    if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
  });

  requestAnimationFrame(animate);
}
animate();
</script>

</body>
</html>
