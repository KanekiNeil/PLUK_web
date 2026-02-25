<div class="modal fade" id="editNewsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit News / Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editNewsForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newsTitle" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="newsTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="newsDesc" class="form-label">Description</label>
                        <textarea class="form-control" id="newsDesc" rows="3" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="newsDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="newsDate" required>
                        </div>
                        <div class="col-md-6">
                            <label for="newsTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="newsTime" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="newsLocation" class="form-label">Location</label>
                        <input type="text" class="form-control" id="newsLocation" required>
                    </div>
                    <div class="mb-3">
                        <label for="newsFile" class="form-label">Upload Image / File</label>
                        <input type="file" class="form-control" id="newsFile">
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>