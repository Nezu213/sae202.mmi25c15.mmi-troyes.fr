/* ==========================================================================
   NIGHT CASINO — script.js (Version Lampe Torche & Sécurité Admin)
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {

    // SÉCURITÉ ADMIN : Si on est sur l'admin, on stoppe TOUT ici (Pas de lampe, pas de glitch)
    if (window.nightCasinoScriptBlock === true) {
        return; 
    }

    // 1. EFFET LAMPE TORCHE (Projecteur dynamique sans écraser le fond)
    // On injecte un masque invisible par-dessus le fond qui va simuler la lumière
    const styleLampe = document.createElement('style');
    styleLampe.innerHTML = `
        main {
            position: relative;
            z-index: 1;
        }
        main::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border-radius: inherit;
            pointer-events: none;
            z-index: -1;
            mix-blend-mode: screen; /* S'additionne au fond existant pour l'illuminer */
            opacity: 0.8;
            transition: background 0.05s ease;
        }
    `;
    document.head.appendChild(styleLampe);

    document.addEventListener('mousemove', (e) => {
        const main = document.querySelector('main');
        if (main) {
            const rect = main.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            // Projette une lueur douce bordeaux/or sans modifier la couleur de ton CSS de base
            main.style.setProperty('--x', `${x}px`);
            main.style.setProperty('--y', `${y}px`);
            
            const styleElement = main.style;
            // Utilise un dégradé radial qui éclaire doucement le calque existant
            const avantElement = main.querySelector('main::before') || main;
            avantElement.style.backgroundImage = `radial-gradient(circle 220px at ${x}px ${y}px, rgba(236, 212, 153, 0.15) 0%, rgba(122, 21, 16, 0.2) 50%, rgba(0, 0, 0, 0) 100%)`;
        }
    });

    // 2. FUN — EFFET ÉTINCELLES DORÉES AU CLIC (Ambiance Casino)
    document.addEventListener('click', (e) => {
        const particule = document.createElement('div');
        particule.style.position = 'fixed';
        particule.style.left = `${e.clientX - 10}px`;
        particule.style.top = `${e.clientY - 10}px`;
        particule.style.width = '20px';
        particule.style.height = '20px';
        particule.style.border = '2px solid #ecd499';
        particule.style.borderRadius = '50%';
        particule.style.pointerEvents = 'none';
        particule.style.transition = 'transform 0.5s ease-out, opacity 0.5s ease-out';
        particule.style.zIndex = '99999';
        
        document.body.appendChild(particule);

        setTimeout(() => {
            particule.style.transform = 'scale(2.5)';
            particule.style.opacity = '0';
        }, 10);

        setTimeout(() => { particule.remove(); }, 500);
    });

    // 4. EASTER EGG — CODE SECRET "CASINO" (Disparition automatique en 3s)
    let codeSaisi = "";
    const codeSecret = "CASINO";

    document.addEventListener('keydown', (e) => {
        codeSaisi += e.key.toUpperCase();
        codeSaisi = codeSaisi.slice(-codeSecret.length);

        if (codeSaisi === codeSecret) {
            // Flash lumineux or
            document.body.style.transition = 'filter 0.2s ease';
            document.body.style.filter = 'brightness(1.8) sepia(0.5) hue-rotate(10deg)';
            
            // Notification classique temporaire
            const alerte = document.createElement('div');
            alerte.innerText = " SYSTÈME PIRATÉ : ACCÈS JEU DE DUPE ACCORDÉ ";
            alerte.style.position = 'fixed';
            alerte.style.top = '20px';
            alerte.style.left = '50%';
            alerte.style.transform = 'translateX(-50%)';
            alerte.style.background = '#7a1510';
            alerte.style.color = '#ecd499';
            alerte.style.border = '2px solid #ecd499';
            alerte.style.padding = '15px 30px';
            alerte.style.fontFamily = "'Cinzel Decorative', serif";
            alerte.style.zIndex = '100000';
            alerte.style.borderRadius = '4px';
            alerte.style.boxShadow = '0 0 20px rgba(236,212,153,0.6)';
            alerte.style.transition = 'opacity 0.5s ease';
            
            document.body.appendChild(alerte);

            // Remise à la normale après le flash
            setTimeout(() => {
                document.body.style.filter = 'none';
            }, 300);

            // Disparition et suppression après 3 secondes
            setTimeout(() => {
                alerte.style.opacity = '0';
                setTimeout(() => alerte.remove(), 500);
            }, 3000);
            
            codeSaisi = ""; // Reset du mot
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const hamburgerBtn = document.querySelector('.hamburger-btn');
    const navContainer = document.querySelector('.nav-container');

    if (hamburgerBtn && navContainer) {
        hamburgerBtn.addEventListener('click', function() {
            navContainer.classList.toggle('active');
            
            /* Optionnel : animation en X du bouton hamburger */
            hamburgerBtn.classList.toggle('open');
        });
    }
});