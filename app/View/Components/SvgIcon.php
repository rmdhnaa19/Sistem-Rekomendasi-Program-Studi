<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SvgIcon extends Component
{
    public $icon;
    public $class;

    public function __construct($icon, $class = null)
    {
        $this->icon = $icon;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $path = resource_path("svg/{$this->icon}.svg");

        if (file_exists($path)) {
            $svg = file_get_contents($path);

            // Tambahkan class ke elemen <svg>, jika ada
            if ($this->class) {
                $svg = preg_replace('/<svg /', "<svg class=\"{$this->class}\" ", $svg, 1);
            }

            return $svg;
        }

        // Jika file tidak ditemukan, bisa mengembalikan pesan atau file fallback
        return '';
    }
}

