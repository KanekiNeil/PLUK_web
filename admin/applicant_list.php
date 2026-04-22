<?php
include_once "../php/session.php";


if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: admin_login.php");
    exit;
}
$appointments = include '../php/get_applicant_info.php';

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";
$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Applicant List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== GLOBAL ===== */
body {
    margin: 0;
    font-family: "Segoe UI", system-ui, sans-serif;
    background-color: #f5f5f5;
    color: #333;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: url("../assets/logo.jpg") center no-repeat;
    background-size: 400px;
    opacity: 0.05;
    z-index: -1;
}

/* ===== CONTAINER ===== */
.applicant-container{
    background:white;
    border-radius:16px;
    padding:30px;
    box-shadow:0 8px 25px rgba(0,0,0,0.06);
    min-height: 500px;
}

/* optional wrapper matching appointment_list */
.container-al {
    padding: 40px;
}

/* ===== TITLE ===== */
.page-title{
    font-weight:600;
    margin-bottom:20px;
}

/* ===== GRID TABLE ===== */
.table-header,
.table-row {
    display: grid;
    grid-template-columns: 1.2fr 1fr 1.6fr 1.6fr 0.7fr;
    padding: 16px 15px;
    align-items: center;
}

/* HEADER */
.table-header{
    font-weight: 700;
    border-bottom: 2px solid #880318;
    color: #000000;
    font-size: 16px;
    letter-spacing: 0.5px;
}

