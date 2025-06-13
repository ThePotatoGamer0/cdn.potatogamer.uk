<?php
$file = basename(urldecode($_SERVER['REQUEST_URI']));
$path = __DIR__ . '/files/' . $file;

function formatSize($bytes) {
    $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
    return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
}

if (empty($file) || !file_exists($path) || !is_file($path)) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$size = filesize($path);
$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
$mime = mime_content_type($path);

// Define icon map
$iconMap = [
    'zip' => 'file-archive', 'rar' => 'file-archive', '7z' => 'file-archive',
    'mp3' => 'file-audio', 'wav' => 'file-audio', 'ogg' => 'file-audio',
    'mp4' => 'file-video', 'mkv' => 'file-video', 'mov' => 'file-video',
    'jpg' => 'file-image', 'jpeg' => 'file-image', 'png' => 'file-image',
    'gif' => 'file-image', 'webp' => 'file-image',
    'pdf' => 'file-text', 'txt' => 'file-text',
    'json' => 'file-json', 'js' => 'file-code', 'html' => 'file-code', 'css' => 'file-code',
    'glb' => 'file-box', 'gltf' => 'file-box', 'fbx' => 'file-box', 'obj' => 'file-box',
    'key' => 'file-key', 'keys' => 'file-key',
];

$iconName = $iconMap[$ext] ?? 'file';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($file); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen px-4">

  <div class="bg-gray-800 p-6 rounded-lg max-w-md w-full shadow-lg">
    <div class="flex items-center space-x-4 mb-4">
      <div class="text-white w-12 h-12 flex-shrink-0">
        <i data-lucide="<?php echo $iconName; ?>" class="w-12 h-12 stroke-1.5"></i>
      </div>
      <div>
        <h1 class="text-xl font-bold"><?php echo htmlspecialchars($file); ?></h1>
        <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($mime); ?> · <?php echo formatSize($size); ?></p>
      </div>
    </div>
    <a href="/files/<?php echo urlencode($file); ?>" download class="block w-full bg-pink-500 hover:bg-pink-600 text-center px-4 py-2 rounded transition">
      ⬇ Download File
    </a>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
