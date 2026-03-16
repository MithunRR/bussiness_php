var ratyStarPath = 'https://cdn.jsdelivr.net/npm/jquery-raty-js@2.8.0/lib/images';

$(document).ready(function () {
    loadBusinesses();

    $('#businessForm').on('submit', function (e) {
        e.preventDefault();
        saveBusiness();
    });

    $('#ratingForm').on('submit', function (e) {
        e.preventDefault();
        submitRating();
    });
});

function loadBusinesses() {
    $.ajax({
        url: 'controllers/BusinessController.php',
        type: 'POST',
        data: { action: 'list' },
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                renderTable(response.data);
            }
        }
    });
}

function renderTable(businesses) {
    var tbody = $('#businessTableBody');
    tbody.empty();

    if (businesses.length === 0) {
        tbody.append('<tr><td colspan="7" class="text-center text-muted">No businesses found. Click "Add Business" to get started.</td></tr>');
        return;
    }

    $.each(businesses, function (index, biz) {
        var row = '<tr id="row-' + biz.id + '">' +
            '<td>' + biz.id + '</td>' +
            '<td>' + escapeHtml(biz.name) + '</td>' +
            '<td>' + escapeHtml(biz.address) + '</td>' +
            '<td>' + escapeHtml(biz.phone) + '</td>' +
            '<td>' + escapeHtml(biz.email) + '</td>' +
            '<td>' +
            '<button class="btn btn-sm btn-warning btn-action" onclick="openEditModal(' + biz.id + ')">Edit</button>' +
            '<button class="btn btn-sm btn-danger btn-action" onclick="deleteBusiness(' + biz.id + ')">Delete</button>' +
            '</td>' +
            '<td>' +
            '<div class="rating-display" id="rating-' + biz.id + '" data-id="' + biz.id + '" data-score="' + biz.avg_rating + '"></div>' +
            '<span class="avg-text" id="avg-text-' + biz.id + '">' + biz.avg_rating + ' / 5</span>' +
            '</td>' +
            '</tr>';
        tbody.append(row);
    });

    initRatyDisplays();
}

function initRatyDisplays() {
    $('.rating-display').each(function () {
        var el = $(this);
        var score = parseFloat(el.data('score'));
        var bizId = el.data('id');
        initSingleRaty(el, score, bizId);
    });
}

function initSingleRaty(el, score, bizId) {
    el.empty();
    el.raty({
        path: ratyStarPath,
        score: score,
        readOnly: true,
        half: true
    });

    el.css('cursor', 'pointer');
    el.off('click').on('click', function () {
        openRatingModal(bizId);
    });
}

function openAddModal() {
    $('#businessModalLabel').text('Add Business');
    $('#businessForm')[0].reset();
    $('#businessId').val('');
}

function openEditModal(id) {
    $.ajax({
        url: 'controllers/BusinessController.php',
        type: 'POST',
        data: { action: 'get', id: id },
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                var biz = response.data;
                $('#businessModalLabel').text('Edit Business');
                $('#businessId').val(biz.id);
                $('#businessName').val(biz.name);
                $('#businessAddress').val(biz.address);
                $('#businessPhone').val(biz.phone);
                $('#businessEmail').val(biz.email);
                var modal = new bootstrap.Modal(document.getElementById('businessModal'));
                modal.show();
            }
        }
    });
}

function saveBusiness() {
    var id = $('#businessId').val();
    var action = id ? 'update' : 'add';
    var formData = {
        action: action,
        id: id,
        name: $('#businessName').val(),
        address: $('#businessAddress').val(),
        phone: $('#businessPhone').val(),
        email: $('#businessEmail').val()
    };

    $.ajax({
        url: 'controllers/BusinessController.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                bootstrap.Modal.getInstance(document.getElementById('businessModal')).hide();
                renderTable(response.data);
                alert(response.message);
            } else {
                alert(response.message);
            }
        }
    });
}

function deleteBusiness(id) {
    if (!confirm('Are you sure you want to delete this business?')) {
        return;
    }

    $.ajax({
        url: 'controllers/BusinessController.php',
        type: 'POST',
        data: { action: 'delete', id: id },
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                $('#row-' + id).fadeOut(300, function () {
                    $(this).remove();
                    if ($('#businessTableBody tr').length === 0) {
                        loadBusinesses();
                    }
                });
            } else {
                alert(response.message);
            }
        }
    });
}

function openRatingModal(businessId) {
    $('#ratingForm')[0].reset();
    $('#ratingBusinessId').val(businessId);
    $('#ratingValue').val('');

    var modal = new bootstrap.Modal(document.getElementById('ratingModal'));
    modal.show();

    setTimeout(function () {
        $('#ratingStars').empty();
        $('#ratingStars').raty({
            path: ratyStarPath,
            half: true,
            score: 0,
            click: function (score) {
                var rounded = Math.round(score * 2) / 2;
                $('#ratingValue').val(rounded);
                $('#ratingStars').raty('score', rounded);
            }
        });
    }, 300);
}

function submitRating() {
    var rating = $('#ratingValue').val();
    if (!rating || rating <= 0) {
        alert('Please select a rating');
        return;
    }

    var bizId = $('#ratingBusinessId').val();
    var formData = {
        action: 'submit',
        business_id: bizId,
        name: $('#ratingName').val(),
        email: $('#ratingEmail').val(),
        phone: $('#ratingPhone').val(),
        rating: rating
    };

    $.ajax({
        url: 'controllers/RatingController.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                bootstrap.Modal.getInstance(document.getElementById('ratingModal')).hide();

                var ratingEl = $('#rating-' + bizId);
                var newScore = parseFloat(response.avg_rating);
                ratingEl.data('score', newScore);
                initSingleRaty(ratingEl, newScore, bizId);
                $('#avg-text-' + bizId).text(newScore + ' / 5');

                alert(response.message);
            } else {
                alert(response.message);
            }
        }
    });
}

function escapeHtml(text) {
    if (!text) return '';
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(text));
    return div.innerHTML;
}
