<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>404 Not Found</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col justify-center items-center min-h-screen px-4">

  <div class="text-center flex-grow flex flex-col justify-center">
    <h1 class="text-5xl font-bold mb-4">404</h1>
    <p class="text-xl mb-2">File Not Found</p>
    <p class="text-gray-400 max-w-md mx-auto">
      Sorry, the file you requested 
      <code class="bg-gray-800 px-2 py-1 rounded text-pink-400"><?php echo htmlspecialchars(basename(urldecode($_SERVER['REQUEST_URI']))); ?></code>
      does not exist.
    </p>
  </div>

  <footer class="text-center text-gray-500 text-sm mt-8 mb-4">
    cdn.potatogamer.uk the 
    <a href="https://github.com/ThePotatoGamer0/cdn.potatogamer.uk" target="_blank" rel="noopener noreferrer" class="underline hover:text-pink-400">
      open source
    </a> 
    CDN.
  </footer>

</body>
</html>
