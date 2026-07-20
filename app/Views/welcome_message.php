<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money — Votre espace de paiement</title>
    <meta name="description" content="Une plateforme moderne pour gérer vos opérations de dépôt, retrait et suivi de solde.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <style {csp-style-nonce}>
        :root {
            color-scheme: light;
            --ink-900: #10231F;
            --ink-800: #16302A;
            --brand-600: #17795A;
            --brand-100: #DCEEE4;
            --amber-500: #E2A63A;
            --amber-100: #FBEBD1;
            --paper-000: #FFFFFF;
            --paper-050: #F2F3EE;
            --paper-100: #E9EBE2;
            --line-200: #DEE1D8;
            --text-900: #16211E;
            --text-600: #55645E;
            --radius-lg: 24px;
            --radius-md: 16px;
            --space-3: 12px;
            --space-4: 16px;
            --space-5: 24px;
            --space-6: 32px;
            --space-7: 48px;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Inter, 'Segoe UI', system-ui, sans-serif;
            color: var(--text-900);
            background: linear-gradient(135deg, #f7f8f2 0%, #eef2eb 100%);
        }
        a { color: inherit; text-decoration: none; }
        .landing-shell {
            min-height: 100vh;
            padding: var(--space-6);
        }
        .landing-card {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(16px);
            border: 1px solid var(--line-200);
            border-radius: 32px;
            box-shadow: 0 24px 80px rgba(16, 35, 31, .12);
            overflow: hidden;
        }
        .landing-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: var(--space-5) var(--space-6);
            border-bottom: 1px solid var(--line-200);
        }
        .brand {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--ink-900);
        }
        .brand-mark {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--brand-600), var(--ink-800));
            color: white;
            font-weight: 700;
        }
        .landing-nav {
            display: flex;
            gap: var(--space-3);
            align-items: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            padding: .8rem 1rem;
            border-radius: 999px;
            font-weight: 600;
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary {
            background: var(--brand-600);
            color: white;
            box-shadow: 0 12px 24px rgba(23, 121, 90, .18);
        }
        .btn-ghost {
            background: var(--paper-050);
            color: var(--ink-900);
        }
        .hero {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            gap: var(--space-6);
            padding: var(--space-7) var(--space-6);
            align-items: center;
        }
        .hero h1 {
            font-size: clamp(2rem, 3.2vw, 3rem);
            line-height: 1.1;
            margin: 0 0 var(--space-4);
            color: var(--ink-900);
        }
        .hero p {
            font-size: 1.05rem;
            color: var(--text-600);
            margin: 0 0 var(--space-5);
            max-width: 58ch;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-3);
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .45rem .7rem;
            border-radius: 999px;
            background: var(--brand-100);
            color: var(--brand-600);
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: var(--space-4);
        }
        .hero-panel {
            background: linear-gradient(145deg, var(--ink-800), var(--ink-900));
            color: white;
            border-radius: var(--radius-lg);
            padding: var(--space-5);
            box-shadow: 0 16px 40px rgba(16, 35, 31, .2);
        }
        .hero-panel .panel-title { font-size: 1rem; color: #dfe8e2; margin-bottom: var(--space-3); }
        .hero-panel .stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .9rem 0;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .hero-panel .stat:last-child { border-bottom: 0; }
        .hero-panel .value { font-weight: 700; color: var(--amber-500); }
        .features {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: var(--space-4);
            padding: 0 var(--space-6) var(--space-6);
        }
        .feature-card {
            background: var(--paper-000);
            border: 1px solid var(--line-200);
            border-radius: var(--radius-md);
            padding: var(--space-5);
        }
        .feature-card h2 { margin: 0 0 .65rem; font-size: 1.05rem; }
        .feature-card p { margin: 0; color: var(--text-600); }
        .feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            margin-bottom: var(--space-3);
            background: var(--amber-100);
            color: var(--amber-500);
            font-size: 1.15rem;
        }
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; }
            .features { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .landing-shell { padding: var(--space-4); }
            .landing-header, .hero, .features { padding-left: var(--space-4); padding-right: var(--space-4); }
            .landing-header { flex-direction: column; align-items: flex-start; gap: var(--space-3); }
        }
    </style>
</head>
<body>
    <div class="landing-shell">
        <div class="landing-card">
            <header class="landing-header">
                <a class="brand" href="<?= site_url('/') ?>">
                    <span class="brand-mark">M</span>
                    <span>Mobile Money</span>
                </a>
                <nav class="landing-nav">
                    <a class="btn btn-ghost" href="<?= site_url('client/login') ?>">Connexion client</a>
                    <a class="btn btn-primary" href="<?= site_url('admin') ?>">Accéder à l’administration</a>
                </nav>
            </header>

            <section class="hero">
                <div>
                    <div class="eyebrow">● Plateforme de services financiers</div>
                    <h1>Un espace web simple pour piloter vos opérations au quotidien.</h1>
                    <p>Mobile Money transforme vos activités de dépôt, retrait et suivi de solde en une expérience claire, rapide et professionnelle, aussi bien pour les clients que pour les équipes de gestion.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="<?= site_url('client/login') ?>">Ouvrir mon espace</a>
                        <a class="btn btn-ghost" href="<?= site_url('admin') ?>">Découvrir l’admin</a>
                    </div>
                </div>
                <div class="hero-panel">
                    <div class="panel-title">Vue d’ensemble</div>
                    <div class="stat">
                        <span>Clients actifs</span>
                        <span class="value">+1 200</span>
                    </div>
                    <div class="stat">
                        <span>Opérations du jour</span>
                        <span class="value">84</span>
                    </div>
                    <div class="stat">
                        <span>Disponibilité</span>
                        <span class="value">99.9%</span>
                    </div>
                </div>
            </section>

            <section class="features">
                <article class="feature-card">
                    <div class="feature-icon">↗</div>
                    <h2>Suivi instantané</h2>
                    <p>Visualisez votre solde, vos mouvements et votre historique en quelques clics.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">✓</div>
                    <h2>Opérations sécurisées</h2>
                    <p>Une interface pensée pour réduire les erreurs et rendre chaque transaction plus fluide.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">◧</div>
                    <h2>Administration claire</h2>
                    <p>Les équipes disposent d’un back-office structuré pour piloter les paramètres et les suivis.</p>
                </article>
            </section>
        </div>
    </div>
</body>
</html>
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>

<!-- -->

</body>
</html>
