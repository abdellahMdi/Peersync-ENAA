<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PeerSync — Mon Profil</title>
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
    .skill-tag { display:inline-flex; align-items:center; gap:6px; background:#2a2d3e; color:#9a9db5; border:1px solid #3a3d50; font-size:12px; border-radius:8px; padding:5px 12px; cursor:pointer; transition:all 0.15s; }
    .skill-tag.mastered { background:#6c63ff18; color:#a5a0ff; border-color:#6c63ff44; }
    .skill-tag.learning { background:#f59e0b18; color:#f59e0b; border-color:#f59e0b44; }
    .skill-tag:hover { border-color:#6c63ff66; }
    .input-field { background:#0f1117; border:1px solid #2a2d3e; color:#e8e9f0; transition:border-color 0.2s; }
    .input-field:focus { outline:none; border-color:#6c63ff; }
    .input-field::placeholder { color:#4a4d60; }
    .btn-primary { background:#6c63ff; transition:background 0.2s; }
    .btn-primary:hover { background:#5a52e0; }
    .avatar { background: linear-gradient(135deg, #6c63ff, #a78bfa); }
    .stat-card { background:#0f1117; border:1px solid #2a2d3e22; border-radius:10px; padding:12px 16px; }
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
    <a href="dashboard.php" class="nav-link flex items-center gap-3 px-3 py-2 text-sm font-medium">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
      Dashboard
    </a>
    <a href="profil.php" class="nav-link active flex items-center gap-3 px-3 py-2 text-sm font-medium">
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
<main class="flex-1 ml-56 p-8">
  <div class="max-w-2xl">

    <?php if (isset($_GET['success'])): ?>
    <div class="mb-5 rounded-xl px-4 py-3 text-sm flex items-center gap-3" style="background:#10b98118;border:1px solid #10b98133;color:#34d399;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
      Compétences enregistrées avec succès.
    </div>
    <?php endif; ?>

    <!-- Profile header -->
    <div class="card rounded-2xl p-6 mb-6 flex items-center gap-6">
      <div class="avatar w-16 h-16 rounded-2xl flex items-center justify-center text-xl font-bold text-white flex-shrink-0">
        KM
      </div>
      <div class="flex-1">
        <h1 class="text-xl font-bold"><?= htmlspecialchars($_SESSION['nom'] ?? 'Khalid Moussaoui') ?></h1>
        <p class="text-sm mt-0.5" style="color:#9a9db5;"><?= htmlspecialchars($_SESSION['email'] ?? 'khalid.m@enaa.ma') ?></p>
        <div class="flex items-center gap-2 mt-2">
          <span class="text-xs px-2 py-0.5 rounded-md font-medium mono"
                style="background:#6c63ff18;color:#a5a0ff;border:1px solid #6c63ff33;">
            <?= htmlspecialchars($_SESSION['role'] ?? 'apprenant') ?>
          </span>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div class="stat-card text-center">
          <p class="text-2xl font-bold mono" style="color:#a5a0ff;">8</p>
          <p class="text-xs mt-0.5" style="color:#6b6e85;">demandes</p>
        </div>
        <div class="stat-card text-center">
          <p class="text-2xl font-bold mono" style="color:#34d399;">3</p>
          <p class="text-xs mt-0.5" style="color:#6b6e85;">tutorats</p>
        </div>
      </div>
    </div>

    <!-- Skills form -->
    <div class="card rounded-2xl p-6">
      <h2 class="font-semibold mb-1">Mes compétences</h2>
      <p class="text-sm mb-5" style="color:#6b6e85;">Indique les technologies que tu maîtrises et celles que tu travailles.</p>

      <form action="../scripts/skills_process.php" method="POST" id="skills-form">

        <?php
        $allSkills = ['PHP','JavaScript','SQL','HTML','CSS','POO','Git','TypeScript','React','MySQL'];
        $userSkills = $userSkills ?? [
          'PHP'        => 'a_travailler',
          'JavaScript' => 'maitrisee',
          'SQL'        => 'maitrisee',
          'CSS'        => 'a_travailler',
        ];
        ?>

        <div class="flex flex-wrap gap-2 mb-6">
          <?php foreach ($allSkills as $skill):
            $state = $userSkills[$skill] ?? null;
            $cls = match($state) { 'maitrisee' => 'mastered', 'a_travailler' => 'learning', default => '' };
            $dot = match($state) { 'maitrisee' => '✓', 'a_travailler' => '~', default => '+' };
          ?>
          <button type="button"
                  class="skill-tag <?= $cls ?>"
                  data-skill="<?= $skill ?>"
                  data-state="<?= $state ?? 'none' ?>"
                  onclick="cycleSkill(this)">
            <span class="dot-icon text-xs"><?= $dot ?></span>
            <span><?= $skill ?></span>
          </button>
          <?php endforeach; ?>
        </div>

        <!-- Legend -->
        <div class="flex items-center gap-4 text-xs mb-5" style="color:#6b6e85;">
          <span class="flex items-center gap-1.5"><span style="color:#a5a0ff;">✓</span> Maîtrisée</span>
          <span class="flex items-center gap-1.5"><span style="color:#f59e0b;">~</span> À travailler</span>
          <span class="flex items-center gap-1.5"><span style="color:#4a4d60;">+</span> Non sélectionnée</span>
        </div>

        <!-- Hidden inputs populated by JS -->
        <div id="hidden-inputs"></div>

        <button type="submit" class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold text-white">
          Enregistrer mes compétences
        </button>
      </form>
    </div>

  </div>
</main>

<script>
const states = ['none','maitrisee','a_travailler'];
const labels = { none:'+', maitrisee:'✓', a_travailler:'~' };
const classes = { none:'', maitrisee:'mastered', learning:'learning', a_travailler:'learning' };

function cycleSkill(btn) {
  const cur = btn.dataset.state;
  const next = states[(states.indexOf(cur)+1) % states.length];
  btn.dataset.state = next;
  btn.querySelector('.dot-icon').textContent = labels[next];
  btn.classList.remove('mastered','learning');
  if (next === 'maitrisee') btn.classList.add('mastered');
  if (next === 'a_travailler') btn.classList.add('learning');
  updateHiddenInputs();
}

function updateHiddenInputs() {
  const container = document.getElementById('hidden-inputs');
  container.innerHTML = '';
  document.querySelectorAll('[data-skill]').forEach(btn => {
    if (btn.dataset.state !== 'none') {
      const inp = document.createElement('input');
      inp.type = 'hidden';
      inp.name = 'skills[' + btn.dataset.skill + ']';
      inp.value = btn.dataset.state;
      container.appendChild(inp);
    }
  });
}

updateHiddenInputs();
</script>

</body>
</html>
