<?php
include_once __DIR__ . '/../php/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Appointments</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        color: #1f2937;
        background:
            radial-gradient(circle at top left, rgba(139, 0, 20, 0.08), transparent 30%),
            linear-gradient(180deg, #f7f3f3 0%, #f8fafc 45%, #eef2f7 100%);
        min-height: 100vh;
    }

    header {
        background: #ffffff;
        padding: 15px 40px;
        border-bottom: 1px solid #ddd;
        position: relative;
        z-index: 1000;
    }

    .header-container {
        display: flex;
        align-items: center;
    }

    .logo {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #8b0000;
    }

    .logo-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo-title h1 {
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }

    .top-nav ul {
        display: flex;
        list-style: none;
        gap: 50px;
        margin: 0;
        padding: 0;
    }

    .top-nav ul li {
        position: relative;
    }

    .top-nav ul li a {
        text-decoration: none;
        color: #8b0000;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 0;
        display: block;
        transition: 0.3s ease;
    }

    .top-nav ul li a:hover {
        opacity: 0.8;
    }

    .top-nav {
        margin-left: 500px;
    }

    .top-nav ul li .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        width: 200px;
        background: #ffffff;
        padding: 0;
        margin: 0;
        border-radius: 6px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.06);
        display: block;
        opacity: 0;
        visibility: hidden;
        transform: translateY(5px);
        transition: all 0.2s ease;
        z-index: 999;
    }

    .top-nav ul li .dropdown-menu li a {
        text-align: left;
        padding: 10px 15px;
        display: block;
    }

    .top-nav ul li:hover > .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-menu li {
        display: block;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .dropdown-menu li a {
        display: block;
        width: 100%;
        padding-left: 50px;
        padding: 6px 20px;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        line-height: 1.2;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
    }

    .dropdown-menu li a:hover {
        background: #f3f3f3;
        color: #8b0000;
    }

    .dropdown > a::after {
        content: " ▼";
        font-size: 10px;
        margin-left: 4px;
        color: #8b0000;
    }

    main {
        max-width: 1180px;
        margin: 0 auto;
        padding: 42px 24px 72px;
    }

    .hero {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 24px;
        align-items: stretch;
        margin-bottom: 24px;
    }

    .hero-card,
    .panel {
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(139, 3, 24, 0.08);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(12px);
    }

    .hero-card {
        padding: 34px;
        position: relative;
        overflow: hidden;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        inset: auto -100px -110px auto;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(139, 3, 24, 0.22), rgba(139, 3, 24, 0));
        pointer-events: none;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(139, 3, 24, 0.08);
        color: #8b0318;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    h1 {
        margin: 16px 0 12px;
        font-size: clamp(30px, 4vw, 48px);
        line-height: 1.05;
        color: #111827;
    }

    .lead {
        max-width: 60ch;
        font-size: 16px;
        line-height: 1.7;
        color: #475569;
        margin: 0;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 22px;
    }

    .meta {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 16px;
    }

    .meta-label {
        display: block;
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .meta-value {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        word-break: break-word;
    }

    .search-card {
        padding: 26px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 16px;
    }

    .search-card h2 {
        margin: 0;
        font-size: 22px;
        color: #111827;
    }

    .search-card p {
        margin: 0;
        color: #64748b;
        line-height: 1.6;
    }

    .search-form {
        display: grid;
        gap: 12px;
    }

    .field-label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
    }

    .field-row {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 14px;
        padding: 14px 16px;
        font-size: 15px;
        outline: none;
        transition: border-color .15s ease, box-shadow .15s ease;
        background: #fff;
    }

    .search-input:focus {
        border-color: #8b0318;
        box-shadow: 0 0 0 4px rgba(139, 3, 24, 0.12);
    }

    .btn {
        border: 0;
        border-radius: 14px;
        padding: 14px 18px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .15s ease, opacity .15s ease, box-shadow .15s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        color: #fff;
        background: linear-gradient(135deg, #8b0318, #b11d2d);
        box-shadow: 0 14px 28px rgba(139, 3, 24, 0.22);
    }

    .btn-secondary {
        color: #8b0318;
        background: #fff;
        border: 1px solid rgba(139, 3, 24, 0.18);
    }

    .panel {
        padding: 28px;
        margin-top: 24px;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: start;
        margin-bottom: 18px;
    }

    .panel-header h3 {
        margin: 0;
        font-size: 20px;
    }

    .panel-header p {
        margin: 6px 0 0;
        color: #64748b;
    }

    .notice {
        display: none;
        padding: 14px 16px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-size: 14px;
        line-height: 1.5;
    }

    .notice.is-visible {
        display: block;
    }

    .notice.success {
        background: #ecfdf3;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .notice.error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .notice.info {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .detail-box {
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 18px;
        background: #fff;
    }

    .detail-box strong {
        display: block;
        margin-bottom: 8px;
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .detail-box span {
        display: block;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        line-height: 1.45;
        word-break: break-word;
    }

    .request-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px dashed #d1d5db;
    }

    .request-copy {
        max-width: 60ch;
    }

    .request-copy h4 {
        margin: 0 0 6px;
        font-size: 16px;
    }

    .request-copy p {
        margin: 0;
        color: #64748b;
        line-height: 1.6;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        margin-top: 8px;
        background: #f1f5f9;
        color: #334155;
    }

    .status-pill.status-rescheduled,
    .status-pill.status-blue {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-pill.status-attended,
    .status-pill.status-green {
        background: #dcfce7;
        color: #166534;
    }

    .status-pill.status-pending,
    .status-pill.status-yellow {
        background: #fef3c7;
        color: #92400e;
    }

    .status-pill.status-default {
        background: #f1f5f9;
        color: #334155;
    }

    .loading {
        display: none;
        align-items: center;
        gap: 10px;
        color: #64748b;
        font-size: 14px;
        margin-top: 10px;
    }

    .loading.is-visible {
        display: flex;
    }

    .spinner {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid rgba(139, 3, 24, 0.2);
        border-top-color: #8b0318;
        animation: spin 0.8s linear infinite;
    }

    .empty-state {
        text-align: center;
        padding: 26px;
        color: #64748b;
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.72);
    }

    .modal-backdrop {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.5);
        z-index: 1200;
    }

    .modal-backdrop.is-visible {
        display: flex;
    }

    .schedule-modal {
        width: min(740px, 100%);
        max-height: 85vh;
        overflow: auto;
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 30px 70px rgba(2, 6, 23, 0.26);
    }

    .schedule-modal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .schedule-modal-head h4 {
        margin: 0;
        font-size: 18px;
        color: #111827;
    }

    .schedule-modal-head p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .icon-btn {
        border: 0;
        background: #f3f4f6;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        cursor: pointer;
        color: #334155;
    }

    .schedule-modal-body {
        padding: 20px;
    }

    .modal-inline-notice {
        margin-bottom: 14px;
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 14px;
        border: 1px solid #e5e7eb;
        color: #475569;
        background: #f8fafc;
    }

    .slots-grid {
        display: grid;
        gap: 12px;
    }

    .slot-btn {
        width: 100%;
        border: 1px solid #d1d5db;
        background: #fff;
        border-radius: 12px;
        padding: 12px 14px;
        text-align: left;
        cursor: pointer;
        transition: border-color 0.15s ease, background 0.15s ease;
    }

    .slot-btn strong {
        display: block;
        color: #111827;
        font-size: 15px;
    }

    .slot-btn span {
        display: block;
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
    }

    .slot-btn:hover {
        border-color: #8b0318;
        background: #fff7f8;
    }

    .slot-btn.is-selected {
        border-color: #8b0318;
        background: #fff1f2;
        box-shadow: inset 0 0 0 1px rgba(139, 3, 24, 0.18);
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 0 20px 20px;
    }

    .btn.is-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.88;
    }

    .btn-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn.is-loading .btn-label {
        opacity: 0;
    }

    .btn-spinner {
        position: absolute;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .btn.is-loading .btn-spinner {
        display: inline-flex;
    }

    .btn-spinner .spinner {
        width: 16px;
        height: 16px;
        border-width: 2px;
    }

    .modal-empty {
        padding: 18px;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        color: #64748b;
        text-align: center;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 900px) {
        .hero,
        .details-grid,
        .meta-grid {
            grid-template-columns: 1fr;
        }

        .field-row,
        .request-row,
        .panel-header {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
</head>
<body>
<?php include_once __DIR__ . '/../components/user_header.php'; ?>

<main>
    <section class="hero">
        <div class="hero-card">
            <span class="eyebrow"><i class="fa-solid fa-calendar-check"></i> Appointment Portal</span>
            <h1>View your current appointment and request a schedule change.</h1>
            <p class="lead">Enter the application ID you received after submitting your form. The page will show your active appointment details and let you flag it for rescheduling.</p>

            <div class="meta-grid">
                <div class="meta">
                    <span class="meta-label">Step 1</span>
                    <div class="meta-value">Enter your application ID</div>
                </div>
                <div class="meta">
                    <span class="meta-label">Step 2</span>
                    <div class="meta-value">Review the current schedule</div>
                </div>
                <div class="meta">
                    <span class="meta-label">Step 3</span>
                    <div class="meta-value">Request rescheduling if needed</div>
                </div>
            </div>
        </div>

        <div class="hero-card search-card">
            <h2>Find Appointment</h2>
            <p>Your application ID looks like a UUID. Example: <strong>123e4567-e89b-12d3-a456-426614174000</strong></p>

            <form class="search-form" id="appointmentLookupForm">
                <div>
                    <div class="field-label">Application ID</div>
                    <div class="field-row">
                        <input type="text" id="applicationId" class="search-input" placeholder="Paste your application ID here" autocomplete="off" spellcheck="false">
                        <button type="submit" class="btn btn-primary" id="lookupBtn">Search</button>
                    </div>
                </div>
            </form>

            <div class="loading" id="lookupLoading">
                <div class="spinner"></div>
                <span>Looking up your appointment...</span>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="notice" id="noticeBox"></div>

        <div class="panel-header">
            <div>
                <h3>Current Appointment</h3>
                <p>This section updates after you search an application ID.</p>
            </div>
            <button class="btn btn-secondary" type="button" id="refreshBtn" disabled>Refresh Current Record</button>
        </div>

        <div id="appointmentState" class="empty-state">
            Enter your application ID above to view your appointment details.
        </div>

        <div id="appointmentDetails" style="display:none;">
            <div class="details-grid">
                <div class="detail-box"><strong>Applicant</strong><span id="fullName"></span></div>
                <div class="detail-box"><strong>Application ID</strong><span id="appIdValue"></span></div>
                <div class="detail-box"><strong>Contact Number</strong><span id="contactNumber"></span></div>
                <div class="detail-box"><strong>Current Job</strong><span id="currentJob"></span></div>
                <div class="detail-box"><strong>Appointment Date</strong><span id="appointmentDate"></span></div>
                <div class="detail-box"><strong>Appointment Time</strong><span id="appointmentTime"></span></div>
            </div>

            <div class="request-row">
                <div class="request-copy">
                    <h4>Need to change the schedule?</h4>
                    <p>Request rescheduling to flag this appointment for review. The status will be updated so the team can process the change.</p>
                    <div id="appointmentStatusPill" class="status-pill"></div>
                </div>
                <button type="button" class="btn btn-primary" id="rescheduleBtn">Request Rescheduling</button>
            </div>
        </div>
    </section>
</main>

<div class="modal-backdrop" id="scheduleModal" aria-hidden="true">
    <div class="schedule-modal" role="dialog" aria-modal="true" aria-labelledby="scheduleModalTitle">
        <div class="schedule-modal-head">
            <div>
                <h4 id="scheduleModalTitle">Select a new schedule</h4>
                <p>Available applicant slots from the scheduling table.</p>
            </div>
            <button type="button" class="icon-btn" id="closeScheduleModal" aria-label="Close schedule modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="schedule-modal-body">
            <div id="scheduleModalNotice" class="modal-inline-notice">Loading available schedule slots...</div>
            <div id="scheduleSlots" class="slots-grid"></div>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" id="cancelRescheduleBtn"><span class="btn-label">Cancel</span></button>
            <button type="button" class="btn btn-primary" id="confirmRescheduleBtn" disabled><span class="btn-label">Confirm Reschedule</span><span class="btn-spinner"><div class="spinner"></div></span></button>
        </div>
    </div>
</div>

<script>
    const lookupForm = document.getElementById('appointmentLookupForm');
    const applicationIdInput = document.getElementById('applicationId');
    const lookupBtn = document.getElementById('lookupBtn');
    const lookupLoading = document.getElementById('lookupLoading');
    const noticeBox = document.getElementById('noticeBox');
    const appointmentState = document.getElementById('appointmentState');
    const appointmentDetails = document.getElementById('appointmentDetails');
    const refreshBtn = document.getElementById('refreshBtn');
    const rescheduleBtn = document.getElementById('rescheduleBtn');
    const scheduleModal = document.getElementById('scheduleModal');
    const closeScheduleModal = document.getElementById('closeScheduleModal');
    const cancelRescheduleBtn = document.getElementById('cancelRescheduleBtn');
    const confirmRescheduleBtn = document.getElementById('confirmRescheduleBtn');
    const scheduleSlots = document.getElementById('scheduleSlots');
    const scheduleModalNotice = document.getElementById('scheduleModalNotice');

    const viewState = {
        applicationId: '',
        aiid: '',
        aaid: '',
        appointment: null,
        selectedSlot: null
    };

    function showNotice(message, type = 'info') {
        noticeBox.className = `notice is-visible ${type}`;
        noticeBox.textContent = message;
    }

    function clearNotice() {
        noticeBox.className = 'notice';
        noticeBox.textContent = '';
    }

    function setLoading(isLoading) {
        lookupLoading.classList.toggle('is-visible', isLoading);
        lookupBtn.disabled = isLoading;
        refreshBtn.disabled = isLoading || !viewState.applicationId;
        rescheduleBtn.disabled = isLoading || !viewState.aiid;
    }

    function renderEmpty(message) {
        viewState.applicationId = '';
        viewState.aiid = '';
        viewState.aaid = '';
        viewState.appointment = null;
        appointmentState.textContent = message;
        appointmentState.style.display = 'block';
        appointmentDetails.style.display = 'none';
        refreshBtn.disabled = true;
        rescheduleBtn.disabled = true;
    }

    function statusClass(status) {
        const value = (status || '').toLowerCase();
        if (value.includes('resched')) return 'status-rescheduled';
        if (value.includes('attended')) return 'status-attended';
        if (value.includes('waiting') || value.includes('pending')) return 'status-pending';
        return 'status-default';
    }

    function renderAppointment(data) {
        viewState.applicationId = data.application_id || '';
        viewState.aiid = data.aiid || '';
        viewState.aaid = data.appointment?.aaid || '';
        viewState.appointment = data.appointment || null;
        viewState.selectedSlot = null;

        document.getElementById('fullName').textContent = data.full_name || 'Unknown Applicant';
        document.getElementById('appIdValue').textContent = data.application_id || '';
        document.getElementById('contactNumber').textContent = data.contact_number || 'N/A';
        document.getElementById('currentJob').textContent = data.current_job || 'N/A';
        document.getElementById('appointmentDate').textContent = data.appointment?.date || 'N/A';
        document.getElementById('appointmentTime').textContent = data.appointment?.time_range || 'N/A';

        const statusText = data.appointment?.status || data.applicant_status || 'Scheduled';
        const statusPill = document.getElementById('appointmentStatusPill');
        statusPill.className = `status-pill ${statusClass(statusText)}`;
        statusPill.textContent = `Status: ${statusText}`;

        appointmentState.style.display = 'none';
        appointmentDetails.style.display = 'block';
        refreshBtn.disabled = false;
        rescheduleBtn.disabled = false;
    }

    function toReadableDate(value) {
        if (!value) {
            return 'Unknown date';
        }

        const date = new Date(value + 'T00:00:00');
        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return date.toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function normalizeTime(value) {
        if (!value) {
            return 'N/A';
        }

        const text = String(value).trim();
        if (text.includes('AM') || text.includes('PM')) {
            return text;
        }

        const [hours, minutes] = text.split(':');
        const parsedHours = Number(hours);
        const parsedMinutes = Number(minutes);

        if (Number.isNaN(parsedHours) || Number.isNaN(parsedMinutes)) {
            return text;
        }

        const date = new Date();
        date.setHours(parsedHours, parsedMinutes, 0, 0);
        return date.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
    }

    function closeRescheduleModal() {
        setRescheduleModalLoading(false);
        scheduleModal.classList.remove('is-visible');
        scheduleModal.setAttribute('aria-hidden', 'true');
    }

    function openRescheduleModal() {
        scheduleModal.classList.add('is-visible');
        scheduleModal.setAttribute('aria-hidden', 'false');
    }

    function renderScheduleSlots(slots) {
        scheduleSlots.innerHTML = '';
        viewState.selectedSlot = null;
        confirmRescheduleBtn.disabled = true;

        if (!slots.length) {
            scheduleModalNotice.textContent = 'No available applicant schedules were found.';
            scheduleSlots.innerHTML = '<div class="modal-empty">No available slots at the moment. Please try again later.</div>';
            return;
        }

        scheduleModalNotice.textContent = 'Choose one slot below before confirming your reschedule request.';

        slots.forEach((slot, index) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'slot-btn';
            button.dataset.index = String(index);

            const dateText = toReadableDate(slot.date);
            const startText = normalizeTime(slot.start_time);
            const endText = normalizeTime(slot.end_time);

            button.innerHTML = `<strong>${dateText}</strong><span>${startText} - ${endText}</span>`;

            button.addEventListener('click', () => {
                document.querySelectorAll('.slot-btn').forEach((item) => item.classList.remove('is-selected'));
                button.classList.add('is-selected');
                viewState.selectedSlot = slot;
                confirmRescheduleBtn.disabled = false;
            });

            scheduleSlots.appendChild(button);
        });
    }

    async function loadApplicantAvailableDates() {
        scheduleModalNotice.textContent = 'Loading available schedule slots...';
        scheduleSlots.innerHTML = '';
        confirmRescheduleBtn.disabled = true;
        setRescheduleModalLoading(false);

        const response = await fetch('../php/get_available_applicant_dates.php');
        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Unable to fetch available schedule slots.');
        }

        renderScheduleSlots(Array.isArray(data.data) ? data.data : []);
    }

    function getSelectedAppointmentDateTime() {
        if (!viewState.selectedSlot?.date || !viewState.selectedSlot?.start_time) {
            return '';
        }

        return `${viewState.selectedSlot.date} ${viewState.selectedSlot.start_time}`;
    }

    function setRescheduleModalLoading(isLoading) {
        confirmRescheduleBtn.disabled = isLoading || !viewState.selectedSlot;
        cancelRescheduleBtn.disabled = isLoading;
        closeScheduleModal.disabled = isLoading;

        scheduleSlots.querySelectorAll('button.slot-btn').forEach((button) => {
            button.disabled = isLoading;
        });

        confirmRescheduleBtn.classList.toggle('is-loading', isLoading);
        confirmRescheduleBtn.setAttribute('aria-busy', isLoading ? 'true' : 'false');
    }

    async function lookupAppointment(applicationId) {
        const trimmedId = applicationId.trim();

        if (!trimmedId) {
            showNotice('Enter an application ID to search for an appointment.', 'error');
            return;
        }

        setLoading(true);
        clearNotice();

        try {
            const response = await fetch(`../php/get_user_appointment.php?application_id=${encodeURIComponent(trimmedId)}`);
            const data = await response.json();

            if (!response.ok || !data.success) {
                renderEmpty('No appointment matched that application ID.');
                showNotice(data.message || 'Unable to load appointment details.', 'error');
                return;
            }

            renderAppointment(data.data);
            showNotice('Appointment loaded successfully.', 'success');
        } catch (error) {
            console.error(error);
            renderEmpty('Unable to load the appointment right now.');
            showNotice('Something went wrong while loading the appointment.', 'error');
        } finally {
            setLoading(false);
        }
    }

    lookupForm.addEventListener('submit', (event) => {
        event.preventDefault();
        lookupAppointment(applicationIdInput.value);
    });

    refreshBtn.addEventListener('click', () => {
        if (viewState.applicationId) {
            lookupAppointment(viewState.applicationId);
        }
    });

    rescheduleBtn.addEventListener('click', async () => {
        if (!viewState.aiid) {
            showNotice('Load an appointment before requesting rescheduling.', 'error');
            return;
        }

        openRescheduleModal();

        try {
            await loadApplicantAvailableDates();
        } catch (error) {
            console.error(error);
            scheduleModalNotice.textContent = error.message || 'Unable to load available schedules.';
            scheduleSlots.innerHTML = '<div class="modal-empty">Unable to load slots right now.</div>';
        }
    });

    closeScheduleModal.addEventListener('click', closeRescheduleModal);
    cancelRescheduleBtn.addEventListener('click', closeRescheduleModal);

    scheduleModal.addEventListener('click', (event) => {
        if (event.target === scheduleModal) {
            closeRescheduleModal();
        }
    });

    confirmRescheduleBtn.addEventListener('click', async () => {
        if (!viewState.selectedSlot) {
            scheduleModalNotice.textContent = 'Select a schedule slot before confirming.';
            return;
        }

        setLoading(true);
        clearNotice();

        try {
            const payload = {
                status: 'Rescheduled',
                aiid: viewState.aiid,
                aaid: viewState.aaid,
                appointment_type: 'applicant',
                appointment_datetime: getSelectedAppointmentDateTime()
            };

            const response = await fetch('../php/update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (!response.ok || data.status !== 'success') {
                throw new Error(data.message || 'Unable to update appointment status.');
            }

            closeRescheduleModal();
            showNotice('Your rescheduling request was sent successfully.', 'success');
            await lookupAppointment(viewState.applicationId);
        } catch (error) {
            console.error(error);
            showNotice(error.message || 'Unable to request rescheduling.', 'error');
            scheduleModalNotice.textContent = error.message || 'Unable to save the selected schedule.';
        } finally {
            setRescheduleModalLoading(false);
        }
    });
</script>
</body>
</html>