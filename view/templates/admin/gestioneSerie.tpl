{*
 * Vista Gestione Serie TV
 * 
 * Mostra la tabella di amministrazione delle sole serie TV, con strumenti per la modifica,
 * l'eliminazione e la gestione stagioni.
 * Estende `admin/mainAdmin.tpl`.
 * 
 * @package View/Templates/Admin
 * @author Marco Viscovo
 * 
 * @param ESerie[] $serie L'elenco di tutte le serie TV a catalogo.
 *}
{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    {include file="components/listaContenuti.tpl" elementi=$serie titoloPagina="Gestione Serie" tipoPredefinito="serie"}
{/block}