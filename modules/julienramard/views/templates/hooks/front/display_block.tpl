{foreach $commentaryList as $commentary}
    <div
        class="panel"
        {strip}
        {if
            $commentary.border_size ||
            $commentary.border_color ||
            $commentary.border_radius ||
            $commentary.background_color ||
            $commentary.text_color ||
            $commentary.text_align ||
            $commentary.font_family
        }
        style="
            {if $commentary.border_size}
                border: solid {$commentary.border_size}px {if $commentary.border_color}{$commentary.border_color}{/if};
            {/if}
            {if $commentary.border_radius}
                border-radius: {$commentary.border_radius}px;
            {/if}
            {if $commentary.background_color}
                background-color: {$commentary.background_color};
            {/if}
            {if $commentary.text_color}
                color: {$commentary.text_color};
            {/if}
            {if $commentary.text_align}
                text-align: {$commentary.text_align};
            {/if}
            {if $commentary.font_family}
                font-family: {$commentary.font_family}, sans-serif;
            {/if}
        "
        {/if}
        {/strip}
    >
        <div class="panel-header">
            <h4>
                {l s='Commentary' mod='julienramard'}
                #{$commentary.id_julienramardproduct|intval}
            </h4>
        </div>
        <div class="panel-body">
            {$commentary.commentary|escape:'htmlall':'UTF-8'}
        </div>
    </div>
{/foreach}