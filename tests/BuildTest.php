<?php

namespace Forms\Tests;

use PHPUnit\Framework\TestCase;

class BuildTest extends TestCase
{
    private static string $testDistDir = 'dist-test';

    public static function setUpBeforeClass(): void
    {
        // Build once for all tests in this class.
        if (is_dir(self::$testDistDir)) {
            self::removeDirectoryRecursive(self::$testDistDir);
        }

        require_once __DIR__ . '/../build.php';

        $builder = new \SiteBuilder('src', self::$testDistDir);
        $builder->build();
    }

    public static function tearDownAfterClass(): void
    {
        // Clean up after all tests in this class.
        if (is_dir(self::$testDistDir)) {
            self::removeDirectoryRecursive(self::$testDistDir);
        }
    }

    public function testBuildCreatesDistDirectory(): void
    {
        $this->assertDirectoryExists(self::$testDistDir);
    }

    public function testBuildGeneratesHtmlFiles(): void
    {
        $htmlFiles = $this->findHtmlFiles(self::$testDistDir);

        $this->assertNotEmpty($htmlFiles, 'No HTML files generated');
    }

    public function testBuildCreatesLanguageDirectories(): void
    {
        $this->assertDirectoryExists(self::$testDistDir . '/en', 'English directory not created');
        $this->assertDirectoryExists(self::$testDistDir . '/fr', 'French directory not created');
    }

    public function testBuildCopiesAssets(): void
    {
        $assetsDir = self::$testDistDir . '/assets';
        $this->assertDirectoryExists($assetsDir, 'Assets directory not copied');
    }

    public function testBuildCreates404Page(): void
    {
        $this->assertFileExists(self::$testDistDir . '/404.html', '404 page not created');
    }

    public function testGeneratedFilesContainExpectedContent(): void
    {
        $enFile = self::$testDistDir . '/en/index.html';

        if (file_exists($enFile)) {
            $content = file_get_contents($enFile);

            // Verify that PHP has been processed and not left as raw code
            $this->assertStringNotContainsString('<?php', $content, 'PHP tags found in output');
            $this->assertStringContainsString('Standard', $content, 'Expected content not found');
        }
    }

    public function testCleanUrlStructure(): void
    {

        // Service pages should be in their own directories
        $this->assertFileExists(
            self::$testDistDir . '/en/service/index.html',
            'English service page not in clean URL structure'
        );
        $this->assertFileExists(
            self::$testDistDir . '/fr/service/index.html',
            'French service page not in clean URL structure'
        );
    }

    public function testAllSourceFilesAreProcessed(): void
    {

        $sourceFiles = $this->findPhpFiles('src/pages');
        $outputFiles = $this->findHtmlFiles(self::$testDistDir);

        // Exclude generated files that don't correspond to source pages
        $generatedPages = array_filter(
            $outputFiles,
            fn($f) => basename($f) !== '404.html'
        );

        $this->assertCount(
            count($sourceFiles),
            $generatedPages,
            'Number of output pages does not match source files'
        );
    }


    private function findHtmlFiles(string $dir): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->getExtension() === 'html') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private function findPhpFiles(string $dir): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private static function removeDirectoryRecursive(string $dir): void
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
                self::removeDirectoryRecursive($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }
}
