{if isset($message) && $message !== ""}
    {if isset($type) && $type === "success"}
        <div
            class="w-full p-3 mb-4 text-xs font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-center">
            {$message}
        </div>
    {else}
        <div
            class="w-full p-3 mb-4 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl text-center">
            {$message}
        </div>
    {/if}
{/if}