{*
 * Vista Gestione Film
 * 
 * Mostra la tabella di amministrazione dei soli film, con strumenti per la modifica,
 * l'eliminazione ed il filtraggio.
 * Estende `admin/mainAdmin.tpl`.
 * 
 * @package View/Templates/Admin
 * @author Marco Viscovo
 * 
 * @param EFilm[] $film L'elenco di tutti i film a catalogo.
 *}
{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    {include file="components/listaContenuti.tpl" elementi=$film titoloPagina="Gestione Film" tipoPredefinito="film"}
{/block}