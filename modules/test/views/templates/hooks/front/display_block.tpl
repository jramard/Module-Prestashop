{foreach $commentaryList as $commentary}
    <div class="panel">
        <div class="panel-header">
            <h4>
                {l s='Commentary' mod='test'}
                #{$commentary.id_testproduct|intval}
            </h4>
        </div>
        <div class="panel-body">
            {$commentary.commentary|escape:'htmlall':'UTF-8'}
        </div>
    </div>
{/foreach}