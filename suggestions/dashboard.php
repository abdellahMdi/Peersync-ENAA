<?php
session_start();
require_once __DIR__."/../Repositories/HelpRequestRepository.php"
?>
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
    .ticket-card:hover { background:#1f2233; border-color: #3a3d50; }
    .input-field { background:#0f1117; border:1px solid #2a2d3e; color:#e8e9f0; transition:border-color 0.2s; }
    .input-field:focus { outline:none; border-color:#6c63ff; }
    .input-field::placeholder { color:#4a4d60; }
    
    /* Smooth transitions for the notification panel */
    #notification-dropdown { transition: opacity 0.15s ease, transform 0.15s ease; }
    #notification-dropdown.hidden { display: none; opacity: 0; transform: translateY(10px); }
  </style>
</head>
<body class="flex min-h-screen">

<aside class="sidebar w-56 flex-shrink-0 flex flex-col fixed top-0 left-0 h-full z-20">
  <div class="p-5 flex items-center gap-2.5" style="border-bottom:1px solid #2a2d3e;">
    <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:#6c63ff22;border:1px solid #6c63ff44;">
      <img src="https://app.enaa.ma/src/img/logo.png" alt="Logo" height="30">
    </div>
    <span class="font-bold text-sm tracking-tight">PeerSync</span>
  </div>

  <nav class="flex-1 p-3 space-y-1 relative">
    <a href="dashboard.php" class="nav-link active flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
      Dashboard
    </a>
    <a href="profil.php" class="nav-link flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      Mon Profil
    </a>
    
    <div class="relative">
      <button id="noti-toggle-btn" class="w-full nav-link flex items-center gap-3 px-3 py-2 text-sm font-medium text-left">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
        Notifications
        <span class="ml-auto mono text-xs rounded-full px-1.5 py-0.5" style="background:#ff4d4d22;color:#ff8080;">3</span>
      </button>

      <div id="notification-dropdown" class="hidden absolute left-full top-0 ml-2 w-80 card rounded-xl shadow-2xl z-30 overflow-hidden" onclick="event.stopPropagation()">
        <div class="px-4 py-3 flex items-center justify-between" style="border-bottom: 1px solid #2a2d3e;">
          <span class="font-semibold text-xs tracking-wide uppercase text-gray-400">Notifications</span>
          <button class="text-[10px] text-indigo-400 hover:underline">Tout marquer comme lu</button>
        </div>
        <div class="max-h-72 overflow-y-auto divide-y divide-[#2a2d3e33]">
          <div class="p-3.5 hover:background-[#2a2d3e22] transition-colors cursor-pointer flex gap-3 items-start">
            <div class="w-2 h-2 mt-1.5 rounded-full bg-indigo-500 flex-shrink-0"></div>
            <div>
              <p class="text-xs text-gray-200 leading-normal"><strong>Younes A.</strong> a accepté votre demande d'aide sur <span class="text-indigo-300">"Jointures SQL"</span>.</p>
              <span class="text-[10px] font-mono text-gray-500 block mt-1">Il y a 10 min</span>
            </div>
          </div>
          <div class="p-3.5 hover:background-[#2a2d3e22] transition-colors cursor-pointer flex gap-3 items-start">
            <div class="w-2 h-2 mt-1.5 rounded-full bg-indigo-500 flex-shrink-0"></div>
            <div>
              <p class="text-xs text-gray-200 leading-normal">Une nouvelle demande sur <span class="text-emerald-400">PHP</span> attend un tuteur.</p>
              <span class="text-[10px] font-mono text-gray-500 block mt-1">Il y a 1 heure</span>
            </div>
          </div>
          <div class="p-3.5 hover:background-[#2a2d3e22] transition-colors cursor-pointer flex gap-3 items-start">
            <div class="w-2 h-2 mt-1.5 rounded-full bg-gray-600 flex-shrink-0"></div>
            <div>
              <p class="text-xs text-gray-400 leading-normal">Votre session d'entraide avec Fatima Z. a été marquée comme résolue.</p>
              <span class="text-[10px] font-mono text-gray-500 block mt-1">Hier, à 18:00</span>
            </div>
          </div>
        </div>
        <div class="p-2.5 text-center bg-[#0f111755]" style="border-top: 1px solid #2a2d3e;">
          <a href="#" class="text-xs text-gray-400 hover:text-white font-medium inline-block w-full">Voir l'historique complet</a>
        </div>
      </div>
      </div>
  </nav>

  <div class="p-3" style="border-top:1px solid #2a2d3e;">
    <div class="flex items-center gap-3 px-2 py-2 rounded-lg" style="background:#2a2d3e33;">
      <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold" style="background:#6c63ff33;color:#a5a0ff;">
        <?= 'U' ?>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-medium truncate"><?= $_SESSION['user_name']; ?></p>
        <p class="text-xs mono truncate" style="color:#6b6e85;"><?= $_SESSION['user_role']; ?></p>
      </div>
    </div>
    <a href="../scripts/logout.php" class="flex items-center gap-2 px-2 py-2 text-xs mt-1 rounded-lg nav-link" style="color:#ff6b6b;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Déconnexion
    </a>
  </div>
</aside>

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

  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-2xl font-bold">Tableau de bord</h1>
      <p class="text-sm mt-0.5" style="color:#6b6e85;">Bienvenue, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Apprenant') ?></p>
    </div>
    <button onclick="document.getElementById('modal-new').classList.remove('hidden')"
            class="btn-primary flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Nouvelle demande
    </button>
  </div>

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

  <div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-lg">Demandes d'aide récentes</h2>
  </div>

  <div class="space-y-4">
    <?php
    $tickets = getAllRequests();
    foreach ($tickets as $t):
      $statusClass = match($t['statut']) {
        'EN_ATTENTE' => 'badge-wait', 'ASSIGNE' => 'badge-assign', default => 'badge-done'
      };
      $statusLabel = match($t['statut']) {
        'EN_ATTENTE' => 'En attente', 'ASSIGNE' => 'Assigné', default => 'Résolue'
      };
    ?>
    <div class="card ticket-card rounded-xl p-5 cursor-pointer transition-all duration-150"
         onclick="window.location='request_detail.php?id=<?= $t->getId() ?>'">
      
      <div class="flex items-start justify-between gap-4">
        <div class="space-y-2 flex-1">
          <div class="flex items-center gap-2 flex-wrap">
            <span class="mono text-xs" style="color:#4a4d60;">#<?=  $t->getId()  ?></span>
            <span class="skill-tag" onclick="event.stopPropagation()"><?= $t->skill->getName() ?></span>
            <span class="<?= $statusClass ?> text-xs font-medium px-2.5 py-0.5 rounded-full" onclick="event.stopPropagation()"><?= $statusLabel ?></span>
            <span class="text-xs ml-2" style="color:#6b6e85;">
              Posté par <strong class="text-gray-300"><?= $t->learner->getName() ?></strong> 
              <span class="mx-1.5" style="color:#4a4d60;">•</span> 
              <span class="mono text-gray-400"><?= $t->getDatePub() ?? 'Date inconnue' ?></span>
            </span>
          </div>
          
          <h3 class="font-semibold text-base text-white"><?= htmlspecialchars($t['titre']) ?></h3>
          
          <p class="text-sm text-gray-400 line-clamp-2 pt-1">
            <?= htmlspecialchars($t['description'] ?? 'Aucune description fournie.') ?>
          </p>
        </div>

        <div class="flex flex-col items-end justify-between h-full min-w-[140px] self-stretch pt-1">
          <?php if ($t['statut'] === 'EN_ATTENTE' && ($_SESSION['user_id'] ?? 0) !== ($t['id_student'] ?? -1)): ?>
          <form action="../scripts/assign_process.php" method="POST" onclick="event.stopPropagation()">
            <input type="hidden" name="ticket_id" value="<?= $t['id'] ?>"/>
            <button type="submit" class="text-xs px-3 py-2 rounded-xl font-semibold btn-primary text-white shadow-md flex items-center gap-1.5">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Accepter la demande
            </button>
          </form>
          <?php else: ?>
          <span class="text-xs font-mono" style="color:#4a4d60;">—</span>
          <?php endif; ?>
        </div>
      </div>

    </div>
    <?php endforeach; ?>
  </div>
</main>

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

<script>
  const notiToggleBtn = document.getElementById('noti-toggle-btn');
  const notiDropdown = document.getElementById('notification-dropdown');

  // Toggle notification menu
  notiToggleBtn.addEventListener('click', function(event) {
    event.stopPropagation();
    notiDropdown.classList.toggle('hidden');
  });

  // Close dropdown if user clicks anywhere else on the screen
  document.addEventListener('click', function() {
    if (!notiDropdown.classList.contains('hidden')) {
      notiDropdown.classList.add('hidden');
    }
  });
</script>

</body>
</html>