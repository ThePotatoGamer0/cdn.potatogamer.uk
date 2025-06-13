<?php
$uploadDir = __DIR__ . '/files/';
$maxFileSize = 50 * 1024 * 1024; // 50 MB max

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['file'])) {
        $message = "No file uploaded.";
    } else {
        $file = $_FILES['file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $message = "Upload error code: " . $file['error'];
        } elseif ($file['size'] > $maxFileSize) {
            $message = "File is too large. Max size is 50MB.";
        } else {
            // Sanitize filename (remove spaces and unsafe chars)
            $filename = basename($file['name']);
            $filename = preg_replace('/[^A-Za-z0-9._-]/', '_', $filename);

            // If file exists, add a timestamp to filename
            $targetFile = $uploadDir . $filename;
            if (file_exists($targetFile)) {
                $filename = time() . "_" . $filename;
                $targetFile = $uploadDir . $filename;
            }

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                $link = "https://cdn.potatogamer.uk/" . urlencode($filename);
                $message = "File uploaded successfully! Link: <a href=\"$link\">$link</a>";
            } else {
                $message = "Failed to move uploaded file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Upload File - cdn.potatogamer.uk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col items-center justify-center p-4">
  <div class="bg-gray-800 p-6 rounded shadow max-w-md w-full">
    <h1 class="text-2xl font-bold mb-4">Upload a File</h1>
    <?php if ($message): ?>
      <p class="mb-4 text-green-400"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="flex flex-col space-y-4">
      <input type="file" name="file" required class="text-black p-2 rounded" />
      <button type="submit" class="bg-pink-500 hover:bg-pink-600 rounded py-2 font-semibold">Upload</button>
    </form>
  </div>
</body>
</html>
