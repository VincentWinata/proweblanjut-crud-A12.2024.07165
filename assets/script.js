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

// Category Filter for Public Storefront
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.category-filter-tabs .nav-link');
    const items = document.querySelectorAll('.product-item');

    if(tabs.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs, add to the clicked one
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                // Show/hide items based on selected category
                items.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }
});