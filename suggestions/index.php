<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PeerSync — Connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Sora', sans-serif; background: #0f1117; color: #e8e9f0; }
    .mono { font-family: 'JetBrains Mono', monospace; }
    .card { background: #1a1d27; border: 1px solid #2a2d3e; }
    .input-field {
      background: #0f1117;
      border: 1px solid #2a2d3e;
      color: #e8e9f0;
      transition: border-color 0.2s;
    }
    .input-field:focus { outline: none; border-color: #6c63ff; }
    .input-field::placeholder { color: #4a4d60; }
    .btn-primary {
      background: #6c63ff;
      transition: background 0.2s, transform 0.1s;
    }
    .btn-primary:hover { background: #5a52e0; }
    .btn-primary:active { transform: scale(0.98); }
    .dot { width: 6px; height: 6px; border-radius: 50%; background: #6c63ff; display: inline-block; }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

  <!-- Background grid decoration -->
  <div class="fixed inset-0 opacity-5 pointer-events-none"
       style="background-image: linear-gradient(#6c63ff 1px, transparent 1px), linear-gradient(90deg, #6c63ff 1px, transparent 1px); background-size: 40px 40px;"></div>

  <div class="w-full max-w-md relative z-10">

    <!-- Logo -->
    <div class="text-center mb-10">
      <div class="inline-flex items-center gap-3 mb-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:#6c63ff22; border:1px solid #6c63ff44;">
          <img src="https://app.enaa.ma/src/img/logo.png" alt="Logo" height="30">
        </div>
        <span class="text-2xl font-bold tracking-tight">PeerSync</span>
      </div>
    </div>

    <div class="card rounded-2xl p-8">
      <h1 class="text-xl font-semibold mb-1">Connexion</h1>
      <p class="text-sm mb-6" style="color:#6b6e85;">Accède à ton espace d'entraide.</p>

      <form action="../scripts/login_process.php" method="POST" class="space-y-4">

        <div>
          <label class="block text-xs font-medium mb-1.5" style="color:#9a9db5;">Adresse email</label>
          <input type="email" name="email" placeholder="prenom.nom@enaa.ma"
                 class="input-field w-full rounded-lg px-4 py-2.5 text-sm" required />
        </div>

        <div>
          <label class="block text-xs font-medium mb-1.5" style="color:#9a9db5;">Mot de passe</label>
          <input type="password" name="password" placeholder="••••••••"
                 class="input-field w-full rounded-lg px-4 py-2.5 text-sm" required />
        </div>

        <?php if (isset($_GET['error'])): ?>
        <div class="rounded-lg px-4 py-2.5 text-sm" style="background:#ff4d4d18;border:1px solid #ff4d4d44;color:#ff8080;">
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
        <?php endif; ?>

        <button type="submit" class="btn-primary w-full rounded-lg py-2.5 text-sm font-semibold text-white mt-2">
          Se connecter
        </button>

      </form>
    </div>
 </div>
</body>
</html>
