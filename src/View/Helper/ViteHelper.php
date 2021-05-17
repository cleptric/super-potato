<?php
declare(strict_types=1);
namespace App\View\Helper;

use Assert\Assertion;
use Cake\View\Helper;
use RuntimeException;

/**
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class ViteHelper extends Helper
{

    /**
     * @var array<string>
     */
    public $helpers = [
        'Html',
    ];

    /**
     * @inheritDoc
     */
    protected $_defaultConfig = [
        'host' => 'http://localhost:3000/build/',
        'manifest' => 'manifest.json',
        'buildDirectory' => '/webroot/js/',
    ];

    /**
     * @var null|bool
     */
    protected ?bool $_devServerEnabled = null;

    /**
     * @var array|null
     */
    private ?array $_manifestData = null;

    public function init()
    {
        if ($this->isDevServerEnabled()) {
            return $this->script('@vite/client', [
                'type' => 'module',
            ]);
        }
    }

    public function isDevServerEnabled(): bool
    {
        // Do not ping the dev server multiple times.
        if (\is_bool($this->_devServerEnabled)) {
            return $this->_devServerEnabled;
        }

        if (env('DEBUG', false)) {
            return $this->_devServerEnabled = false;
        }

        $this->_devServerEnabled = \file_exists($this->_getManifestFilePath()) === false;

        return $this->_devServerEnabled;
    }

    protected function _getManifestFilePath(): string
    {
        return  ROOT . $this->getConfig('buildDirectory') . $this->getConfig('manifest');
    }

    protected function _resolveDevServerFileName(string $file): string
    {
        return $this->getConfig('host') . $file;
    }

    protected function _stripSlashes(string &$path): void
    {
        $path = preg_replace('#/+#', '/', $path);
    }

    protected function resolveImports(string $prefix, string $file, array $options, string &$out, array &$visited): void
    {
        if (in_array($file, $visited)) {
            return;
        }
        $visited[] = $file;

        $data = $this->_manifestData[$file];

        foreach ($data['imports'] ?? [] as $import) {
            $this->resolveImports($prefix, $import, $options, $out, $visited);
        }

        $out .= $this->Html->script($prefix . $data['file'], $options);
    }

    protected function _resolveFileName(string $file, array $options): ?string
    {
        if ($this->_manifestData === null) {
            $manifestData = $this->_loadManifest();
            $this->_manifestData = &$manifestData;
        } else {
            $manifestData = &$this->_manifestData;
        }

        $this->_stripSlashes($file);

        assert(
            \array_key_exists(
                $file,
                $manifestData
            ),
            $file
        );

        $prefix = $this->getConfig('publicDirectory', '/js/');

        $out = '';
        $visited = [];

        $this->resolveImports($prefix, $file, $options, $out, $visited);

        return $out;
    }

    protected function _loadManifest(): array
    {
        $path = $this->_getManifestFilePath();

        assert(file_exists($path));

        $fileContent = \file_get_contents($path);

        return \json_decode($fileContent, true);
    }

    public function script(string $script, array $options = []): ?string {
        $options = ['type' => 'module'] + $options;

        if ($this->isDevServerEnabled()) {
            // Screw options; I have Webpack!
            return $this->Html->script(
                $this->_resolveDevServerFileName($script),
                $options
            );
        }

        return $this->_resolveFileName($script, $options);
    }
}