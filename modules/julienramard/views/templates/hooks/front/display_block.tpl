{foreach $commentaryList as $commentary}
    <div class="panel"{if $commentary.border_size} style="border: solid {$commentary.border_size}px black"{/if}>
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