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
    // Archives
    'zip'   => 'file-archive',
    'rar'   => 'file-archive',
    '7z'    => 'file-archive',
    'tar'   => 'file-archive',
    'gz'    => 'file-archive',
    'bz2'   => 'file-archive',
    'xz'    => 'file-archive',
    'iso'   => 'file-archive',

    // Audio
    'mp3'   => 'file-audio',
    'wav'   => 'file-audio',
    'ogg'   => 'file-audio',
    'flac'  => 'file-audio',
    'aac'   => 'file-audio',
    'm4a'   => 'file-audio',
    'wma'   => 'file-audio',
    'alac'  => 'file-audio',

    // Video
    'mp4'   => 'file-video',
    'mkv'   => 'file-video',
    'mov'   => 'file-video',
    'avi'   => 'file-video',
    'flv'   => 'file-video',
    'wmv'   => 'file-video',
    'webm'  => 'file-video',
    'm4v'   => 'file-video',
    '3gp'   => 'file-video',

    // Images
    'jpg'   => 'file-image',
    'jpeg'  => 'file-image',
    'png'   => 'file-image',
    'gif'   => 'file-image',
    'webp'  => 'file-image',
    'bmp'   => 'file-image',
    'tiff'  => 'file-image',
    'svg'   => 'file-image',
    'heic'  => 'file-image',
    'ico'   => 'file-image',

    // Documents / Text
    'pdf'   => 'file-text',
    'txt'   => 'file-text',
    'rtf'   => 'file-text',
    'md'    => 'file-text',
    'log'   => 'file-text',
    'tex'   => 'file-text',

    // Code / markup
    'json'  => 'file-json',
    'js'    => 'file-code',
    'jsx'   => 'file-code',
    'ts'    => 'file-code',
    'tsx'   => 'file-code',
    'html'  => 'file-code',
    'htm'   => 'file-code',
    'css'   => 'file-code',
    'scss'  => 'file-code',
    'less'  => 'file-code',
    'xml'   => 'file-code',
    'yaml'  => 'file-code',
    'yml'   => 'file-code',
    'php'   => 'file-code',
    'py'    => 'file-code',
    'rb'    => 'file-code',
    'java'  => 'file-code',
    'c'     => 'file-code',
    'cpp'   => 'file-code',
    'h'     => 'file-code',
    'cs'    => 'file-code',
    'go'    => 'file-code',
    'sh'    => 'file-code',
    'bat'   => 'file-code',
    'pl'    => 'file-code',
    'swift' => 'file-code',
    'kt'    => 'file-code',
    'gradle'=> 'file-code',
    'sql'   => 'file-code',

    // 3D Models / CAD / 3D Printing
    'glb'   => 'file-box',
    'gltf'  => 'file-box',
    'fbx'   => 'file-box',
    'obj'   => 'file-box',
    'stl'   => 'file-box',
    '3ds'   => 'file-box',
    'blend' => 'file-box',
    'dae'   => 'file-box',
    'stp'   => 'file-box',
    'step'  => 'file-box',
    '3mf'   => 'file-box',
    'amf'   => 'file-box',
    'p3d'   => 'file-box',


    // Microsoft Office
    'doc'   => 'file-doc',
    'docx'  => 'file-doc',
    'xls'   => 'file-spreadsheet',
    'xlsx'  => 'file-spreadsheet',
    'ppt'   => 'file-presentation',
    'pptx'  => 'file-presentation',
    'csv'   => 'file-csv',

    // Key / License / Security files
    'key'   => 'file-key',
    'keys'  => 'file-key',
    'pem'   => 'file-lock',
    'cer'   => 'file-lock',
    'crt'   => 'file-lock',
    'der'   => 'file-lock',
    'p12'   => 'file-lock',
    'pfx'   => 'file-lock',
    'asc'   => 'file-lock',

    // Fonts
    'ttf'   => 'file-font',
    'otf'   => 'file-font',
    'woff'  => 'file-font',
    'woff2' => 'file-font',

    // Data / Database files
    'db'    => 'file-database',
    'sql'   => 'file-database',
    'sqlite'=> 'file-database',
    'mdb'   => 'file-database',
    'accdb' => 'file-database',

    // Email
    'eml'   => 'file-mail',
    'msg'   => 'file-mail',

    // Executables / Scripts
    'exe'   => 'file-exe',
    'dll'   => 'file-exe',
    'bat'   => 'file-exe',
    'sh'    => 'file-exe',
    'msi'   => 'file-exe',
    'app'   => 'file-exe',
    'bin'   => 'file-exe',

    // Disk images / Virtual disks
    'iso'   => 'file-archive',
    'vmdk'  => 'file-box',
    'vdi'   => 'file-box',
    'vhd'   => 'file-box',

    // Other common types
    'apk'   => 'file-archive',
    'deb'   => 'file-archive',
    'rpm'   => 'file-archive',
    'dmg'   => 'file-archive',

    // Medical / special files
    'dcm'   => 'file-medical',
    'dicom' => 'file-medical',

    // Misc / Unknown fallback
    'default' => 'file',
];


$iconName = $iconMap[$ext] ?? 'file';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($file); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col min-h-screen px-4">

  <main class="flex-grow flex flex-col justify-center items-center max-w-md w-full mx-auto">

    <div class="bg-gray-800 p-6 rounded-lg w-full shadow-lg">
      <div class="flex items-center space-x-4 w-full">
        <div class="text-white w-12 h-12 flex-shrink-0">
          <i data-lucide="<?php echo $iconName; ?>" class="w-12 h-12 stroke-1.5"></i>
        </div>
        <div class="flex flex-col">
          <h1 class="text-xl font-bold break-all"><?php echo htmlspecialchars($file); ?></h1>
          <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($mime); ?> · <?php echo formatSize($size); ?></p>
        </div>
      </div>
    </div>

    <a href="/files/<?php echo urlencode($file); ?>" download class="block w-full bg-pink-500 hover:bg-pink-600 text-center px-4 py-2 rounded transition mt-6">
       <i data-lucide="download" class="w-full stroke-1.5"></i>Download File
    </a>

  </main>

  <footer class="mt-12 mb-4 text-center text-gray-500 text-sm">
    cdn.potatogamer.uk the 
    <a href="https://github.com/ThePotatoGamer0/cdn.potatogamer.uk" target="_blank" rel="noopener noreferrer" class="underline hover:text-pink-400">
      open source
    </a> 
    CDN.
  </footer>

  <script>
  lucide.createIcons();

  // Icon name from PHP
  const iconName = '<?php echo $iconName; ?>';

  // Wait for lucide icons to be loaded
  if (window.lucide && lucide.icons && lucide.icons[iconName]) {
    const iconData = lucide.icons[iconName];

    // Construct SVG string with fixed viewBox and stroke color
    const svgString = `
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        ${iconData.toSvg()}
      </svg>
    `;

    // Encode SVG string for data URL
    const encoded = encodeURIComponent(svgString)
      .replace(/'/g, '%27')
      .replace(/"/g, '%22');

    // Create data URL
    const faviconURL = `data:image/svg+xml,${encoded}`;

    // Create or update favicon link tag
    let faviconTag = document.querySelector('link[rel="icon"]');
    if (!faviconTag) {
      faviconTag = document.createElement('link');
      faviconTag.rel = 'icon';
      document.head.appendChild(faviconTag);
    }
    faviconTag.href = faviconURL;
  }
  </script>
</body>
</html>
