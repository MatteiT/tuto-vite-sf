<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ViteAssetExtension  extends AbstractExtension
{
  public function getFunctions(): array
  {
    return [
      new TwigFunction('vite_asset', [$this, 'asset'], ['is_safe' => ['html']])
    ];
  }

  public function asset(string $entry, array $deps): string
  {
    $html = <<<HTML
<script type="module" src="http://localhost:5173/assets/@vite/client"></script>
HTML;

    if (in_array("react", $deps)) {
      $html .= '<script type="module">
        import RefreshRuntime from "http://localhost:5173/assets/@react-refresh"
        RefreshRuntime.injectIntoGlobalHook(window)
        window.$RefreshReg$ = () => {}
        window.$RefreshSig$ = () => (type) => type
        window.__vite_plugin_react_preamble_installed__ = true
      </script>';
    }

    $html .= <<<HTML
<script type="module" src="http://localhost:5173/assets/{$entry}" defer></script>;
HTML;

    return $html;
  }
}
