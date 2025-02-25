// Function to switch pages
function showPage(pageId) {
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => {
        page.style.display = 'none'; // Hide all pages
    });
    document.getElementById(pageId).style.display = 'block'; // Show the selected page
}

// Initialize users array
const users = [];

// Initialize contacts array
const contacts = [];

// Function to register a new user
function registerUser(event) {
    event.preventDefault(); // Prevent form submission

    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;

    // Check if user already exists
    const existingUser = users.find(user => user.email === email);
    if (existingUser) {
        alert('User already exists.');
        return;
    }

    // Add new user to the "database"
    users.push({ name, email, password });
    alert('Registration successful! You can now log in.');
    window.location.href = "login.php"; // Correctly navigate to login page
}

// Function to log in a user
function loginUser(event) {
    event.preventDefault(); // Prevent form submission

    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    // Check user credentials
    const user = users.find(user => user.email === email && user.password === password);
    if (user) {
        alert('Login successful!');
        showPage('contactManager'); // Show contact manager
        document.getElementById('loginForm').reset(); // Clear form
    } else {
        alert('Invalid email or password.');
    }
}

// Function to render contacts in the table
function renderContacts() {
    const tableBody = document.querySelector('#contactTable tbody');
    tableBody.innerHTML = ''; // Clear existing contacts

    contacts.forEach((contact, index) => {
        const row = document.createElement('tr');
        
        // Create an image element if an image exists
        const imageCell = contact.image ? `<img src="${contact.image}" alt="${contact.name}" style='width:50px;height:50px;' />` : 'No Image';
        
        row.innerHTML = `
            <td>${contact.name}</td>
            <td>${contact.email}</td>
            <td>${contact.phone}</td>
            <td>${contact.address || 'N/A'}</td> <!-- Display address if available -->
            <td>${imageCell}</td> <!-- Display image -->
            <td class='action-buttons'>
                <button onclick='editContact(${contact.id})'>Edit</button>
                <button onclick='deleteContact(${contact.id})'>Delete</button>
            </td>`;
        
        tableBody.appendChild(row);
    });
}

// Function to validate inputs
function validateInputs(email, phone) {
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.textContent = ''; // Clear previous error messages

    // Validate email format using a regular expression
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        errorMessage.textContent = 'Please enter a valid email address.';
        return false;
    }

    // Validate phone number
    if (!/^\d{10}$/.test(phone)) {
        errorMessage.textContent = 'Phone number must be 10 digits.';
        return false;
    }

    return true; // All validations passed
}

// Function to add a new contact
function addContact(event) {
    event.preventDefault(); // Prevent form submission

    const name = document.getElementById('name').value;
    const emailInput = document.getElementById('email').value; // Get the raw email input
    const email = emailInput.trim().toLowerCase(); // Convert email to lowercase

    // Check if the original email contains uppercase letters
    if (emailInput !== emailInput.toLowerCase()) {
        alert('Email must be in lowercase. It has been converted to lowercase.');
    }

    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value; // Get address input

    // Validate inputs
    if (!validateInputs(email, phone)) {
        return; // Stop if validation fails
    }

    // Handle image upload
    const imageInput = document.getElementById("imageUpload");
    let imageUrl = "";
    
    if (imageInput.files.length > 0) {
        const fileReader = new FileReader();
        fileReader.onloadend = function () {
            imageUrl = fileReader.result; // Get base64 string of uploaded image
            contacts.push({ name, email, phone, address, image: imageUrl }); // Add contact with image URL
            renderContacts(); // Update the contact list

            // Clear input fields
            document.getElementById("contactForm").reset();
        };
        fileReader.readAsDataURL(imageInput.files[0]); // Read uploaded file as data URL 
    } else {
        contacts.push({ name, email, phone, address }); // Add contact without image URL 
        renderContacts(); // Update the contact list

        // Clear input fields 
        document.getElementById("contactForm").reset();
    }
}

// Function to handle edit form submission
function handleEditForm(event) {
    event.preventDefault(); // Prevent form submission

    const id = document.getElementById('editId').value;
    const name = document.getElementById('editName').value;
    const emailInput = document.getElementById('editEmail').value;
    const email = emailInput.trim().toLowerCase();
    const phone = document.getElementById('editPhone').value;
    const address = document.getElementById('editAddress').value;

    // Validate inputs
    if (!validateInputs(email, phone)) {
        return; // Stop if validation fails
    }

    // Handle image upload
    const imageInput = document.getElementById("editImageUpload");
    let imageUrl = "";

    if (imageInput.files.length > 0) {
        const fileReader = new FileReader();
        fileReader.onloadend = function () {
            imageUrl = fileReader.result; // Get base64 string of uploaded image
            updateContact(id, { name, email, phone, address, image: imageUrl }); // Update contact with image URL
        };
        fileReader.readAsDataURL(imageInput.files[0]); // Read uploaded file as data URL 
    } else {
        updateContact(id, { name, email, phone, address }); // Update contact without image URL
    }
}

// Function to update a contact
function updateContact(id, updatedContact) {
    const contactIndex = contacts.findIndex(contact => contact.id === id);
    if (contactIndex !== -1) {
        contacts[contactIndex] = { ...contacts[contactIndex], ...updatedContact };
        renderContacts(); // Update the contact list
        alert('Contact updated successfully!');
        document.getElementById("editForm").reset(); // Clear form
        showPage('contactManager'); // Show contact manager
    } else {
        alert('Contact not found.');
    }
}

// Function to edit a contact
function editContact(id) {
    window.location.href = `edit.php?id=${id}`;
}

// Function to delete a contact
function deleteContact(id) {
    if (confirm('Are you sure you want to delete this contact?')) {
        fetch(`delete.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    location.reload();
                } else {
                    alert('Error deleting contact.');
                }
            })
            .catch(error => {
                alert('Error deleting contact.');
                console.error('Error:', error);
            });
    }
}

// Function to log out
function logout() {
    fetch('logout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'logout=true'
    })
    .then(response => {
        if (response.ok) {
            window.location.href = 'final.php'; // Navigate to final.php
        } else {
            alert('Logout failed.');
        }
    })
    .catch(error => {
        alert('Error logging out.');
        console.error('Error:', error);
    });
}

// Event listeners for form submissions 
document.getElementById("registerForm").addEventListener("submit", registerUser); 
document.getElementById("loginForm").addEventListener("submit", loginUser); 
document.getElementById("contactForm").addEventListener("submit", addContact);
document.getElementById("editForm").addEventListener("submit", handleEditForm);
document.getElementById("logoutButton").addEventListener("click", logout);

// Removed event listener for the dark mode toggle button