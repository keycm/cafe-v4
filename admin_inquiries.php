<?php
include 'session_check.php';
$conn = new mysqli("localhost", "root", "", "addproduct");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Handle actions (Mark as Read / Delete)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']);
    if ($action == 'read') {
        $stmt = $conn->prepare("UPDATE inquiries SET status = 'Read' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action == 'delete') {
        $stmt = $conn->prepare("DELETE FROM inquiries WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    header("Location: admin_inquiries.php");
    exit();
}

$inquiries_result = $conn->query("SELECT * FROM inquiries ORDER BY received_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Inquiries</title>
<link rel="stylesheet" href="CSS/admin.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<style>
  .card { background:white; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.08); }
  .inquiry { border: 1px solid #eee; border-radius: 10px; margin-bottom: 20px; }
  .inquiry-header { background: #f9fafb; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; }
  .inquiry-sender { font-weight: 600; }
  .inquiry-sender .email { font-weight: normal; color: #555; margin-left: 10px; }
  .inquiry-meta { font-size: 0.9rem; color: #777; }
  .inquiry-body { padding: 20px; line-height: 1.6; }
  .inquiry-actions { display: flex; gap: 10px; }
  .btn { padding: 8px 15px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;}
  .btn-read { background: #007bff; color: #fff; }
  .btn-delete { background: #dc3545; color: #fff; }
  .status-new { font-weight: bold; }
</style>
</head>
<body>
<div class="admin-container">
  <?php include 'admin_sidebar.php'; ?>
  <main class="main-content">
    <header class="main-header">
      <h1>Customer Inquiries</h1>
      <a href="logout.php" class="logout-button">Log Out</a>
    </header>

    <div class="card">
        <?php while ($row = $inquiries_result->fetch_assoc()): ?>
            <div class="inquiry <?= strtolower($row['status']) === 'new' ? 'status-new' : '' ?>">
                <div class="inquiry-header">
                    <div class="inquiry-sender">
                        <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                        <span class="email">&lt;<?= htmlspecialchars($row['email']) ?>&gt;</span>
                    </div>
                    <div class="inquiry-meta">
                        Received: <?= date("M d, Y h:i A", strtotime($row['received_at'])) ?>
                    </div>
                </div>
                <div class="inquiry-body">
                    <?= nl2br(htmlspecialchars($row['message'])) ?>
                </div>
                <div class="inquiry-actions" style="padding: 0 20px 15px 20px;">
                    <?php if (strtolower($row['status']) === 'new'): ?>
                        <a href="?action=read&id=<?= $row['id'] ?>" class="btn btn-read"><i class="fas fa-check"></i> Mark as Read</a>
                    <?php endif; ?>
                    <a href="?action=delete&id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this inquiry?')"><i class="fas fa-trash"></i> Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
        <?php if ($inquiries_result->num_rows == 0): ?>
            <p>You have no new inquiries.</p>
        <?php endif; ?>
    </div>
  </main>
</div>
</body>
</html>