<?php

/**
 * Tally form embed partial
 *
 * Renders an embedded Tally form. The form ID is read from config.php.
 * To change the form, update 'tally_form_id' in src/config.php.
 */

$langConfig = $config[$lang] ?? $config['en'];
$tallyFormId = $langConfig['tally_form_id'] ?? 'ODzbkp';

?>
<div class="w-full my-4">
    <iframe
        data-tally-src="https://tally.so/embed/<?php echo $tallyFormId; ?>?alignLeft=1&transparentBackground=1&dynamicHeight=1"
        loading="lazy"
        width="100%"
        height="3457"
        frameborder="0"
        marginheight="0"
        marginwidth="0"
        title="<?php echo $t['service.heading'] ?? 'Service Request Form'; ?>"
    ></iframe>
    <script>var d=document,w="https://tally.so/widgets/embed.js",v=function(){"undefined"!=typeof Tally?Tally.loadEmbeds():d.querySelectorAll("iframe[data-tally-src]:not([src])").forEach((function(e){e.src=e.dataset.tallySrc}))};if("undefined"!=typeof Tally)v();else if(d.querySelector('script[src="'+w+'"]')==null){var s=d.createElement("script");s.src=w,s.onload=v,s.onerror=v,d.body.appendChild(s);}</script>
</div>
