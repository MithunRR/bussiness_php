<?php include 'views/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Business Listings</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#businessModal" onclick="openAddModal()">
        + Add Business
    </button>
</div>

<table class="table table-bordered table-striped" id="businessTable">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Business Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
            <th>Average Rating</th>
        </tr>
    </thead>
    <tbody id="businessTableBody">
    </tbody>
</table>

<div class="modal fade" id="businessModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="businessModalLabel">Add Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="businessForm">
                <div class="modal-body">
                    <input type="hidden" id="businessId" name="id">
                    <div class="mb-3">
                        <label for="businessName" class="form-label">Business Name</label>
                        <input type="text" class="form-control" id="businessName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="businessAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="businessAddress" name="address" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="businessPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="businessPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="businessEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="businessEmail" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="businessSaveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Rating</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="ratingForm">
                <div class="modal-body">
                    <input type="hidden" id="ratingBusinessId" name="business_id">
                    <div class="mb-3">
                        <label for="ratingName" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="ratingName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="ratingEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="ratingEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="ratingPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="ratingPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div id="ratingStars"></div>
                        <input type="hidden" id="ratingValue" name="rating">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="ratingSaveBtn">Submit Rating</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>
