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
    
    // --- 1. MULTI-BANNER DYNAMIC SCROLL ANIMATION ---
    const banners = document.querySelectorAll('.dynamic-banner');
    
    // Hitung jarak ke tengah untuk setiap banner
    function calculateCenterDistances() {
        banners.forEach(banner => {
            const wrapper = banner.querySelector('.banner-text-wrapper');
            const title = banner.querySelector('.banner-title');
            if(wrapper && title) {
                // Jarak ke tengah = Setengah lebar container dikurangi setengah lebar judul
                banner.dataset.maxMoveX = (wrapper.offsetWidth / 2) - (title.offsetWidth / 2);
            }
        });
    }

    calculateCenterDistances();
    window.addEventListener('resize', calculateCenterDistances);

   window.addEventListener('scroll', function() {
    let windowHeight = window.innerHeight;

    banners.forEach((banner, index) => {
        let rect = banner.getBoundingClientRect();
        
        // Cek jika banner mulai terlihat di layar
        if (rect.top < windowHeight && rect.bottom > 0) {
            const sharpImg = banner.querySelector('.banner-bg-sharp');
            const title = banner.querySelector('.banner-title');
            const desc = banner.querySelector('.banner-subtitle');
            const btn = banner.querySelector('.banner-btn');
            const maxMoveToCenter = parseFloat(banner.dataset.maxMoveX || 0);

            // 1. Logika ENTRANCE (Dari Tengah ke Kiri)
            // Dihitung berdasarkan posisi banner terhadap bawah layar
            let entranceProgress = Math.min(Math.max((windowHeight - rect.top) / (windowHeight * 0.6), 0), 1);
            
            // Teks meluncur dari 25vw ke 0
            let currentEntranceX = 25 - (entranceProgress * 25);
            
            // 2. Logika EXIT/PARALLAX (Dari Kiri ke Tengah/Mengecil)
            // Hanya aktif jika banner sudah mulai menabrak bagian atas layar (60px)
            let exitProgress = 0;
            let bannerTopHit = rect.top - 60; 
            if (bannerTopHit < 0) {
                exitProgress = Math.min(Math.abs(bannerTopHit) / 250, 1);
            }

            // Jalankan Animasi
            if(sharpImg) {
                sharpImg.style.animation = 'none';
                let scaleValue = 1 - (exitProgress * 0.3); // Mengecil ke 0.7
                sharpImg.style.transform = `scale(${scaleValue})`;
            }

            if(title) {
                title.style.animation = 'none';
                title.style.opacity = entranceProgress;
                
                // Gabungkan Entrance (meluncur ke kiri) dan Exit (bergerak ke tengah lagi)
                let finalX = 0;
                if (exitProgress > 0) {
                    finalX = exitProgress * maxMoveToCenter; // Gerak ke tengah saat scroll lanjut
                } else {
                    finalX = currentEntranceX + "vw"; // Meluncur dari tengah ke kiri saat baru muncul
                }
                
                // Gunakan satuan yang benar
                title.style.transform = (exitProgress > 0) ? `translateX(${finalX}px)` : `translateX(${finalX})`;
            }

            // Deskripsi & Tombol (Hanya pudar saat exit)
            let fadeOut = entranceProgress * (1 - exitProgress * 1.5);
            let moveExtra = exitProgress * 120;

            [desc, btn].forEach(el => {
                if(el) {
                    el.style.animation = 'none';
                    el.style.opacity = Math.max(0, fadeOut);
                    el.style.transform = (exitProgress > 0) 
                        ? `translateX(${moveExtra}px)` 
                        : `translateX(${currentEntranceX}vw)`;
                }
            });
        }
    });
});

    // --- 2. PARKING AREA: TWO-WAY SCROLL ANIMATION ---
    const parkingSection = document.getElementById('parkingAreaSection');
    const parkingNav = document.getElementById('parkingNav');
    const parkingBtnWrapper = document.getElementById('parkingBtnWrapper');
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

    if(parkingSection) {
        const parkingObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if(parkingNav) parkingNav.classList.add('is-visible');
                    if(parkingBtnWrapper) parkingBtnWrapper.classList.add('is-visible');
                    playCarAnimations(carItems);
                } else {
                    if(parkingNav) parkingNav.classList.remove('is-visible');
                    if(parkingBtnWrapper) parkingBtnWrapper.classList.remove('is-visible');
                    window.carAnimationTimeouts.forEach(t => clearTimeout(t));
                    carItems.forEach(item => {
                        item.classList.remove('drive-in');
                    });
                }
            });
        }, { threshold: 0.15 }); 

        parkingObserver.observe(parkingSection);
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