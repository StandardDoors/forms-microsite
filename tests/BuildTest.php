<?php

namespace Forms\Tests;

use PHPUnit\Framework\TestCase;

class BuildTest extends TestCase
{
    private string $testDistDir = 'dist-test';

    protected function setUp(): void
    {
        // Clean test dist directory before each test
        if (is_dir($this->testDistDir)) {
            $this->removeDirectory($this->testDistDir);
        }
    }

    protected function tearDown(): void
    {
        // Clean up after tests
        if (is_dir($this->testDistDir)) {
            $this->removeDirectory($this->testDistDir);
        }
    }

    public function testBuildCreatesDistDirectory(): void
    {
        $this->buildSite();

        $this->assertDirectoryExists($this->testDistDir);
    }

    public function testBuildGeneratesHtmlFiles(): void
    {
        $this->buildSite();

        $htmlFiles = $this->findHtmlFiles($this->testDistDir);

        $this->assertNotEmpty($htmlFiles, 'No HTML files generated');
    }

    public function testBuildCreatesLanguageDirectories(): void
    {
        $this->buildSite();

        $this->assertDirectoryExists("{$this->testDistDir}/en", 'English directory not created');
        $this->assertDirectoryExists("{$this->testDistDir}/fr", 'French directory not created');
    }

    public function testBuildCopiesAssets(): void
    {
        $this->buildSite();

        $assetsDir = "{$this->testDistDir}/assets";
        $this->assertDirectoryExists($assetsDir, 'Assets directory not copied');
    }

    public function testBuildCreates404Page(): void
    {
        $this->buildSite();

        $this->assertFileExists("{$this->testDistDir}/404.html", '404 page not created');
    }

    public function testGeneratedFilesContainExpectedContent(): void
    {
        $this->buildSite();

        $enFile = "{$this->testDistDir}/en/index.html";

        if (file_exists($enFile)) {
            $content = file_get_contents($enFile);

            // Verify that PHP has been processed and not left as raw code
            $this->assertStringNotContainsString('<?php', $content, 'PHP tags found in output');
            $this->assertStringContainsString('Standard', $content, 'Expected content not found');
        }
    }

    public function testCleanUrlStructure(): void
    {
        $this->buildSite();

        // Service pages should be in their own directories
        $this->assertFileExists(
            "{$this->testDistDir}/en/service/index.html",
            'English service page not in clean URL structure'
        );
        $this->assertFileExists(
            "{$this->testDistDir}/fr/service/index.html",
            'French service page not in clean URL structure'
        );
    }

    public function testAllSourceFilesAreProcessed(): void
    {
        $this->buildSite();

        $sourceFiles = $this->findPhpFiles('src/pages');
        $outputFiles = $this->findHtmlFiles($this->testDistDir);

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

    private function buildSite(): void
    {
        require_once __DIR__ . '/../build.php';

        $builder = new \SiteBuilder('src', $this->testDistDir);
        $builder->build();
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
}
