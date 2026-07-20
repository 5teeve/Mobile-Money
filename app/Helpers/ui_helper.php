<?php

/**
 * Petits helpers de présentation partagés entre les vues client et admin.
 * Aucune logique métier ici : uniquement du rendu (icônes, chips).
 */

if (! function_exists('ui_icon')) {
    /**
     * Rend une icône SVG inline (trait, 20x20, currentColor).
     */
    function ui_icon(string $name, string $class = 'icon'): string
    {
        $paths = [
            'wallet-down' => '<path d="M3 7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/><path d="M16 12h2"/><path d="M9 3v3M9 14v-4M6.5 12H9m0 0 2.5-2.5M9 12l2.5 2.5"/>',
            'wallet-up'   => '<path d="M3 7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/><path d="M16 12h2"/><path d="M9 3v3M9 14v-4M6.5 9.5H9m0 0 2.5 2.5M9 9.5 6.5 12"/>',
            'history'     => '<path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v4.5H7.5"/><path d="M12 8v4l3 2"/>',
            'logout'      => '<path d="M9 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
            'phone'       => '<rect x="6" y="2" width="12" height="20" rx="2.5"/><path d="M11 18h2"/>',
            'chevron'     => '<path d="M9 6l6 6-6 6"/>',
            'edit'        => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
            'trash'       => '<path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/>',
            'check'       => '<circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.3 2.3L16 10"/>',
            'alert'       => '<path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.3 3.9 2.6 17a2 2 0 0 0 1.7 3h15.4a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>',
            'in'          => '<path d="M7 7l10 10"/><path d="M9 17H7v-2"/><path d="M17 9V7h-2"/>',
            'out'         => '<path d="M7 17 17 7"/><path d="M9 7h8v8"/>',
            'plus'        => '<path d="M12 5v14M5 12h14"/>',
            'users'       => '<circle cx="9" cy="8" r="3.2"/><path d="M3.5 19c.7-3 3-5 5.5-5s4.8 2 5.5 5"/><circle cx="17" cy="9" r="2.4"/><path d="M15.5 13.2c1.9.4 3.4 1.9 4 4.8"/>',
            'coins'       => '<ellipse cx="9" cy="7" rx="6" ry="3"/><path d="M3 7v5c0 1.7 2.7 3 6 3s6-1.3 6-3V7"/><path d="M9 15v2c0 1.7 2.7 3 6 3s6-1.3 6-3v-9c0-1.1-1.2-2.1-3-2.6"/>',
            'sliders'     => '<path d="M4 6h9M17 6h3M4 18h3M11 18h9"/><circle cx="15" cy="6" r="2.2"/><circle cx="9" cy="18" r="2.2"/>',
            'bank'        => '<path d="M3 21h18"/><path d="M4 10h16v9H4z"/><path d="M12 3 2 9h20L12 3Z"/><path d="M8 13v3M12 13v3M16 13v3"/>',
        ];

        $inner = $paths[$name] ?? $paths['alert'];

        return '<svg class="' . esc($class, 'attr') . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $inner . '</svg>';
    }

    /**
     * Index de palette (0-4) dérivé du préfixe — doit rester identique
     * à prefixPaletteIndex() dans assets/js/app.js.
     */
    function ui_prefix_palette_index(string $prefixe): int
    {
        $sum = 0;
        foreach (str_split($prefixe) as $char) {
            $sum += (int) $char;
        }

        return $sum % 5;
    }

    /**
     * Chip coloré pour un préfixe (3 chiffres) ou un numéro complet
     * (dont on ne garde que les 3 premiers chiffres).
     */
    function ui_prefix_chip(string $numeroOuPrefixe): string
    {
        $prefixe = substr($numeroOuPrefixe, 0, 3);
        $idx     = ui_prefix_palette_index($prefixe);

        return '<span class="chip chip--' . $idx . '">' . esc($prefixe) . '</span>';
    }
}
