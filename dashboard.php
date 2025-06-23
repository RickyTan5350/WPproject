<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Dashboard";
include("templates/headerdashboard.php");
?>

<h2>UTM Hall Booking System</h2>

<div class="dashboard-grid">
<?php
switch ($_SESSION['role']) {
    case 'admin':
        echo "
            <a href='admin/manage_users.php' class='menu-card'>
                <h3>👥 Manage Users</h3>
                <p>Add, edit or delete users in the system.</p>
            </a>
            <a href='admin/add_user.php' class='menu-card'>
                <h3>➕ Add New User</h3>
                <p>Register a new system user.</p>
            </a>
        ";
        break;

    case 'student':
        echo "
            <a href='student/book_hall.php' class='menu-card'>
                <h3>🏛️ Book a Hall</h3>
                <p>Submit a booking request for an event or meeting.</p>
            </a>
            <a href='student/view_status.php' class='menu-card'>
                <h3>📑 View Booking Status</h3>
                <p>Check your booking request status.</p>
            </a>
            <a href='student/profile.php' class='menu-card'>
                <h3>🙍‍♂️ Profile</h3>
                <p>View and update your profile information.</p>
            </a>
        ";
        break;

    case 'manager':
        echo "
            <a href='hall_manager/approve_bookings.php' class='menu-card'>
                <h3>✔️ Approve/Reject Bookings</h3>
                <p>Manage booking approvals and availability.</p>
            </a>
            <a href='hall_manager/report.php' class='menu-card'>
                <h3>📊 View Reports</h3>
                <p>Review hall booking reports and records.</p>
            </a>
            <a href='hall_manager/profile.php' class='menu-card'>
                <h3>🙍‍♂️ Profile</h3>
                <p>View and update your manager profile.</p>
            </a>
        ";
        break;

    default:
        echo "<p>Unauthorized role. Please contact administrator.</p>";
}
?>
</div>

<?php include("templates/footer.php"); ?>