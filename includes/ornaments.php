<?php
/**
 * İşrâkiyye — ortak SVG süslemeleri ve küçük yardımcılar.
 */

if (!function_exists('nur_star_svg')) {
    /**
     * Sekiz köşeli nûr yıldızı (rub el hizb) — marka işareti.
     */
    function nur_star_svg(string $class = '', int $size = 20): string
    {
        $cls = $class !== '' ? ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"' : '';
        return '<svg' . $cls . ' width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" '
            . 'stroke="currentColor" stroke-width="1.05" stroke-linejoin="round" aria-hidden="true">'
            . '<rect x="5.6" y="5.6" width="12.8" height="12.8"/>'
            . '<rect x="5.6" y="5.6" width="12.8" height="12.8" transform="rotate(45 12 12)"/>'
            . '<circle cx="12" cy="12" r="2.4" stroke-opacity=".9"/>'
            . '<circle cx="12" cy="1.9" r=".75" fill="currentColor" stroke="none"/>'
            . '<circle cx="12" cy="22.1" r=".75" fill="currentColor" stroke="none"/>'
            . '<circle cx="1.9" cy="12" r=".75" fill="currentColor" stroke="none"/>'
            . '<circle cx="22.1" cy="12" r=".75" fill="currentColor" stroke="none"/>'
            . '</svg>';
    }
}

if (!function_exists('nur_mandala_svg')) {
    /**
     * On altı ışınlı nûr mührü — kahraman bölümündeki döner mühür.
     */
    function nur_mandala_svg(string $class = ''): string
    {
        $cls = $class !== '' ? ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"' : '';
        $rays = '';
        for ($i = 0; $i < 16; $i++) {
            $a = deg2rad($i * 22.5);
            $x1 = 50 + cos($a) * 20;
            $y1 = 50 + sin($a) * 20;
            $x2 = 50 + cos($a) * 45;
            $y2 = 50 + sin($a) * 45;
            $o = ($i % 2 === 0) ? '.85' : '.35';
            $rays .= '<line x1="' . round($x1, 2) . '" y1="' . round($y1, 2) . '" x2="' . round($x2, 2)
                . '" y2="' . round($y2, 2) . '" stroke-opacity="' . $o . '"/>';
        }
        $poly = '';
        foreach ([46, 36, 26] as $k => $r) {
            $pts = [];
            for ($i = 0; $i < 8; $i++) {
                $a = deg2rad($i * 45 - 22.5);
                $pts[] = round(50 + cos($a) * $r, 2) . ',' . round(50 + sin($a) * $r, 2);
            }
            $poly .= '<polygon points="' . implode(' ', $pts) . '" stroke-opacity="' . (0.55 - $k * 0.12) . '"/>';
        }
        return '<svg' . $cls . ' viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width=".7" aria-hidden="true">'
            . $rays . $poly
            . '<circle cx="50" cy="50" r="6" stroke-opacity=".9"/>'
            . '<circle cx="50" cy="50" r="2.2" fill="currentColor" stroke="none" fill-opacity=".9"/>'
            . '</svg>';
    }
}

if (!function_exists('nur_arrow_svg')) {
    function nur_arrow_svg(): string
    {
        return '<svg class="arrow" width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" '
            . 'stroke-width="1.1" aria-hidden="true"><path d="M0 5h12.4M8.6 1l4 4-4 4"/></svg>';
    }
}

if (!function_exists('nur_divider')) {
    /**
     * Altın ince çizgi + ortada nûr yıldızı.
     */
    function nur_divider(string $extra = ''): string
    {
        return '<div class="title-ornament ' . $extra . '" aria-hidden="true"></div>';
    }
}
