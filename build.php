#!/usr/bin/env php
<?php

/**
 * Static Site Builder for Forms Microsite
 *
 * Processes PHP files in src/pages/ directory and outputs static HTML to dist/
 * Maintains directory structure for clean URLs (service.php → service/index.html).
 */

class SiteBuilder
{
    private string $srcDir;
    private string $distDir;
    private array $builtFiles = [];

    public function __construct(string $srcDir = 'src', string $distDir = 'dist')
    {
        $this->srcDir = realpath($srcDir);
        $this->distDir = $distDir;

        if (!$this->srcDir) {
            throw new Exception("Source directory '{$srcDir}' does not exist");
        }
    }

    public function build(): void
    {
        echo "🔨 Building static site...\n\n";

        $this->cleanDistDirectory();
        $this->createDistDirectory();
        $this->processPhpFiles();
        $this->create404Page();
        $this->copyAssets();
        $this->copyFavicons();

        echo "\n✅ Build complete! Built " . count($this->builtFiles) . " pages.\n";
        echo "📁 Output directory: {$this->distDir}/\n";
    }

    private function cleanDistDirectory(): void
    {
        if (is_dir($this->distDir)) {
            echo "🧹 Cleaning dist directory...\n";
            $this->removeDirectory($this->distDir);
        }
    }

    private function createDistDirectory(): void
    {
        if (!mkdir($this->distDir, 0755, true)) {
            throw new Exception("Failed to create dist directory");
        }
    }

    private function processPhpFiles(): void
    {
        echo "📄 Processing PHP files...\n";

        $pagesDir = "{$this->srcDir}/pages";
        $phpFiles = $this->findPhpFiles($pagesDir);

        if (empty($phpFiles)) {
            throw new Exception("No PHP files found in src/pages directory");
        }

        foreach ($phpFiles as $file) {
            $this->processPhpFile($file, $pagesDir);
        }
    }

    private function findPhpFiles(string $dir): array
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }

        sort($files);
        return $files;
    }

    private function processPhpFile(string $file, string $pagesDir): void
    {
        // Get relative path from pages dir
        $relativePath = substr($file, strlen($pagesDir) + 1);

        // Convert .php to directory-based index.html for clean URLs
        // index.php → index.html (same dir), foo.php → foo/index.html
        $basename = basename($relativePath, '.php');
        $dirPart = dirname($relativePath);
        if ($basename === 'index') {
            $outputRelative = ($dirPart === '.' ? '' : $dirPart . '/') . 'index.html';
        } else {
            $outputRelative = ($dirPart === '.' ? '' : $dirPart . '/') . $basename . '/index.html';
        }
        $outputPath = "{$this->distDir}/{$outputRelative}";

        echo "  • pages/{$relativePath} → {$outputRelative}\n";

        // Create output directory if needed
        $outputDir = dirname($outputPath);
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        // Change to src directory so partials/i18n includes work with relative paths
        $originalDir = getcwd();
        chdir($this->srcDir);

        // Capture PHP output
        ob_start();
        try {
            include 'pages/' . $relativePath;
            $content = ob_get_clean();
        } catch (Exception $e) {
            ob_end_clean();
            chdir($originalDir);
            throw new Exception("Error processing {$file}: " . $e->getMessage());
        }

        chdir($originalDir);

        // Write static HTML
        if (file_put_contents($outputPath, $content) === false) {
            throw new Exception("Failed to write {$outputPath}");
        }

        $this->builtFiles[] = $outputRelative;
    }

    private function create404Page(): void
    {
        echo "🔄 Creating 404 redirect page...\n";

        $content = <<<'HTML'
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Page Not Found</title>
    <script>
        // Redirect .php URLs to .html equivalents
        (function() {
            const path = window.location.pathname;
            
            // Check if URL ends with .php
            if (path.endsWith('.php')) {
                // Replace .php with .html and redirect
                const newPath = path.replace(/\.php$/, '.html');
                window.location.replace(newPath);
            }
        })();
    </script>
</head>
<body>
    <h1>404 - Page Not Found</h1>
    <p>Redirecting...</p>
</body>
</html>
HTML;

        file_put_contents("{$this->distDir}/404.html", $content);
        echo "  • 404.html created for .php → .html redirects\n";
    }

    private function copyAssets(): void
    {
        $assetsDir = "{$this->srcDir}/assets";

        if (!is_dir($assetsDir)) {
            echo "⚠️  No assets directory found, skipping...\n";
            return;
        }

        echo "📦 Copying assets...\n";

        $this->copyDirectory($assetsDir, "{$this->distDir}/assets");
    }

    private function copyFavicons(): void
    {
        echo "🎨 Copying favicon files...\n";

        $faviconFiles = ['favicon.ico', 'favicon.gif'];

        foreach ($faviconFiles as $favicon) {
            $source = dirname($this->srcDir) . "/{$favicon}";
            if (file_exists($source)) {
                copy($source, "{$this->distDir}/{$favicon}");
                echo "  • {$favicon}\n";
            }
        }
    }

    private function copyDirectory(string $source, string $dest): void
    {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        $items = scandir($source);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..' || $item === '.DS_Store') {
                continue;
            }

            $sourcePath = "{$source}/{$item}";
            $destPath = "{$dest}/{$item}";

            if (is_dir($sourcePath)) {
                $this->copyDirectory($sourcePath, $destPath);
            } else {
                copy($sourcePath, $destPath);
            }
        }
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = "{$dir}/{$item}";

            if (is_dir($path)) {
                $this->removeDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }

    public function getBuiltFiles(): array
    {
        return $this->builtFiles;
    }
}

// Only run when executed directly, not when included by tests
if (realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME'] ?? '')) {
    try {
        $builder = new SiteBuilder();
        $builder->build();
        exit(0);
    } catch (Exception $e) {
        echo "❌ Build failed: " . $e->getMessage() . "\n";
        exit(1);
    }
}
