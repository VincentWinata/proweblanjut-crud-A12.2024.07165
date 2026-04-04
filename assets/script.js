// Image Preview Feature for Admin Forms
const gambarInput = document.getElementById('gambarInput');
if (gambarInput) {
    gambarInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
}

// Live Search for Admin Data Table
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        let filter = searchInput.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBarang tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. HERO BANNER: SHRINK & PERFECT CENTER MATH ---
    const heroSharp = document.querySelector('.hero-bg-sharp');
    const heroTextWrapper = document.getElementById('heroTextContainer');
    const heroTitle = document.getElementById('heroTitle');
    const heroDesc = document.getElementById('heroDesc');
    const heroBtn = document.getElementById('heroBtn');
    
    // Variabel untuk menyimpan jarak pasti ke tengah
    let maxMoveX = 0;

    function calculateCenterDistance() {
        if(heroTextWrapper && heroTitle) {
            // Jarak ke tengah = (Lebar Kontainer dibagi 2) dikurangi (Lebar Judul dibagi 2)
            maxMoveX = (heroTextWrapper.offsetWidth / 2) - (heroTitle.offsetWidth / 2);
        }
    }

    // Hitung saat web dibuka
    calculateCenterDistance();
    // Hitung ulang jika layar di-resize (misal HP diputar)
    window.addEventListener('resize', calculateCenterDistance);

    if(heroSharp && heroTitle && heroBtn) {
        window.addEventListener('scroll', function() {
            let scrollY = window.scrollY;

            if (scrollY < window.innerHeight) {
                
                // Matikan animasi pembuka web agar JS bisa berjalan mulus
                heroSharp.style.animation = 'none';
                heroTitle.style.animation = 'none';
                if(heroDesc) heroDesc.style.animation = 'none';
                heroBtn.style.animation = 'none';

                // PASTIKAN Judul tidak menghilang!
                heroTitle.style.opacity = '1';

                // 1. Gambar Mengecil ke skala 0.7
                let scaleValue = Math.max(0.7, 1 - (scrollY / 800)); 
                heroSharp.style.transform = `scale(${scaleValue})`;

                // 2. Kunci Progress di Angka 1 (Mencegah Kebablasan)
                let maxScroll = 300; // Pada jarak scroll 300px, semua animasi berhenti
                let progress = Math.min(scrollY / maxScroll, 1); 
                
                // --- JUDUL: Berhenti PRESISI di Tengah ---
                let moveTitleX = progress * maxMoveX;
                heroTitle.style.transform = `translateX(${Math.max(0, moveTitleX)}px)`;

                // --- DESKRIPSI & TOMBOL: Ke kanan sedikit & Pudar ---
                // Dibuat hilang lebih cepat (selesai di progress 0.6)
                let fadeOut = Math.max(0, 1 - (progress * 1.5)); 
                let moveBtnX = progress * 40; // Bergeser 40px saja agar aman dan tidak memanjangkan layar
                
                if (heroDesc) {
                    heroDesc.style.opacity = fadeOut;
                    heroDesc.style.transform = `translateX(${moveBtnX}px)`;
                }
                
                heroBtn.style.opacity = fadeOut;
                heroBtn.style.transform = `translateX(${moveBtnX}px)`;

                // Nonaktifkan klik tombol saat sudah pudar
                if (fadeOut <= 0) {
                    heroBtn.style.pointerEvents = 'none';
                } else {
                    heroBtn.style.pointerEvents = 'auto';
                }
            }
        });
    }

    // --- 2. CAR DRIVE-IN ANIMATION SYSTEM ---
    const carItems = document.querySelectorAll('.cluster-item');
    window.carAnimationTimeouts = []; 

    function playCarAnimations(itemsArray) {
        window.carAnimationTimeouts.forEach(t => clearTimeout(t));
        window.carAnimationTimeouts = [];

        itemsArray.forEach(item => {
            item.classList.remove('drive-in');
        });

        void document.body.offsetWidth;

        let visibleIndex = 0;
        itemsArray.forEach(item => {
            if (item.style.display !== 'none') {
                let timeoutId = setTimeout(() => {
                    item.classList.add('drive-in');
                }, visibleIndex * 150 + 50); 
                
                window.carAnimationTimeouts.push(timeoutId);
                visibleIndex++;
            }
        });
    }

    if(carItems.length > 0) {
        let hasPlayedInitial = false;
        const carObserver = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting && !hasPlayedInitial) {
                hasPlayedInitial = true; 
                playCarAnimations(carItems);
            }
        }, { threshold: 0.1 }); 

        const gridElement = document.getElementById('katalogGrid');
        if(gridElement) carObserver.observe(gridElement);
    }

    // --- 3. CATEGORY FILTER ---
    const tabs = document.querySelectorAll('.category-filter-tabs .nav-link');
    
    if(tabs.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                carItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });

                playCarAnimations(carItems);
            });
        });
    }
});