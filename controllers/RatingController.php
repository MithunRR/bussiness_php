<?php

require_once __DIR__ . '/../models/Rating.php';
require_once __DIR__ . '/../models/Business.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if ($action === 'submit') {
    submitRating();
} else {
    echo json_encode(['status' => false, 'message' => 'Invalid action']);
}

function submitRating() {
    $businessId = intval($_POST['business_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $rating = floatval($_POST['rating']);

    if (empty($name) || empty($email) || empty($phone) || $rating <= 0) {
        echo json_encode(['status' => false, 'message' => 'All fields are required']);
        return;
    }

    if ($rating < 0.5 || $rating > 5) {
        echo json_encode(['status' => false, 'message' => 'Rating must be between 0.5 and 5']);
        return;
    }

    $validRating = round($rating * 2) / 2;
    if ($validRating != $rating) {
        echo json_encode(['status' => false, 'message' => 'Rating must be in steps of 0.5']);
        return;
    }

    $ratingModel = new Rating();
    if ($ratingModel->save($businessId, $name, $email, $phone, $rating)) {
        $businessModel = new Business();
        $avgRating = $businessModel->getAverageRating($businessId);
        echo json_encode([
            'status' => true,
            'message' => 'Rating submitted successfully',
            'avg_rating' => $avgRating
        ]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to submit rating']);
    }
}
