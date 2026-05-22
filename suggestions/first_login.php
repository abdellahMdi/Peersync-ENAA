<?php
session_start();
require_once __DIR__ . "/../Repositories/UserRepository.php";
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PeerSync — Configuration Initiale</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Sora', sans-serif; background: #0f1117; color: #e8e9f0; }
    .mono { font-family: 'JetBrains Mono', monospace; }
    .card { background: #1a1d27; border: 1px solid #2a2d3e; }
    .skill-tag { display: inline-flex; align-items: center; gap: 8px; background: #2a2d3e; color: #9a9db5; border: 1px solid #3a3d50; font-size: 13px; border-radius: 10px; padding: 8px 16px; cursor: pointer; transition: all 0.15s; }
    .skill-tag:hover { border-color: #6c63ff66; background: #2a2d3e88; }
    .skill-tag.mastered { background: #6c63ff18; color: #a5a0ff; border-color: #6c63ff44; }
    .skill-tag.learning { background: #f59e0b18; color: #f59e0b; border-color: #f59e0b44; }
    
    .btn-primary { background: #6c63ff; transition: background 0.2s; }
    .btn-primary:hover { background: #5a52e0; }
  </style>
</head>
<body class="min-h-screen flex flex-col justify-between py-12 px-4 relative">
  <div class="fixed inset-0 opacity-5 pointer-events-none" style="background-image: linear-gradient(#6c63ff 1px, transparent 1px), linear-gradient(90deg, #6c63ff 1px, transparent 1px); background-size: 40px 40px;"></div>
  <div class="w-full max-w-2xl mx-auto my-auto relative z-10">
    <div class="text-center mb-8">
      <h1 class="text-xl font-bold text-white mb-1">Bienvenue, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Apprenant') ?> !</h1>
      <p class="text-xs text-gray-400">Clique sur les technologies pour définir ton profil d'entraide.</p>
    </div>
    <div class="card rounded-2xl p-6 space-y-6">
      <div class="flex items-center justify-center gap-6 text-xs pb-4 border-b border-[#2a2d3e33]" style="color:#6b6e85;">
        <span class="flex items-center gap-1.5"><span class="text-indigo-400 font-bold">✓</span> maîtrisées</span>
        <span class="flex items-center gap-1.5"><span class="text-amber-400 font-bold">~</span> à travailler</span>
        <span class="flex items-center gap-1.5"><span class="text-gray-500 font-bold">+</span> Non sélectionné</span>
      </div>
      <form action="../scripts/onboarding_process.php" method="POST" id="onboarding-form">
        <div class="flex flex-wrap justify-center gap-3 mb-6">
          <?php 
          $technos = getAllSkills();
          foreach ($technos as $t): 
          ?>
            <button type="button"
                    class="skill-tag"
                    data-skill="<?= $t->id ?>"
                    data-state="none"
                    onclick="cycleSkill(this)">
              <span class="state-icon text-xs font-bold">+</span>
              <span><?= $t->name ?></span>
            </button>
          <?php endforeach; ?>
        </div>
        <div id="hidden-inputs"></div>
        <button type="submit" class="btn-primary w-full py-3 rounded-xl text-sm font-semibold text-white shadow-lg">
          Enregistrer et accéder au Dashboard →
        </button>
      </form>
    </div>

  </div>
<script>
  // Cycle des états : neutre (+) -> maîtrisé (✓) -> à travailler (~) -> retour au début
  const states = ['none','maîtrisées', 'à_travailler'];
  const icons = { none: '+',maîtrisées: '✓', 'à_travailler': '~' };
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
  function cycleSkill(btn) {
    const currentState = btn.dataset.state;
    const nextState = states[(states.indexOf(currentState) + 1) % states.length];
    
    btn.dataset.state = nextState;
    btn.querySelector('.state-icon').textContent = icons[nextState];
    btn.classList.remove('maîtrisées', 'à_travailler');
    if (nextState === 'maîtrisées') btn.classList.add('maîtrisées');
    if (nextState === 'à_travailler') btn.classList.add('à_travailler');
    updateHiddenInputs();
  }
  </script>
</body>
</html>