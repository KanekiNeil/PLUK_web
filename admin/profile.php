<?php

include_once "../php/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Sample user data - replace with database query
$user_data = array(
    "user_id" => 1,
    "user_name" => "Levi De Guzman",
    "user_role" => "Junior Unit Manager",
    "email" => "levi.deguzman@alphaquila.com",
    "phone" => "+63 9171234567",
    "department" => "Sales & Marketing",
    "hire_date" => "2023-06-15",
    "profile_picture" => "../assets/logo.jpg"
);

$user_name = $user_data['user_name'];
$user_role = $user_data['user_role'];
$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="../style/dashboard.css">
<link rel="stylesheet" href="../style/profile.css">
<title>User Profile</title>
</head>

<body>

<!-- HEADER -->
<?php include "../components/header.php"; ?>

<!-- PROFILE CONTENT -->
<div class="profile-page-wrapper">

    <!-- MAIN PROFILE CARD -->
    <div class="profile-card">

        <!-- PROFILE HEADER WITH AVATAR -->
        <div class="profile-header-section">
            <div class="profile-avatar-section">
                <div class="profile-avatar-large" onclick="document.getElementById('photoInput').click()">
                    <img id="profileImage" src="<?= htmlspecialchars($user_data['profile_picture']) ?>" alt="Profile Picture" style="display: none;">
                    <span id="avatarInitials"><?= $initials ?></span>
                    <input type="file" id="photoInput" accept="image/*" style="display: none;" onchange="handlePhotoChange(event)">
                </div>
                <div class="profile-header-info">
                    <h1><?= htmlspecialchars($user_data['user_name']) ?></h1>
                    <p class="job-title"><?= htmlspecialchars($user_data['user_role']) ?></p>
                    <p class="company">ALPHA AQUILA • Financial Advisory</p>
                </div>
                <div class="profile-actions">
                    <button class="edit-button" id="editBtn" onclick="toggleEditMode()">
                        <span class="material-icons" style="font-size: 18px;">edit</span>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- STATS SECTION -->
        <div class="profile-sections">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">2.5K</div>
                    <div class="stat-label">Clients Served</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">98%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">3Y+</div>
                    <div class="stat-label">Experience</div>
                </div>
            </div>

            <!-- PERSONAL INFORMATION SECTION -->
            <div class="info-section">
                <div class="section-header">
                    <span class="material-icons">person</span>
                    <h2 class="section-title">Personal Information</h2>
                </div>
                
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Full Name</span>
                        <span class="info-value info-display" id="displayName"><?= htmlspecialchars($user_data['user_name']) ?></span>
                        <input type="text" class="form-input edit-field" id="inputName" value="<?= htmlspecialchars($user_data['user_name']) ?>">
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <span class="info-value info-display" id="displayEmail"><?= htmlspecialchars($user_data['email']) ?></span>
                        <input type="email" class="form-input edit-field" id="inputEmail" value="<?= htmlspecialchars($user_data['email']) ?>">
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Phone Number</span>
                        <span class="info-value info-display" id="displayPhone"><?= htmlspecialchars($user_data['phone']) ?></span>
                        <input type="tel" class="form-input edit-field" id="inputPhone" value="<?= htmlspecialchars($user_data['phone']) ?>">
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Department</span>
                        <span class="info-value info-display" id="displayDept"><?= htmlspecialchars($user_data['department']) ?></span>
                        <input type="text" class="form-input edit-field" id="inputDept" value="<?= htmlspecialchars($user_data['department']) ?>">
                    </div>
                </div>
            </div>

            <!-- PROFESSIONAL INFORMATION SECTION -->
            <div class="info-section">
                <div class="section-header">
                    <span class="material-icons">work</span>
                    <h2 class="section-title">Professional Information</h2>
                </div>
                
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Job Title</span>
                        <span class="info-value info-display" id="displayRole"><?= htmlspecialchars($user_data['user_role']) ?></span>
                        <input type="text" class="form-input edit-field" id="inputRole" value="<?= htmlspecialchars($user_data['user_role']) ?>">
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Hire Date</span>
                        <span class="info-value info-display" id="displayHireDate"><?= date("F d, Y", strtotime($user_data['hire_date'])) ?></span>
                        <input type="date" class="form-input edit-field" id="inputHireDate" value="<?= $user_data['hire_date'] ?>">
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Employee ID</span>
                        <span class="info-value info-display"><?= htmlspecialchars($user_data['user_id']) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Company</span>
                        <span class="info-value info-display">ALPHA AQUILA</span>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="action-buttons" id="actionButtons">
                <button class="save-button" onclick="saveProfile()">
                    <span class="material-icons" style="vertical-align: middle; margin-right: 5px;">save</span>
                    Save Changes
                </button>
                <button class="cancel-button" onclick="cancelEdit()">Cancel</button>
            </div>
        </div>

    </div>

