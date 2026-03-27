<div class="modal-content">

    <!-- PROFILE SECTION -->
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
        <img id="modalFaceImage" 
             style="width:50px; height:50px; border-radius:50%; border:2px solid #880318;">
        <div>
            <div id="modalName" style="font-size:18px; font-weight:700;"></div>
        </div>
    </div>

    <!-- SCHEDULE DATE SECTION -->
    <div style="margin-top:10px;">
        <div style="font-weight:600; margin-bottom:8px; color:#555;">
            Schedule Date
        </div>

        <div style="background:#f4b2b2; padding:12px; border-radius:10px;">
            <div id="modalDate"></div>
            <div id="modalTime"></div>
        </div>
    </div>

    <!-- DETAILS SECTION -->
    <div style="margin-top:20px;">
        <div style="font-weight:600; margin-bottom:8px; color:#555;">
            Details
        </div>

        <div style="font-size:14px;">

            <p><strong>Current Job:</strong> <span id="modalType"></span></p>
            <p><strong>Contact Number:</strong> <span>N/A</span></p>

            <p>
                <strong>Status:</strong> 
                <span id="modalStatus" class="status-badge"></span>
            </p>

            <p><strong>Date Attended BYB:</strong> <span>N/A</span></p>
            <p><strong>Next Step:</strong> <span>N/A</span></p>

        </div>
    </div>

    <!-- FOOTER -->
    <div style="text-align:center; margin-top:20px;">
        <button class="close-modal-btn" onclick="closeModal()">Close</button>
    </div>

</div>