<?php

require_once __DIR__ . '/../models/Business.php';

header('Content-Type: application/json');

$business = new Business();
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'list') {
    listBusinesses($business);
} elseif ($action === 'get') {
    getBusiness($business);
} elseif ($action === 'add') {
    addBusiness($business);
} elseif ($action === 'update') {
    updateBusiness($business);
} elseif ($action === 'delete') {
    deleteBusiness($business);
} else {
    echo json_encode(['status' => false, 'message' => 'Invalid action']);
}

function listBusinesses($business) {
    $data = $business->getAll();
    echo json_encode(['status' => true, 'data' => $data]);
}

function getBusiness($business) {
    $id = intval($_POST['id']);
    $data = $business->getById($id);
    if ($data) {
        echo json_encode(['status' => true, 'data' => $data]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Business not found']);
    }
}

function addBusiness($business) {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($address) || empty($phone) || empty($email)) {
        echo json_encode(['status' => false, 'message' => 'All fields are required']);
        return;
    }

    if ($business->create($name, $address, $phone, $email)) {
        $data = $business->getAll();
        echo json_encode(['status' => true, 'message' => 'Business added successfully', 'data' => $data]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to add business']);
    }
}

function updateBusiness($business) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($address) || empty($phone) || empty($email)) {
        echo json_encode(['status' => false, 'message' => 'All fields are required']);
        return;
    }

    if ($business->update($id, $name, $address, $phone, $email)) {
        $data = $business->getAll();
        echo json_encode(['status' => true, 'message' => 'Business updated successfully', 'data' => $data]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to update business']);
    }
}

function deleteBusiness($business) {
    $id = intval($_POST['id']);
    if ($business->delete($id)) {
        echo json_encode(['status' => true, 'message' => 'Business deleted successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to delete business']);
    }
}
