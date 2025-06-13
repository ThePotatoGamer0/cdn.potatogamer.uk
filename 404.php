<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 Not Found</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center h-screen">
  <div class="text-center">
    <h1 class="text-5xl font-bold mb-4">404</h1>
    <p class="text-xl mb-2">File Not Found</p>
    <p class="text-gray-400">
    Sorry, the file you requested 
    <code class="bg-gray-800 px-2 py-1 rounded text-pink-400"><?php echo htmlspecialchars(basename(urldecode($_SERVER['REQUEST_URI']))); ?></code>
    does not exist.
    </p>
  </div>
</body>
</html>