/* TEXT HANDLING */
.table-row div{
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

@media (max-width: 900px) {
    .table-header,
    .table-row {
        grid-template-columns: 1fr 1fr;
        row-gap: 10px;
    }
}

/* Allow address wrapping */
.col-address{
    white-space:normal;
}

/* ===== STATUS BADGES ===== */
.status-badge{
    padding:4px 12px;
    border-radius:20px;
    font-size:0.75rem;
    font-weight:600;
    border: 1px solid transparent;
}

.badge-pending{
    background:#fff4cc;
    color:#7a5a00;
    border-color:#ffe08a;
}

.badge-approved{
    background:#dcfce7;
    color:#166534;
    border-color:#86efac;
}

.badge-completed{
    background:#e0f2fe;
    color:#0c4a6e;
    border-color:#7dd3fc;
}

.badge-cancelled{
    background:#fee2e2;
    color:#991b1b;
    border-color:#fca5a5;
}

.badge-verify-exam {
    background:#ffedd5;
    color:#9a3412;
    border-color:#fdba74;
}

.badge-verify-training {
    background:#ede9fe;
    color:#5b21b6;
    border-color:#c4b5fd;
}

.badge-payment-verified,
.badge-training-verified {
    background:#dcfce7;
    color:#166534;
    border-color:#86efac;
}

.badge-default {
    background:#e5e7eb;
    color:#374151;
    border-color:#d1d5db;
}

/* ===== USER HEADER (optional fix safe) ===== */
.user-section{
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    background:#2c6ed5;
    color:white;
    width:38px;
    height:38px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

.table-row {
    cursor: pointer;
}

.table-row:hover {
    background: #f1f5f9;
    transform: scale(1.01);
}

/* ===== MODAL DESIGN ===== */

.custom-modal {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Header */
.custom-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}

/* Body spacing */
.modal-body {
    padding: 20px 25px;
}

/* Each field */
.modal-item {
    margin-bottom: 15px;
}

/* Labels */
.modal-item label {
    font-size: 12px;
    color: #888;
    display: block;
    margin-bottom: 2px;
}

/* Values */
.modal-item p {
    margin: 0;
    font-size: 15px;
    font-weight: 500;
    color: #333;
}

/* Footer */
.modal-footer {
    border-top: 1px solid #eee;
    padding-bottom: 20px;
}

.modal-footer {
    display: flex;
    justify-content: center;
    padding: 20px;
    border-top: none;
    background-color: #f9fafb;
}

.close-modal-btn {
    background-color: #880318; /* green theme */
    color: white;
    border: none;
    padding: 10px 28px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.close-modal-btn:hover {
    opacity:0.85;
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.reject-modal-btn {
    background-color: #b91c1c;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.reject-modal-btn:hover {
    background-color: #991b1b;
}

</style>
</head>

<body>

<!-- HEADER -->
<?php include '../components/admin_header.php'; ?>

<div class="container-al">
<div class="card">

<!-- HEADER -->
<div class="table-header">
    <div>Complete Name</div>
    <div>Contact Number</div>
    <div>School Attended</div>
    <div>Job</div>
    <div>Status</div>
</div>

<!-- DATA -->
<?php foreach ($appointments as $appt): 
    $normalizedStatus = strtolower(trim((string)($appt[5] ?? '')));
    $statusClass = match($normalizedStatus) {
        "pending" => "badge-pending",
        "approved" => "badge-approved",
        "completed" => "badge-completed",
        "cancelled" => "badge-cancelled",
        "verify exam payment" => "badge-verify-exam",
        "verify training payment" => "badge-verify-training",
        "payment verified" => "badge-payment-verified",
        "training payment verified" => "badge-training-verified",
        "payment rejected" => "badge-cancelled",
        default => "badge-default"
    };
?>

<div class="table-row"
     data-name="<?= $appt[0] ?>"
     data-app-id="<?= htmlspecialchars($appt[6] ?? 'N/A') ?>"
     data-contact="<?= $appt[1] ?>"
     data-school="<?= $appt[2] ?>"
     data-job="<?= $appt[3] ?>"
     data-address="<?= $appt[4] ?>"
     data-status="<?= $appt[5] ?>">

    <div><?= $appt[0] ?></div>
    <div><?= $appt[1] ?></div>
    <div><?= $appt[2] ?></div>
    <div><?= $appt[3] ?></div>

    <div>
        <span class="status-badge <?= $statusClass ?>">
            <?= $appt[5] ?>
        </span>
    </div>

</div>

<?php endforeach; ?>

    </div>
</div>

<?php include 'applicant_detail_modal.php'; ?>

<div class="modal fade" id="examPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="custom-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Verify Exam Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom:8px;"><strong>Applicant:</strong> <span id="examModalName"></span></p>
                <img id="examPaymentProof" alt="Exam payment proof" style="display:none; width:100%; max-height:320px; object-fit:contain; border:1px solid #ddd; border-radius:8px; padding:6px; background:#fff;">
                <p id="examPaymentEmpty" style="display:none; color:#842029; background:#f8d7da; padding:10px; border-radius:8px;">No exam payment proof found.</p>
            </div>
            <div class="modal-footer">
                <button class="reject-modal-btn" id="rejectExamBtn">Reject Payment</button>
                <button class="close-modal-btn" id="verifyExamBtn">Mark Exam Payment Verified</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="trainingPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="custom-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Verify Training Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom:8px;"><strong>Applicant:</strong> <span id="trainingModalName"></span></p>
                <img id="trainingPaymentProof" alt="Training payment proof" style="display:none; width:100%; max-height:320px; object-fit:contain; border:1px solid #ddd; border-radius:8px; padding:6px; background:#fff;">
                <p id="trainingPaymentEmpty" style="display:none; color:#842029; background:#f8d7da; padding:10px; border-radius:8px;">No training payment proof found.</p>
            </div>
            <div class="modal-footer">
                <button class="reject-modal-btn" id="rejectTrainingBtn">Reject Payment</button>
                <button class="close-modal-btn" id="verifyTrainingBtn">Mark Training Payment Verified</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<script>

/* ===== SAFE PROFILE TOGGLE ===== */
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

</script>

<script>
document.querySelectorAll('.table-row').forEach(row => {

    const normalizeStatus = (value) => (value || '').trim().toLowerCase();

    const resetProofState = (proofImgEl, emptyEl, verifyBtn) => {
        proofImgEl.style.display = 'none';
        proofImgEl.removeAttribute('src');
        emptyEl.style.display = 'none';
        verifyBtn.disabled = false;
    };

    const toDataUrl = (value) => {
        if (!value) return '';
        if (value.startsWith('data:image')) return value;
        return 'data:image/png;base64,' + value;
    };

    const loadPaymentProof = async (type, appId) => {
        const response = await fetch(`../php/get_payment_request.php?type=${encodeURIComponent(type)}&applicant_id=${encodeURIComponent(appId)}`);
        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Failed to load payment request.');
        }
        return data;
    };

    const verifyPayment = async (type, appId) => {
        const response = await fetch('../php/verify_payment_request.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'verify', type, applicant_id: appId })
        });
        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Failed to verify payment request.');
        }
        return data;
    };

    const rejectPayment = async (type, appId) => {
        const response = await fetch('../php/verify_payment_request.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'reject', type, applicant_id: appId })
        });
        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Failed to reject payment request.');
        }
        return data;
    };

    const getStatusBadgeClass = (statusValue) => {
        const s = normalizeStatus(statusValue);
        if (s === 'pending') return 'badge-pending';
        if (s === 'approved') return 'badge-approved';
        if (s === 'completed') return 'badge-completed';
        if (s === 'cancelled') return 'badge-cancelled';
        if (s === 'verify exam payment') return 'badge-verify-exam';
        if (s === 'verify training payment') return 'badge-verify-training';
        if (s === 'payment verified') return 'badge-payment-verified';
        if (s === 'training payment verified') return 'badge-training-verified';
        if (s === 'payment rejected') return 'badge-cancelled';
        return 'badge-default';
    };

    row.addEventListener('click', () => {

        const name = row.dataset.name;
        const appId = row.dataset.appId;
        const contact = row.dataset.contact;
        const school = row.dataset.school;
        const job = row.dataset.job;
        const address = row.dataset.address;
        const status = row.dataset.status;
        const normalizedStatus = normalizeStatus(status);

        if (normalizedStatus === 'verify exam payment') {
            const modalEl = document.getElementById('examPaymentModal');
            const modal = new bootstrap.Modal(modalEl);
            const proofImg = document.getElementById('examPaymentProof');
            const emptyMsg = document.getElementById('examPaymentEmpty');
            const verifyBtn = document.getElementById('verifyExamBtn');
            const rejectBtn = document.getElementById('rejectExamBtn');

            document.getElementById('examModalName').textContent = name;

            resetProofState(proofImg, emptyMsg, verifyBtn);
            verifyBtn.onclick = null;
            rejectBtn.onclick = null;
            rejectBtn.disabled = false;

            modal.show();

            loadPaymentProof('exam', appId)
                .then((data) => {
                    if (data.payment_proof) {
                        proofImg.src = toDataUrl(data.payment_proof);
                        proofImg.style.display = 'block';
                    } else {
                        emptyMsg.style.display = 'block';
                        verifyBtn.disabled = true;
                    }

                    verifyBtn.onclick = async () => {
                        verifyBtn.disabled = true;
                        rejectBtn.disabled = true;
                        try {
                            await verifyPayment('exam', appId);
                            row.dataset.status = 'payment verified';
                            row.querySelector('.status-badge').textContent = 'payment verified';
                            row.querySelector('.status-badge').className = 'status-badge ' + getStatusBadgeClass('payment verified');
                            modal.hide();
                        } catch (error) {
                            alert(error.message || 'Verification failed.');
                            verifyBtn.disabled = false;
                            rejectBtn.disabled = false;
                        }
                    };

                    rejectBtn.onclick = async () => {
                        if (!confirm('Reject this payment request? This will delete the uploaded record.')) {
                            return;
                        }

                        verifyBtn.disabled = true;
                        rejectBtn.disabled = true;
                        try {
                            await rejectPayment('exam', appId);
                            row.dataset.status = 'payment rejected';
                            row.querySelector('.status-badge').textContent = 'payment rejected';
                            row.querySelector('.status-badge').className = 'status-badge ' + getStatusBadgeClass('payment rejected');
                            modal.hide();
                        } catch (error) {
                            alert(error.message || 'Reject failed.');
                            verifyBtn.disabled = false;
                            rejectBtn.disabled = false;
                        }
                    };
                })
                .catch((error) => {
                    emptyMsg.textContent = error.message || 'Unable to load exam payment request.';
                    emptyMsg.style.display = 'block';
                    verifyBtn.disabled = true;
                    rejectBtn.disabled = true;
                });

            return;
        }

        if (normalizedStatus === 'verify training payment') {
            const modalEl = document.getElementById('trainingPaymentModal');
            const modal = new bootstrap.Modal(modalEl);
            const proofImg = document.getElementById('trainingPaymentProof');
            const emptyMsg = document.getElementById('trainingPaymentEmpty');
            const verifyBtn = document.getElementById('verifyTrainingBtn');
            const rejectBtn = document.getElementById('rejectTrainingBtn');

            document.getElementById('trainingModalName').textContent = name;

            resetProofState(proofImg, emptyMsg, verifyBtn);
            verifyBtn.onclick = null;
            rejectBtn.onclick = null;
            rejectBtn.disabled = false;

            modal.show();

            loadPaymentProof('training', appId)
                .then((data) => {
                    if (data.payment_proof) {
                        proofImg.src = toDataUrl(data.payment_proof);
                        proofImg.style.display = 'block';
                    } else {
                        emptyMsg.style.display = 'block';
                        verifyBtn.disabled = true;
                    }

                    verifyBtn.onclick = async () => {
                        verifyBtn.disabled = true;
                        rejectBtn.disabled = true;
                        try {
                            await verifyPayment('training', appId);
                            row.dataset.status = 'training payment verified';
                            row.querySelector('.status-badge').textContent = 'training payment verified';
                            row.querySelector('.status-badge').className = 'status-badge ' + getStatusBadgeClass('training payment verified');
                            modal.hide();
                        } catch (error) {
                            alert(error.message || 'Verification failed.');
                            verifyBtn.disabled = false;
                            rejectBtn.disabled = false;
                        }
                    };

                    rejectBtn.onclick = async () => {
                        if (!confirm('Reject this payment request? This will delete the uploaded record.')) {
                            return;
                        }

                        verifyBtn.disabled = true;
                        rejectBtn.disabled = true;
                        try {
                            await rejectPayment('training', appId);
                            row.dataset.status = 'payment rejected';
                            row.querySelector('.status-badge').textContent = 'payment rejected';
                            row.querySelector('.status-badge').className = 'status-badge ' + getStatusBadgeClass('payment rejected');
                            modal.hide();
                        } catch (error) {
                            alert(error.message || 'Reject failed.');
                            verifyBtn.disabled = false;
                            rejectBtn.disabled = false;
                        }
                    };
                })
                .catch((error) => {
                    emptyMsg.textContent = error.message || 'Unable to load training payment request.';
                    emptyMsg.style.display = 'block';
                    verifyBtn.disabled = true;
                    rejectBtn.disabled = true;
                });

            return;
        }

        // Fill modal
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalContact').textContent = contact;
        document.getElementById('modalSchool').textContent = school;
        document.getElementById('modalJob').textContent = job;
        document.getElementById('modalAddress').textContent = address;

        // STATUS BADGE (dynamic color)
        const statusEl = document.getElementById('modalStatus');
        statusEl.textContent = status;
        statusEl.className = "status-badge " + getStatusBadgeClass(status);


        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('applicantModal'));
        modal.show();
    });

});
</script>

</body>
</html>