</div>

<script>

function toggleEditMode() {
    const editBtn = document.getElementById('editBtn');
    const actionButtons = document.getElementById('actionButtons');
    const displayFields = document.querySelectorAll('.info-display');
    const editFields = document.querySelectorAll('.form-input.edit-field');
    const avatar = document.querySelector('.profile-avatar-large');
    
    // Toggle visibility using classes
    displayFields.forEach(field => {
        field.classList.toggle('hidden');
    });
    
    editFields.forEach(field => {
        field.classList.toggle('show');
    });
    
    // Toggle avatar editing state
    avatar.classList.toggle('editing');
    
    // Toggle button visibility
    editBtn.classList.toggle('hidden');
    actionButtons.classList.toggle('visible');
}

function handlePhotoChange(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const profileImage = document.getElementById('profileImage');
            const avatarInitials = document.getElementById('avatarInitials');
            
            profileImage.src = e.target.result;
            profileImage.style.display = 'block';
            avatarInitials.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

function saveProfile() {
    const updatedData = {
        name: document.getElementById('inputName').value,
        email: document.getElementById('inputEmail').value,
        phone: document.getElementById('inputPhone').value,
        department: document.getElementById('inputDept').value,
        role: document.getElementById('inputRole').value,
        hire_date: document.getElementById('inputHireDate').value
    };
    
    // Update display fields
    document.getElementById('displayName').textContent = updatedData.name;
    document.getElementById('displayEmail').textContent = updatedData.email;
    document.getElementById('displayPhone').textContent = updatedData.phone;
    document.getElementById('displayDept').textContent = updatedData.department;
    document.getElementById('displayRole').textContent = updatedData.role;
    document.getElementById('displayHireDate').textContent = new Date(updatedData.hire_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    
    console.log('Profile updated:', updatedData);
    
    // Exit edit mode
    toggleEditMode();
    alert('Profile updated successfully!');
}

function cancelEdit() {
    // Reset values
    document.getElementById('inputName').value = document.getElementById('displayName').textContent;
    document.getElementById('inputEmail').value = document.getElementById('displayEmail').textContent;
    document.getElementById('inputPhone').value = document.getElementById('displayPhone').textContent;
    document.getElementById('inputDept').value = document.getElementById('displayDept').textContent;
    document.getElementById('inputRole').value = document.getElementById('displayRole').textContent;
    
    // Exit edit mode
    toggleEditMode();
}

// Profile dropdown toggle
const profile = document.getElementById("profileToggle");

if (profile) {
    profile.addEventListener("click", function () {
        this.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
        if (!profile.contains(e.target)) {
            profile.classList.remove("active");
        }
    });
}

// Initialize profile image display
document.addEventListener('DOMContentLoaded', function() {
    const profileImage = document.getElementById('profileImage');
    const avatarInitials = document.getElementById('avatarInitials');
    
    // Check if profile image exists and is not the default logo
    if (profileImage.src && !profileImage.src.includes('logo.jpg')) {
        profileImage.style.display = 'block';
        avatarInitials.style.display = 'none';
    } else {
        profileImage.style.display = 'none';
        avatarInitials.style.display = 'block';
    }
});

</script>

</body>
</html>
