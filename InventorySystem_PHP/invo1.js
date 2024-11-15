// Function to show sections and load product content
function showSection(sectionId) {
    var sections = document.querySelectorAll('section');
    sections.forEach(function (section) {
        section.style.display = 'none';
    });
    document.getElementById(sectionId).style.display = 'block';
    if (sectionId === 'productsSection') {
        loadProductContent();
    }
}

// Function to load product content
function loadProductContent() {
    console.log('Loading product content...');
    $.ajax({
        url: 'product1.php', 
        method: 'GET',
        success: function (data) {
            console.log('Product content loaded successfully');
            $('#productsSection').html(data); 
        },
        error: function (error) {
            console.error('Failed to load product content:', error);
        }
    });
}

// Function to open the modal
function openModal() {
    document.getElementById('loginModal').style.display = 'flex';
}

// Function to close the modal and redirect to index.php
function closeModalAndRedirect() {
    document.getElementById('loginModal').style.display = 'none'; 
    window.location.href = 'index.php'; 
}

// Set the default section to be displayed
document.addEventListener('DOMContentLoaded', function () {
    showSection('homeSection'); 

    
    document.querySelector('a[href="#s"]').addEventListener('click', function (event) {
        event.preventDefault();
        openModal();
    });
});
