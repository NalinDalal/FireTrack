<?php
session_start();
if ($_SESSION['access_level'] == 'admin') {
    include "head.php";
    include "../dbcon.php";
    include "topandsidenav.php";
    date_default_timezone_set("Asia/Kolkata");

    if (isset($_POST['upload'])) {
        $report_id = $_POST['report_id'];
        $target_dir = "uploads/nocs/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($_FILES["noc_file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("pdf", "doc", "docx", "jpg", "jpeg", "png");

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["noc_file"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO noc_reports (report_id, noc_path, uploaded_at) VALUES (?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $report_id, $target_file);
                if ($stmt->execute()) {
                    echo "<script>alert('NOC uploaded successfully!'); window.location.href='noc_upload.php';</script>";
                } else {
                    echo "<script>alert('Database error. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('File upload failed. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Allowed types: PDF, DOC, DOCX, JPG, PNG.');</script>";
        }
    }
?>

<div class="card-body position-relative">
    <h3>Upload NOC for Fire Report</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Report ID</label>
            <input type="text" class="form-control" name="report_id" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload NOC File</label>
            <input type="file" class="form-control" name="noc_file" required>
        </div>
        <button type="submit" class="btn btn-primary" name="upload">Upload</button>
    </form>
</div>

<?php include "footer.php"; } else { echo "<script>window.location.href = '../index.php';</script>"; } ?>

