<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PeerSync — Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Sora', sans-serif; background: #0f1117; color: #e8e9f0; }
    .mono { font-family: 'JetBrains Mono', monospace; }
    .sidebar { background: #1a1d27; border-right: 1px solid #2a2d3e; }
    .card { background: #1a1d27; border: 1px solid #2a2d3e; }
    .nav-link { color: #6b6e85; transition: all 0.15s; border-radius: 8px; }
    .nav-link:hover { color: #e8e9f0; background: #2a2d3e44; }
    .nav-link.active { color: #e8e9f0; background: #6c63ff22; border: 1px solid #6c63ff33; }
    .badge-wait  { background:#f59e0b18; color:#f59e0b; border:1px solid #f59e0b33; }
    .badge-assign{ background:#6c63ff18; color:#a5a0ff; border:1px solid #6c63ff33; }
    .badge-done  { background:#10b98118; color:#34d399; border:1px solid #10b98133; }
    .skill-tag { background:#2a2d3e; color:#9a9db5; border:1px solid #3a3d50; font-size:11px; border-radius:6px; padding:2px 8px; }
    .skill-tag.mastered { background:#6c63ff18; color:#a5a0ff; border-color:#6c63ff33; }
    .btn-primary { background:#6c63ff; transition:background 0.2s; }
    .btn-primary:hover { background:#5a52e0; }
    .ticket-row:hover { background:#1f2233; }
    .input-field { background:#0f1117; border:1px solid #2a2d3e; color:#e8e9f0; transition:border-color 0.2s; }
    .input-field:focus { outline:none; border-color:#6c63ff; }
    .input-field::placeholder { color:#4a4d60; }
  </style>
</head>
<body class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="sidebar w-56 flex-shrink-0 flex flex-col fixed top-0 left-0 h-full z-20">
  <div class="p-5 flex items-center gap-2.5" style="border-bottom:1px solid #2a2d3e;">
    <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:#6c63ff22;border:1px solid #6c63ff44;">
      <img src="https://app.enaa.ma/src/img/logo.png" alt="Logo" height="30">
    </div>
    <span class="font-bold text-sm tracking-tight">PeerSync</span>
  </div>

  <nav class="flex-1 p-3 space-y-1">
    <a href="dashboard.php" class="nav-link active flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
      Dashboard
    </a>
    <a href="profil.php" class="nav-link flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      Mon Profil
    </a>
    <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
      Notifications
      <span class="ml-auto mono text-xs rounded-full px-1.5 py-0.5" style="background:#ff4d4d22;color:#ff8080;">3</span>
    </a>
  </nav>

  <!-- User info -->
  <div class="p-3" style="border-top:1px solid #2a2d3e;">
    <div class="flex items-center gap-3 px-2 py-2 rounded-lg" style="background:#2a2d3e33;">
      <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold" style="background:#6c63ff33;color:#a5a0ff;">
        <?= strtoupper(substr($_SESSION['nom'] ?? 'U', 0, 2)) ?>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-medium truncate"><?= htmlspecialchars($_SESSION['nom'] ?? 'Utilisateur') ?></p>
        <p class="text-xs mono truncate" style="color:#6b6e85;"><?= htmlspecialchars($_SESSION['role'] ?? 'apprenant') ?></p>
      </div>
    </div>
    <a href="../scripts/logout.php" class="flex items-center gap-2 px-2 py-2 text-xs mt-1 rounded-lg nav-link" style="color:#ff6b6b;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Déconnexion
    </a>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main class="flex-1 ml-56 p-8">

  <?php if (isset($_GET['success'])): ?>
  <div class="mb-5 rounded-xl px-4 py-3 text-sm flex items-center gap-3" style="background:#10b98118;border:1px solid #10b98133;color:#34d399;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    <?= htmlspecialchars($_GET['success']) ?>
  </div>
  <?php endif; ?>

  <?php if (isset($_GET['error'])): ?>
  <div class="mb-5 rounded-xl px-4 py-3 text-sm flex items-center gap-3" style="background:#ff4d4d18;border:1px solid #ff4d4d33;color:#ff8080;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <?= htmlspecialchars($_GET['error']) ?>
  </div>
  <?php endif; ?>

  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-2xl font-bold">Tableau de bord</h1>
      <p class="text-sm mt-0.5" style="color:#6b6e85;">Bienvenue, <?= htmlspecialchars($_SESSION['nom'] ?? 'Apprenant') ?></p>
    </div>
    <button onclick="document.getElementById('modal-new').classList.remove('hidden')"
            class="btn-primary flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Nouvelle demande
    </button>
  </div>

  <!-- Stats -->
  <div class="grid grid-cols-3 gap-4 mb-8">
    <div class="card rounded-xl p-5">
      <p class="text-xs font-medium mb-2" style="color:#6b6e85;">En attente</p>
      <p class="text-3xl font-bold mono" style="color:#f59e0b;"><?= $stats['en_attente'] ?? 4 ?></p>
    </div>
    <div class="card rounded-xl p-5">
      <p class="text-xs font-medium mb-2" style="color:#6b6e85;">En cours</p>
      <p class="text-3xl font-bold mono" style="color:#a5a0ff;"><?= $stats['assigne'] ?? 2 ?></p>
    </div>
    <div class="card rounded-xl p-5">
      <p class="text-xs font-medium mb-2" style="color:#6b6e85;">Résolues</p>
      <p class="text-3xl font-bold mono" style="color:#34d399;"><?= $stats['resolue'] ?? 11 ?></p>
    </div>
  </div>

  <!-- Ticket list -->
  <div class="card rounded-2xl overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #2a2d3e;">
      <h2 class="font-semibold text-sm">Demandes d'aide</h2>
      <select class="input-field text-xs rounded-lg px-3 py-1.5">
        <option>Toutes</option>
        <option>En attente</option>
        <option>Assignées</option>
        <option>Résolues</option>
      </select>
    </div>
    <table class="w-full text-sm">
      <thead>
        <tr style="border-bottom:1px solid #2a2d3e;">
          <th class="px-6 py-3 text-left text-xs font-medium" style="color:#4a4d60;">#</th>
          <th class="px-4 py-3 text-left text-xs font-medium" style="color:#4a4d60;">Titre</th>
          <th class="px-4 py-3 text-left text-xs font-medium" style="color:#4a4d60;">Techno</th>
          <th class="px-4 py-3 text-left text-xs font-medium" style="color:#4a4d60;">Statut</th>
          <th class="px-4 py-3 text-left text-xs font-medium" style="color:#4a4d60;">Apprenant</th>
          <th class="px-4 py-3 text-left text-xs font-medium" style="color:#4a4d60;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Example rows — replace with actual $tickets from HelpRequestRepository
        $demo = [
          ['id'=>1,'titre'=>'Problème avec PDO et les transactions','techno'=>'PHP','statut'=>'EN_ATTENTE','etudiant'=>'Khalid M.','tuteur'=>null],
          ['id'=>2,'titre'=>'Comprendre les jointures SQL','techno'=>'SQL','statut'=>'ASSIGNE','etudiant'=>'Sara B.','tuteur'=>'Younes A.'],
          ['id'=>3,'titre'=>'Callback vs Promise en JS','techno'=>'JavaScript','statut'=>'EN_ATTENTE','etudiant'=>'Amine L.','tuteur'=>null],
          ['id'=>4,'titre'=>'Héritage POO — méthodes abstraites','techno'=>'PHP','statut'=>'RESOLUE','etudiant'=>'Fatima Z.','tuteur'=>'Mehdi R.'],
          ['id'=>5,'titre'=>'Flexbox vs Grid CSS','techno'=>'CSS','statut'=>'EN_ATTENTE','etudiant'=>'Karim D.','tuteur'=>null],
        ];
        $tickets = $tickets ?? $demo;
        foreach ($tickets as $t):
          $statusClass = match($t['statut']) {
            'EN_ATTENTE' => 'badge-wait', 'ASSIGNE' => 'badge-assign', default => 'badge-done'
          };
          $statusLabel = match($t['statut']) {
            'EN_ATTENTE' => 'En attente', 'ASSIGNE' => 'Assigné', default => 'Résolue'
          };
        ?>
        <tr class="ticket-row cursor-pointer" style="border-bottom:1px solid #2a2d3e11;"
            onclick="window.location='request_detail.php?id=<?= $t['id'] ?>'">
          <td class="px-6 py-3.5 mono text-xs" style="color:#4a4d60;">#<?= $t['id'] ?></td>
          <td class="px-4 py-3.5 font-medium text-sm"><?= htmlspecialchars($t['titre']) ?></td>
          <td class="px-4 py-3.5">
            <span class="skill-tag"><?= htmlspecialchars($t['techno']) ?></span>
          </td>
          <td class="px-4 py-3.5">
            <span class="<?= $statusClass ?> text-xs font-medium px-2.5 py-1 rounded-full"><?= $statusLabel ?></span>
          </td>
          <td class="px-4 py-3.5 text-xs" style="color:#9a9db5;"><?= htmlspecialchars($t['etudiant']) ?></td>
          <td class="px-4 py-3.5">
            <?php if ($t['statut'] === 'EN_ATTENTE' && ($_SESSION['id'] ?? 0) !== ($t['id_student'] ?? -1)): ?>
            <form action="../scripts/assign_process.php" method="POST" onclick="event.stopPropagation()">
              <input type="hidden" name="ticket_id" value="<?= $t['id'] ?>"/>
              <button type="submit" class="text-xs px-3 py-1 rounded-lg font-medium transition-colors"
                      style="background:#6c63ff22;color:#a5a0ff;border:1px solid #6c63ff33;">
                Prendre en charge
              </button>
            </form>
            <?php else: ?>
            <span class="text-xs" style="color:#4a4d60;">—</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- MODAL : New Ticket -->
<div id="modal-new" class="hidden fixed inset-0 z-50 flex items-center justify-center" style="background:#00000088;">
  <div class="card rounded-2xl p-6 w-full max-w-md mx-4">
    <div class="flex items-center justify-between mb-5">
      <h2 class="font-semibold">Nouvelle demande d'aide</h2>
      <button onclick="document.getElementById('modal-new').classList.add('hidden')"
              class="text-sm rounded-lg p-1" style="color:#6b6e85;">✕</button>
    </div>
    <form action="../scripts/request_process.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-xs font-medium mb-1.5" style="color:#9a9db5;">Titre du problème</label>
        <input type="text" name="titre" placeholder="Ex: Problème avec les jointures SQL"
               class="input-field w-full rounded-lg px-3 py-2.5 text-sm" required/>
      </div>
      <div>
        <label class="block text-xs font-medium mb-1.5" style="color:#9a9db5;">Description</label>
        <textarea name="description" rows="3" placeholder="Décris ton problème en détail..."
                  class="input-field w-full rounded-lg px-3 py-2.5 text-sm resize-none" required></textarea>
      </div>
      <div>
        <label class="block text-xs font-medium mb-1.5" style="color:#9a9db5;">Technologie</label>
        <select name="technologie" class="input-field w-full rounded-lg px-3 py-2.5 text-sm">
          <option>PHP</option><option>JavaScript</option><option>SQL</option>
          <option>CSS</option><option>HTML</option><option>POO</option>
        </select>
      </div>
      <div class="flex gap-3 pt-2">
        <button type="button" onclick="document.getElementById('modal-new').classList.add('hidden')"
                class="flex-1 py-2.5 rounded-xl text-sm font-medium" style="border:1px solid #2a2d3e;color:#9a9db5;">
          Annuler
        </button>
        <button type="submit" class="btn-primary flex-1 py-2.5 rounded-xl text-sm font-semibold text-white">
          Publier
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
