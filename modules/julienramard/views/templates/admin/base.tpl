<main 
    id="module-julienramard"
    class="{if version_compare($smarty.const._PS_VERSION_, '1.6', '<')}bootstrap{/if}">

    <form 
        method="post" 
        action="{$controllerLink}" 
        class="panel"
    >
        <input 
            type="hidden" 
            name="julienramardform"
            value="1" 
        />

        <header class="panel-header">
            <h3>
                {l s='Configuration' mod='julienramard'}
            </h3>
        </header>

        <div class="panel-body">
            {if $is_success}
                <div class="alert alert-success">
                    <p>{l s='Les données ont bien été enregistrées !' mod='julienramard'}</p>
                </div>
            {/if}

            {if $has_error}
                <div class="alert alert-danger">
                    <p>{l s='Une erreur a été détectée !' mod='julienramard'}</p>
                </div>
            {/if}

            {if in_array('product_id', $error)}
                <div class="alert alert-danger">
                    <p>{l s='Product ID incorrect, veuillez saisir un chiffre.' mod='julienramard'}</p>
                </div>
            {/if}

            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        {l s='Product ID' mod='julienramard'}
                    </h4>
                    <div class="form-group">
                        <div class="margin-form">
                            <select
                                name="product_id"
                                id="product_id"
                                class="form-control">
                                <option value="">
                                    > {l s='Select an ID' mod='julienramard'}
                                </option>
                                {foreach $productIdList as $productId}
                                    <option value="{$productId.id_product|intval}">
                                        {$productId.id_product|intval}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        {l s='Commentary' mod='julienramard'}
                    </h4>
                    <div class="form-group">
                        <div class="margin-form">
                            <input
                                type="text"
                                name="commentary"
                                id="commentary"
                                class="form-control"
                                value="{$commentary|escape:'htmlall':'UTF-8'}"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {if in_array('is_enabled', $error)}
                <div class="alert alert-danger">
                    <p>
                        {l s='Valeur incorrecte, n\'essayez pas de tricher !' mod='julienramard'}
                    </p>
                </div>
            {/if}

            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        {l s='Is enabled' mod='julienramard'}
                    </h4>
                    <div class="form-group">
                        <div class="margin-form">
                            <span class="switch prestashop-switch">
                                <input 
                                    type="radio" 
                                    name="is_enabled"
                                    id="is_enabled_1"
                                    value="1" 
                                    {if $is_enabled}checked="checked"{/if}
                                />
                                <label for="is_enabled_1">{l s='Enabled' mod='julienramard'}</label>
                                <input 
                                    type="radio" 
                                    name="is_enabled"
                                    id="is_enabled_0"
                                    value="0" 
                                    {if !$is_enabled}checked="checked"{/if}
                                />
                                <label for="is_enabled_0">{l s='Disabled' mod='julienramard'}</label>
                                <a class="slide-button btn"></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {if in_array('position', $error)}
                <div class="alert alert-danger">
                    <p>{l s='Position incorrecte.' mod='julienramard'}</p>
                </div>
            {/if}

            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        {l s='Position' mod='julienramard'}
                    </h4>
                    <div class="form-group">
                        <div class="margin-form">
                            <select name="position" id="position">
                                <option value="">
                                    > {l s='Select a position' mod='julienramard'}
                                </option>
                                <option value="1">
                                    {l s='Left' mod='julienramard'}
                                </option>
                                <option value="2">
                                    {l s='Right' mod='julienramard'}
                                </option>
                                <option value="3">
                                    {l s='Footer' mod='julienramard'}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="panel-footer">
            <input type="submit" value="{l s='Save' mod='julienramard'}">
        </footer>
    </form>

</main>