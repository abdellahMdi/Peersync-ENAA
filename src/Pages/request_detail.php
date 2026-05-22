<?php
session_start();
if(isset($_SESSION['request']) || empty($_SESSION['request']) ){
  header('Location: ../Pages/dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PeerSync — Détail du ticket</title>
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
    .skill-tag { background:#2a2d3e; color:#9a9db5; border:1px solid #3a3d50; font-size:11px; border-radius:6px; padding:3px 10px; }
    .input-field { background:#0f1117; border:1px solid #2a2d3e; color:#e8e9f0; transition:border-color 0.2s; }
    .input-field:focus { outline:none; border-color:#6c63ff; }
    .input-field::placeholder { color:#4a4d60; }
    .btn-primary { background:#6c63ff; transition:background 0.2s; }
    .btn-primary:hover { background:#5a52e0; }
    .star-btn { cursor:pointer; transition:color 0.15s; }
  </style>
</head>
<body class="flex min-h-screen">

<!-- SIDEBAR (same as dashboard) -->
<aside class="sidebar w-56 flex-shrink-0 flex flex-col fixed top-0 left-0 h-full z-20">
  <div class="p-5 flex items-center gap-2.5" style="border-bottom:1px solid #2a2d3e;">
    <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:#6c63ff22;border:1px solid #6c63ff44;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6c63ff" stroke-width="2.5">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
    </div>
    <span class="font-bold text-sm tracking-tight">PeerSync</span>
  </div>
  <nav class="flex-1 p-3 space-y-1">
    <a href="dashboard.php" class="nav-link flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
      Dashboard
    </a>
    <a href="profil.php" class="nav-link flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      Mon Profil
    </a>
  </nav>
  <div class="p-3" style="border-top:1px solid #2a2d3e;">
    <div class="flex items-center gap-3 px-2 py-2 rounded-lg" style="background:#2a2d3e33;">
      <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold" style="background:#6c63ff33;color:#a5a0ff;">KM</div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-medium truncate">Khalid M.</p>
        <p class="text-xs mono truncate" style="color:#6b6e85;">apprenant</p>
      </div>
    </div>
  </div>
</aside>

<!-- MAIN -->
<main class="flex-1 ml-56 p-8 max-w-4xl">

  <!-- Breadcrumb -->
  <div class="flex items-center gap-2 text-xs mb-6" style="color:#6b6e85;">
    <a href="dashboard.php" class="hover:text-white transition-colors">Dashboard</a>
    <span>›</span>
    <span style="color:#9a9db5;">Ticket #<?= htmlspecialchars($_SESSION['request']->getId() ?? '1') ?></span>
  </div>

  <?php
  // Demo data — replace with $ticket from HelpRequestRepository::findById()
  $ticket = $ticket ?? [
    'id' => $_SESSION['request']->getId(),
    'titre' => $_SESSION['request']->getTitle(),
    'description' => $_SESSION['request']->getDescription(),
    'technologie' => $_SESSION['request']->skill->getName(),
    'statut' => getStatus(),
    'etudiant' => $_SESSION['request']->learner->getName(),
    'tuteur' => $_SESSION['request']->tutor->getName() ?? "not assigned yet",
    'created_at' => $_SESSION['request']->getDatePub(),
  ];
  $statusClass = match($ticket['statut']) {
    'EN_ATTENTE' => 'badge-wait', 'ASSIGNE' => 'badge-assign', default => 'badge-done'
  };
  $statusLabel = match($ticket['statut']) {
    'EN_ATTENTE' => 'En attente', 'ASSIGNE' => 'Assigné', default => 'Résolue'
  };
  ?>

  <div class="grid grid-cols-3 gap-6">

    <!-- Left: ticket content -->
    <div class="col-span-2 space-y-5">

      <!-- Ticket card -->
      <div class="card rounded-2xl p-6">
        <div class="flex items-start justify-between gap-4 mb-4">
          <div>
            <div class="flex items-center gap-2 mb-2">
              <span class="mono text-xs" style="color:#4a4d60;">#<?= $ticket['id'] ?></span>
              <span class="<?= $statusClass ?> text-xs font-medium px-2.5 py-1 rounded-full"><?= $statusLabel ?></span>
              <span class="skill-tag"><?= htmlspecialchars($ticket['technologie']) ?></span>
            </div>
            <h1 class="text-xl font-semibold"><?= htmlspecialchars($ticket['titre']) ?></h1>
          </div>
        </div>
        <p class="text-sm leading-relaxed" style="color:#9a9db5;"><?= nl2br(htmlspecialchars($ticket['description'])) ?></p>
        <p class="text-xs mt-4 mono" style="color:#4a4d60;">Publié le <?= $ticket['created_at'] ?></p>
      </div>

      <!-- Action zone for student: mark as resolved -->
      <?php if ($ticket['statut'] === 'ASSIGNE' && ($_SESSION['id'] ?? 0) == ($ticket['id_student'] ?? 1)): ?>
      <div class="card rounded-2xl p-6" style="border-color:#10b98133;">
        <h2 class="font-semibold text-sm mb-4" style="color:#34d399;">Marquer comme résolu</h2>
        <form action="../scripts/close_process.php" method="POST" class="space-y-4">
          <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>"/>
          <div>
            <label class="block text-xs font-medium mb-1.5" style="color:#9a9db5;">Commentaire de remerciement</label>
            <textarea name="commentaire" rows="3"
                      placeholder="Merci à mon tuteur pour son aide, il m'a expliqué..."
                      class="input-field w-full rounded-lg px-3 py-2.5 text-sm resize-none" required></textarea>
          </div>
          <!-- Star rating -->
          <div>
            <label class="block text-xs font-medium mb-2" style="color:#9a9db5;">Évaluation du tuteur (1–5)</label>
            <div class="flex items-center gap-1" id="stars">
              <?php for ($i=1;$i<=5;$i++): ?>
              <button type="button" data-val="<?= $i ?>"
                      onclick="setRating(<?= $i ?>)"
                      class="star-btn text-2xl" style="color:#4a4d60;">★</button>
              <?php endfor; ?>
            </div>
            <input type="hidden" name="note" id="note-input" value="0"/>
          </div>
          <button type="submit"
                  class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-colors"
                  style="background:#10b981;">
            ✓ Confirmer la résolution
          </button>
        </form>
      </div>
      <?php endif; ?>

    </div>

    <!-- Right: meta panel -->
    <div class="space-y-4">

      <div class="card rounded-2xl p-5">
        <h3 class="text-xs font-medium mb-4" style="color:#4a4d60;">PARTICIPANTS</h3>
        <div class="space-y-3">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0" style="background:#f59e0b22;color:#f59e0b;">
              <?= strtoupper(substr($ticket['etudiant'], 0, 2)) ?>
            </div>
            <div>
              <p class="text-xs font-medium"><?= htmlspecialchars($ticket['etudiant']) ?></p>
              <p class="text-xs" style="color:#6b6e85;">Apprenant</p>
            </div>
          </div>
          <?php if ($ticket['tuteur']): ?>
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0" style="background:#6c63ff22;color:#a5a0ff;">
              <?= strtoupper(substr($ticket['tuteur'], 0, 2)) ?>
            </div>
            <div>
              <p class="text-xs font-medium"><?= htmlspecialchars($ticket['tuteur']) ?></p>
              <p class="text-xs" style="color:#6b6e85;">Tuteur assigné</p>
            </div>
          </div>
          <?php else: ?>
          <p class="text-xs" style="color:#4a4d60;">Aucun tuteur assigné</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Assign button for tutor (if ticket is EN_ATTENTE) -->
      <?php if ($ticket['statut'] === 'EN_ATTENTE'): ?>
      <div class="card rounded-2xl p-5" style="border-color:#6c63ff33;">
        <p class="text-xs mb-3" style="color:#9a9db5;">Tu peux aider cet apprenant !</p>
        <form action="../scripts/assign_process.php" method="POST">
          <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>"/>
          <button type="submit" class="btn-primary w-full py-2.5 rounded-xl text-sm font-semibold text-white">
            Prendre en charge
          </button>
        </form>
      </div>
      <?php endif; ?>

      <div class="card rounded-2xl p-5">
        <h3 class="text-xs font-medium mb-3" style="color:#4a4d60;">INFOS</h3>
        <div class="space-y-2 text-xs">
          <div class="flex justify-between">
            <span style="color:#6b6e85;">Technologie</span>
            <span class="skill-tag"><?= htmlspecialchars($ticket['technologie']) ?></span>
          </div>
          <div class="flex justify-between">
            <span style="color:#6b6e85;">Créé le</span>
            <span><?= $ticket['created_at'] ?></span>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>

<script>
function setRating(val) {
  document.getElementById('note-input').value = val;
  const stars = document.querySelectorAll('#stars .star-btn');
  stars.forEach((btn, i) => {
    btn.style.color = i < val ? '#f59e0b' : '#4a4d60';
  });
}
</script>

</body>
</html>
