<footer>
    <img src="images/all_agency.png" alt="Logo All Agency" class="logo-agence">
    <p>© 2026 - Tous droits réservés. Projet IUT - SAE 202</p>
    <div class="footer-liens">
    <a href="mentions_legales.php">Mentions Légales</a>
    </div>
</footer>

<script>
window.addEventListener('load', function() {
    // On vérifie si le body n'a PAS la classe 'home'
    if (!document.body.classList.contains('home')) {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            // On attend un petit peu pour que l'effet soit visible
            setTimeout(function() {
                preloader.classList.add('hidden');
            }, 500); // 500ms de délai
        }
    }
});
</script>

</body>
</html>