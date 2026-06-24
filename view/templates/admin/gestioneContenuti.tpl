{*
 * Vista Gestione Contenuti Globale
 * 
 * Mostra l'interfaccia di amministrazione generale per i contenuti,
 * includendo la gestione film e serie TV.
 * Estende `admin/mainAdmin.tpl`.
 * 
 * @package View/Templates/Admin
 * @author Marco Viscovo
 * 
 * @param EContenuto[] $contenuti L'elenco di tutti i contenuti presenti a catalogo.
 *}
{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    {include file="components/listaContenuti.tpl" elementi=$contenuti titoloPagina="Gestione Contenuti"}
{/block}