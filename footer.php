<footer class="site-footer" id="kontak">
    <div class="footer-inner">
        <div class="footer-col">
            <div class="footer-logo-row">
                <span class="footer-logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="12" cy="8" r="3.2"/>
                        <path d="M4 20c0-3.5 3.5-6 8-6s8 2.5 8 6"/>
                    </svg>
                </span>
            </div>
            <h4>Identitas Sekolah</h4>
            <p><?= htmlspecialchars($identitas['alamat'] ?? '') ?></p>
            <p>Telepon: <?= htmlspecialchars($identitas['telepon'] ?? '') ?></p>
            <p>Email: <?= htmlspecialchars($identitas['email'] ?? '') ?></p>
        </div>

        <div class="footer-col">
            <h4>Informasi Sekolah</h4>
            <a href="index.php#profile">Profil Sekolah</a>
            <a href="index.php#artikel">Berita &amp; Artikel</a>
            <a href="index.php#artikel">Galeri Kegiatan</a>
            <a href="#">PPDB Online</a>
        </div>

        <div class="footer-col">
            <h4>Layanan</h4>
            <a href="index.php#kontak">Contact Kami</a>
            <a href="#">Pengummuman</a>
            <a href="#">Jadwal Kegiatan</a>
            <a href="#">Peta Lokasi</a>
            <a href="#">FAQ</a>
        </div>

       <div class="footer-col footer-map">
    <div class="map-wrapper">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126829.29180934731!2d106.70948906850215!3d-6.595186739255517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5b7ad0f824b%3A0x4c71fd1b0b8ae76d!2sKota%20Bogor%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1783993832235!5m2!1sid!2sid" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" 
            style="width:100%;height:100%;border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
</div>

    <div class="footer-bottom">
        <span>Instagram: <?= htmlspecialchars($identitas['instagram'] ?? '-') ?></span>
        <span>WhatsApp: <?= htmlspecialchars($identitas['whatsapp'] ?? '-') ?></span>
        <span>Email: <?= htmlspecialchars($identitas['email'] ?? '-') ?></span>
    </div>
</footer>

<script src="js/script.js"></script>
</body>
</html>
