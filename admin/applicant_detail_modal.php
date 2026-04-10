<div class="modal fade" id="applicantModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">

            <!-- HEADER -->
            <div class="custom-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Applicant Details</h5>
                <button type="button" class="btn-close btn-close-gray" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- PROFILE SECTION -->
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                    <div>
                        <div id="modalName" style="font-size:18px; font-weight:700;"></div>
                    </div>
                </div>

                <!-- BASIC INFO -->
                <div style="margin-top:10px;">
                    <div style="font-weight:600; margin-bottom:8px; color:#555;">
                        Notable Information
                    </div>

                    <div style="background:#f4b2b2; padding:12px; border-radius:10px;">
                        <div><strong>Contact Number:</strong> <span id="modalContact"></span></div>
                        <div><strong>Current Job:</strong> <span id="modalJob"></span></div>
                    </div>
                </div>

                <!-- DETAILS -->
                <div style="margin-top:20px;">
                    <div style="font-weight:600; margin-bottom:8px; color:#555;">
                        Additional Details
                    </div>

                    <div style="font-size:14px;">
                        <p><strong>School Graduated:</strong> <span id="modalSchool"></span></p>
                        <p><strong>Home Address:</strong> <span id="modalAddress"></span></p>

                        <p>
                            <strong>Status:</strong>
                            <span id="modalStatus" class="status-badge"></span>
                        </p>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer justify-content-center">
                <button class="close-modal-btn" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>